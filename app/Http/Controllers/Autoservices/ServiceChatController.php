<?php

namespace App\Http\Controllers\Autoservices;

use App\Models\User;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class ServiceChatController extends Controller
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

    public function index()
    {
        $user = auth()->user();

        if ($user->role == 3 && $user->dealer_id) {
            $user = User::find($user->dealer_id);
            if($user && $user->shop_pkg && ($user->shop_pkg->metadata->chat_allowed == '1' || $user->shop_pkg->metadata->chat_allowed == 1)){
                
                return view('user.chats.service_chat', compact('user'));
            }
        }
        
        return view('user.chats.service_chat', compact('user'));
    }

    public function createChat(Request $request)
    {
        // dd($request->all());
        try {
            $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('id', $request->shop_id)->first();




            // dd($shop);

            // Check if car exists
            if (!$shop) {
                return response()->json(["success" => false, "message" => "shop not found"], 404);
            }

            // Get authenticated user
            $sender = Auth::user();
            if (!$sender) {
                return response()->json(["success" => false, "message" => "User not authenticated"], 401);
            }

            // Validate receiver (dealer)
            if (!$shop->dealer_id) {
                return response()->json(["success" => false, "message" => "shop dealer not found"], 404);
            }

            $receiver = User::find($shop->dealer_id);
            if (!$receiver) {
                return response()->json(["success" => false, "message" => "Dealer user not found"], 404);
            }

            // Ensure consistent order of user IDs
            $users = [(int) $sender->id, (int) $receiver->id];
            sort($users);

            // Fetch existing chats from Firestore
            try {
                $queryUrl = "{$this->firestoreUrl}/service_chats?key={$this->firestoreKey}";
                $existingChatsResponse = Http::get($queryUrl)->json();

                // Check for existing chat
                if (isset($existingChatsResponse['documents']) && is_array($existingChatsResponse['documents'])) {
                    foreach ($existingChatsResponse['documents'] as $chat) {
                        try {
                            if (
                                !isset($chat['fields']['keys']['arrayValue']['values']) ||
                                !isset($chat['fields']['shop']['mapValue']['fields']['id']['integerValue'])
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
                            $chatshopId = (int) $chat['fields']['shop']['mapValue']['fields']['id']['integerValue'];
                            // dd($chatshopId);


                            // Compare chat users and car ID
                            if ($chatUsers === $users && $chatshopId === (int) $shop->id) {
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
            $chatData = $this->prepareChatData($shop, $sender, $receiver);
            // dd($chatData);
            log::info($chatData);

            // Create new chat in Firestore
            try {
                $createChatResponse = Http::post("{$this->firestoreUrl}/service_chats?key={$this->firestoreKey}", $chatData);

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


    private function prepareChatData($shop, $sender, $receiver)
    {
        // Initialize arrays
        $featuresArray = [];
        $documentsArray = [];
        $contactArray = [];
        $dealerArray = [];



        if (!empty($shop->dealer_id)) {
            $dealer = User::find($shop->dealer_id);

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



        $imageUrl = url('/') . '/web/images/Final Logo.svg'; // Default image
        if ($shop->logo) {
            $imageUrl = $shop->logo;
        }


        // Prepare complete chat data
        return [
            "fields" => [
                "shop" => [
                    "mapValue" => [
                        "fields" => [
                            "id" => ["integerValue" => (int) $shop->id],
                            "poster" => ["stringValue" => $imageUrl ?? ""],
                            "title" => ["stringValue" => $shop->name ?? ""],

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
}
