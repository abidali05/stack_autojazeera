<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\FirebaseChatAttachments;

class ChatController extends Controller
{
    private $firestoreUrl;
    private $firestoreKey;
    private $firebaseDatabaseUrl;


    public function __construct()
    {
        $this->firestoreUrl = "https://firestore.googleapis.com/v1/projects/" . 'finder-app-be8d5' . "/databases/(default)/documents";
        $this->firestoreKey = env('FIREBASE_API_KEY');
        $this->firebaseDatabaseUrl = "https://" . 'finder-app-be8d5' . "-default-rtdb.firebaseio.com";
    }

    public function setUserPresence(Request $request)
    {

        // $user = Auth::user();
        // $state = $request->state;

        // $userData = [
        //     "id" => $user->id,
        //     "name" => $user->name,
        //     "email" => $user->email,
        //     "image" => $user->image ? url('web/profile/' . $user->image) : '',
        //     "last_seen" => time() * 1000, // Convert to milliseconds timestamp
        //     "platform" => 'web',
        //     "state" => $state,
        //     "fcm_token" => $user->fcm_token ?? '',
        // ];

        // Http::put("{$this->firebaseDatabaseUrl}/users/{$user->id}.json", $userData);
    }

    public function createChat(Request $request)
    {
        // dd($request->all());
        try {
            // Fetch the car with relationships
            if ($request->vehicle_type == 'car') {
                $car = Post::with([
                    'feature.mainfeature',
                    'document',
                    'location',
                    'contact',
                    'dealer'
                ])->where(['status' => 1, 'id' => $request->car_id])->first();
            } else {
                $car = BikePost::with([
                    'media',
                    'features',
                    'location',
                    'dealer'
                ])->where(['status' => 1, 'id' => $request->car_id])->first();
            }



            // dd($car);

            // Check if car exists
            if (!$car) {
                return response()->json(["success" => false, "message" => "Car not found"], 404);
            }

            // Get authenticated user
            $sender = Auth::user();
            if (!$sender) {
                return response()->json(["success" => false, "message" => "User not authenticated"], 401);
            }

            // Validate receiver (dealer)
            if (!$car->dealer_id) {
                return response()->json(["success" => false, "message" => "Car dealer not found"], 404);
            }

            $receiver = User::find($car->dealer_id);
            if (!$receiver) {
                return response()->json(["success" => false, "message" => "Dealer user not found"], 404);
            }

            // Ensure consistent order of user IDs
            $users = [(int) $sender->id, (int) $receiver->id];
            sort($users);

            // Fetch existing chats from Firestore
            try {
                $queryUrl = "{$this->firestoreUrl}/chats?key={$this->firestoreKey}";
                $existingChatsResponse = Http::get($queryUrl)->json();

                // Check for existing chat
                if (isset($existingChatsResponse['documents']) && is_array($existingChatsResponse['documents'])) {
                    foreach ($existingChatsResponse['documents'] as $chat) {
                        try {
                            if (
                                !isset($chat['fields']['keys']['arrayValue']['values']) ||
                                !isset($chat['fields']['vehicle']['mapValue']['fields']['id']['integerValue'])
                            ) {
                                continue;
                            }

                            // Extract and sort users
                            $chatUsers = array_map(function ($user) {
                                return isset($user['integerValue']) ? (int) $user['integerValue'] : null;
                            }, $chat['fields']['keys']['arrayValue']['values']);

                            // Skip if any user is null
                            if (in_array(null, $chatUsers, true)) {
                                continue;
                            }

                            sort($chatUsers);
                            // dd($chatUsers);

                            // Extract car ID
                            $chatCarId = (int) $chat['fields']['vehicle']['mapValue']['fields']['id']['integerValue'];
                            // dd($chatCarId);


                            // Compare chat users and car ID
                            if ($chatUsers === $users && $chatCarId === (int) $car->id) {
                                return response()->json([
                                    "success" => true,
                                    "message" => "Chat already exists",
                                    "chat_id" => $chat['name']
                                ]);
                            }
                        } catch (\Exception $e) {
                            // Log error but continue checking other chats
                            Log::error('Error processing chat document', [
                                'chat_id' => $chat['name'] ?? 'unknown',
                                'error' => $e->getMessage()
                            ]);
                            continue;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch existing chats', ['error' => $e->getMessage()]);
                return response()->json([
                    "success" => false,
                    "message" => "Failed to check existing chats",
                    "error" => $e->getMessage()
                ], 500);
            }

            // Prepare chat data
            $chatData = $this->prepareChatData($car, $sender, $receiver, $request->vehicle_type);
            // dd($chatData);
            log::info($chatData);

            // Create new chat in Firestore
            try {
                $createChatResponse = Http::post("{$this->firestoreUrl}/chats?key={$this->firestoreKey}", $chatData);
                
                if ($createChatResponse->successful()) {
                    return response()->json([
                        "success" => true,
                        "message" => "Chat created successfully",
                        "chat_id" => $createChatResponse->json()["name"] ?? null
                    ]);
                } else {
                    Log::error('Failed to create chat', ['response' => $createChatResponse->json()]);
                    return response()->json([
                        "success" => false,
                        "message" => "Failed to create chat",
                        "error_details" => $createChatResponse->json()
                    ], $createChatResponse->status());
                }
            } catch (\Exception $e) {
                Log::error('Exception during chat creation', ['error' => $e->getMessage()]);
                return response()->json([
                    "success" => false,
                    "message" => "Failed to create chat due to an exception",
                    "error" => $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Unexpected error in createChat', ['error' => $e->getMessage()]);
            return response()->json([
                "success" => false,
                "message" => "An unexpected error occurred",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Prepare chat data for Firestore
     * 
     * @param Post $car
     * @param User $sender
     * @param User $receiver
     * @return array
     */
    private function prepareChatData($car, $sender, $receiver, $type)
    {
        // Initialize arrays
        $featuresArray = [];
        $documentsArray = [];
        $contactArray = [];
        $dealerArray = [];



        if (!empty($car->dealer)) {
            $dealer = $car->dealer;

            $dealerArray = [
                "mapValue" => [
                    "fields" => [
                        "id" => ["integerValue" => (int) $dealer->id],
                        "name" => ["stringValue" => $dealer->name ?? ""],
                        "email" => ["stringValue" => $dealer->email ?? ""],
                        "number" => !empty($dealer->number) ? ["stringValue" => $dealer->number] : ["nullValue" => null],
                        "address" => ["stringValue" => $dealer->address ?? ""],
                        "city" => ["integerValue" => (int) ($dealer->city ?? 0)],
                        "cityname" => ["stringValue" => $dealer->cityname ?? ""],
                        "dealershipName" => ["stringValue" => $dealer->dealershipName ?? ""],
                        "image_path" => !empty($dealer->image)
                            ? ["stringValue" => url('web/profile/' . $dealer->image)]
                            : ["nullValue" => null],
                        "state" => ["stringValue" => "Offline"]
                    ]
                ]
            ];
        } else {
            $dealerArray = ["mapValue" => ["fields" => []]]; // Prevent Firestore from receiving an empty object
        }


        if ($type == 'car') {
            // Get image URL with proper error handling
            $imageUrl = url('/') . '/web/images/Final Logo.svg'; // Default image
            if ($car->document && $car->document->count() > 0 && isset($car->document[0]->doc_name) && $car->document[0]->doc_name) {
                $imageUrl = url('posts/doc/') . '/' . $car->document[0]->doc_name;
            }
        }
        if ($type == 'bike') {
            $imageUrl = url('/') . '/web/images/Final Logo.svg'; // Default image
            if ($car->media && $car->media->count() > 0 && isset($car->media[0]->file_path) && $car->media[0]->file_path) {
                $imageUrl = $car->media[0]->file_path;
            }
        }

        // Prepare complete chat data
        return [
            "fields" => [
                "vehicle" => [
                    "mapValue" => [
                        "fields" => [
                            "category" => ["stringValue" => $type ?? ""],
                            "id" => ["integerValue" => (int) $car->id],
                            "poster" => ["stringValue" => $imageUrl ?? ""],
                            "title" => ["stringValue" => $car->makename . " " . $car->modelname . " (" . $car->year . ")" ?? ""],
                            "price" => ["stringValue" => (string)$car->price ?? ""],

                        ]
                    ]
                ],
                "timestamp" => ["timestampValue" => now()->toIso8601String()],
                "keys" => [
                    "arrayValue" => [
                        "values" => [
                            ["integerValue" => (int) $sender->id],
                            ["integerValue" => (int) $receiver->id]
                        ]
                    ]
                ],
                "sender" => [
                    "mapValue" => [
                        "fields" => [
                            "dealer_id" => ["integerValue" => (int) ($sender->dealer_id ?? 0)],
                            "email" => ["stringValue" => $sender->email ?? ""],
                            "id" => ["integerValue" => (int) ($sender->id ?? 0)],
                            "image" => ["stringValue" => $sender->image ? url('web/profile/') . '/' . $sender->image : ""],
                            "name" => ["stringValue" => $sender->name ?? ""],
                            "state" => ["stringValue" => "Online"],
                            "platform" => ["stringValue" => "web"],
                            "fcm_token" => ["stringValue" => $sender->fcm_token ?? '']
                        ]
                    ]
                ],
                "receiver" => [
                    "mapValue" => [
                        "fields" => [
                            "dealer_id" => ["integerValue" => (int) ($receiver->dealer_id ?? 0)],
                            "email" => ["stringValue" => $receiver->email ?? ""],
                            "id" => ["integerValue" => (int) ($receiver->id ?? 0)],
                            "image" => ["stringValue" => $receiver->image ? url('web/profile/') . '/' . $receiver->image : ""],
                            "name" => ["stringValue" => $receiver->name ?? ""],
                            "state" => ["stringValue" => "Offline"],
                            "platform" => ["stringValue" => "web"],
                            "fcm_token" => ["stringValue" => $receiver->fcm_token ?? '']
                        ]
                    ]
                ]

            ]
        ];
    }



    public function getUserChats(Request $request)
    {
        $user = Auth::user();
        $userId = (int)$user->id;

        // Get all chats from Firestore
        $response = Http::get("{$this->firestoreUrl}/chats?key={$this->firestoreKey}");
        $data = $response->json();

        // Check if documents key exists in response
        if (!isset($data["documents"]) || !is_array($data["documents"])) {
            return response()->json([
                "success" => false,
                "message" => "Failed to retrieve chats",
                "data" => []
            ]);
        }

        $chats = $data["documents"];
        $userChats = [];

        foreach ($chats as $chat) {
            // Skip if the chat doesn't have the expected structure
            if (!isset($chat["fields"]["users"]["arrayValue"]["values"])) {
                continue;
            }

            // Extract user IDs from the chat
            $chatUsers = [];
            foreach ($chat["fields"]["users"]["arrayValue"]["values"] as $userValue) {
                if (isset($userValue["integerValue"])) {
                    $chatUsers[] = (int)$userValue["integerValue"];
                }
            }

            // Check if the current user's ID is in the chat's users array
            if (in_array($userId, $chatUsers)) {
                $userChats[] = $chat;
            }
        }

        return response()->json([
            "success" => true,
            "message" => "User chats retrieved successfully",
            "data" => $userChats
        ]);
    }


    public function showChatPage($chatKey)
    {
        // Log request to debug

        $firestoreUrl = "https://firestore.googleapis.com/v1/projects/" . 'finder-app-be8d5' . "/databases/(default)/documents:runQuery?key={$this->firestoreKey}";

        $response = Http::post($firestoreUrl, [
            "structuredQuery" => [
                "from" => [["collectionId" => "chats"]],
                "where" => [
                    "fieldFilter" => [
                        "field" => ["fieldPath" => "key"],
                        "op" => "EQUAL",
                        "value" => ["stringValue" => $chatKey]
                    ]
                ],
                "limit" => 100
            ]
        ]);

        $messagesData = $response->json();


        $chatData = $response->json();
        // dd($chatData);

        if (isset($chatData["error"])) {
            return response()->json([
                "success" => false,
                "message" => "Firestore error",
                "error_details" => $chatData["error"]
            ], 500);
        }

        // Extract chat messages
        $messages = [];
        foreach ($chatData as $chat) {
            if (!isset($chat["document"])) continue;

            $fields = $chat["document"]["fields"];
            $sender = User::find($fields["sender"]["mapValue"]["fields"]["id"]["integerValue"]);
            $sender->image = $sender->image ? url('web/profile/') . '/' . $sender->image : '';
            $messages[] = [
                "id" => $chat["document"]["name"],
                "message" => $fields["message"]["stringValue"] ?? "",
                "sender" => $sender ?? null,
                "timestamp" => $fields["timestamp"]["timestampValue"] ?? null,
                "file_url" => $fields["file_url"]["stringValue"] ?? null,
            ];
        }

        return response()->json(["success" => true, "messages" => $messages]);
    }




    // public function sendMessasge(Request $request)
    // {
    //     $messageData = [
    //         "fields" => [
    //             "id" => ["integerValue" => auth()->id()],
    //             "key" => ["stringValue" => $request->chat_id],
    //             "message" => ["stringValue" => $request->message],
    //             "timestamp" => ["timestampValue" => now()],
    //             "sender" => ["mapValue" => ["fields" => [
    //                 "id" => ["integerValue" => auth()->id()],
    //                 "name" => ["stringValue" => auth()->user()->name]
    //             ]]]
    //         ]
    //     ];

    //     $response = Http::post("{$this->firestoreUrl}/users/{$request->chat_id}/chats?key={$this->firestoreKey}", $messageData);
    //     return response()->json($response->json());
    // }


    public function sendMessasge(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string',
            'message' => 'required|string',
            'car_id' => 'required|integer',
            'file' => 'nullable|file|max:20480',
        ]);

        $user = Auth::user();
        $messageId = uniqid(); // Generate a unique ID for the message document
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('firebase_chat_attachments'), $filename);

            $url = url('firebase_chat_attachments/' . $filename);

            $firebaseChatAttachment = new FireBaseChatAttachments;
            $firebaseChatAttachment->url = $url;
            $firebaseChatAttachment->save();
        }
        // Prepare message data for Firestore (as a new document in `chats`)
        log::info('sending message');
        $messageData = [
            "fields" => [
                "id" => ["integerValue" => (int)$request->car_id],
                "is_receive" => ["booleanValue" => false],
                "is_send" => ["booleanValue" => true],
                "key" => ["stringValue" => $request->chat_id],
                "message" => ["stringValue" => $request->message],
                "file_url" => ["stringValue" => $url ?? ''],
                "plateform" => ["stringValue" => "web"],
                "sender" => ["mapValue" => ["fields" => [
                    "dealer_id" => ["integerValue" => (int)($user->dealer_id ?? 0)],
                    "email" => ["stringValue" => $user->email ?? ""],
                    "fcm_token" => ["stringValue" => $user->fcm_token ?? ""],
                    "image" => ["stringValue" => url('  web/profile/') . $user->image ?? ""],
                    "id" => ["integerValue" => (int)$user->id],
                    "name" => ["stringValue" => $user->name ?? ""],
                    "plateform" => ["stringValue" => "web"],
                    "state" => ["stringValue" => "Online"],
                ]]],
                "timestamp" => ["timestampValue" => now()->toIso8601String()],
            ]
        ];

        // Firestore API URL to create a document in the `chats` collection
        $firestoreUrl = "{$this->firestoreUrl}/chats/{$messageId}?key={$this->firestoreKey}";
        log::info('message sent');
        // Store message in the `chats` collection
        $response = Http::patch($firestoreUrl, $messageData);

        if ($response->successful()) {
            return response()->json([
                "success" => true,
                "message" => "Message stored successfully",
                "message_id" => $messageId
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to store message",
                "error_details" => $response->json()
            ], $response->status());
        }
    }


    public function index()
    {
        return view('user.chats.index');
    }
}
