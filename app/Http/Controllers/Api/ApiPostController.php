<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Product;
use App\Models\Post;
use App\Models\User;
use Stripe\Customer;
use App\Mail\Contact;
use App\Mail\New_lead;
use App\Models\Feature;
use App\Models\Document;
use App\Models\location;
use Stripe\Subscription;
use App\Models\ContactUs;
use App\Models\Whishlist;
use App\Models\PriceAlert;
use App\Models\ContactInfo;
use App\Models\MainFeature;
use Illuminate\Support\Env;
use App\Mail\PriceAlertMail;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\DealerContact;
use App\Models\Notifications;
use App\Models\SubmittedForm;

use App\Mail\DealerContactMail;
use App\Models\AdsSubscriptions;
use App\jobs\SendFcmNotification;
use App\Models\DeallerSubscription;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Lcobucci\JWT\Validation\ValidAt;
use App\Models\FirebaseChatAttachments;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\AutoServices\ServiceSubscriptions;


class ApiPostController extends Controller
{
    public function store(Request $request)
    {
        Log::info($request->all());
        //dd($request->all());
        $validationRules = [];


        $validationRules = array_merge($validationRules, [
            // 'dealer' => 'required',
            // 'title' => 'required',
            'condition' => 'required',
            'assembly' => 'required',
            // 'dealerType' => 'required',
            'price' => 'required',
            'makecompany' => 'required',
            'model' => 'required',
            'year' => 'required',
            'mileage' => 'required',
            'bodyType' => 'required',
            'doorcount' => 'required',
            'fuelType' => 'required',
            'seatingCapacity' => 'required',
            'engineCapacity' => 'required',
            'transmission' => 'required',
            // 'driveType' => 'required',
            'exterior_color' => 'required',


            'Features' => 'required',
            'Features.*'   => 'integer|exists:main_features,id',

            'filedata' => 'nullable',
            // 'filedata.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi',



            // 'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            // 'street_address' => 'required',


            // 'firstName' => 'required',
            // 'secondName' => 'required',
            // 'email' => 'required|email',
            // 'area' => 'required',
            'number' => 'nullable|string',
        ]);

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $post = new Post;

        // dd($request->all());
        // Log::info($request->all());
        // Handle document_auction
        if ($request->document_auction) {
            $auctionData = $request->document_auction;



            // Check if a new file is provided for upload
            if (isset($auctionData['path']) && $auctionData['path'] instanceof \Illuminate\Http\UploadedFile) {
                $auctionFile = $auctionData['path'];
                if ($auctionFile->isValid()) {
                    $auctionFilename = now()->format('His') . '_' . $auctionFile->getClientOriginalName();
                    $auctionFile->move(public_path('posts/auction/'), $auctionFilename);



                    $post->document_auction = $auctionFilename; // Save the new filename
                }
            }
        }

        // Handle document_brochure
        if ($request->document_brochure) {
            $brochureData = $request->document_brochure;


            // Check if a new file is provided for upload
            if (isset($brochureData['path']) && $brochureData['path'] instanceof \Illuminate\Http\UploadedFile) {
                $brochureFile = $brochureData['path'];
                if ($brochureFile->isValid()) {
                    $brochureFilename = now()->format('His') . '_' . $brochureFile->getClientOriginalName();
                    $brochureFile->move(public_path('posts/brochure/'), $brochureFilename);


                    $post->document_brochure = $brochureFilename; // Save the new filename
                }
            }
        }


        $post->fill([

            'title' => 'none',
            'condition' => $request->condition,
            'assembly' => $request->assembly,
            'company_conection' => $request->dealerType,
            'currency' => 'PKR',
            'price' => $request->price,
            'negotiated_price' => $request->negotiatedPrice,
            'make' => $request->makecompany,
            'model' => $request->model,
            'year' => $request->year,
            'milleage' => $request->mileage,
            'body_type' => $request->bodyType,
            'doors' => $request->doorcount,
            'fuel' => $request->fuelType,
            'seating_capacity' => $request->seatingCapacity,
            'engine_capacity' => $request->engineCapacity,
            'transmission' => $request->transmission,
            'drive_type' => $request->driveType,
            'exterior_color' => $request->exterior_color,
            'dealer_comment' => $request->dealer_comment,
            'submitedby' => 'dealer',
            'feature_ad' => $request->feature_ad,
            'street_address' => $request->street_address,
            // 'document_brocuhre' => $request->document_brocuhre,
            // 'document_auction' => $request->document_auction,
            // 'first_name' => 'none',
            // 'second_name' => 'none'
            'registered' => $request->registered,
            'latitude' => $request->latitude,
            'longitude' => $request->registered,
        ]);

        $user = User::find($request->dealer_id);
        // $userId = $request->dealer_id;

        $userId = $user->role == 2 ? $user->dealer_id : $user->id;

        $dealer = User::find($userId);

        Log::info($userId);
        // $userId = $request->dealer_id;
        // $subscription = AdsSubscriptions::where('user_id', $userId)->orderBy('id', 'desc')->first();

        // // dd($subscription);
        // $plan = AdsSubscriptionPlans::where('id', $subscription->plan_id)->first();

        // Check valid Stripe subscription
        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($dealer);

        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;
        $plan = null;

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            try {
                $sub = Subscription::retrieve($subscriptionId);
                $type = $sub->metadata['sub_type'] ?? null;

                if ($type === 'ads') {
                    $end = $sub->current_period_end ?? null;
                    $status = $sub->status;

                    if (($status === 'active' || $status === 'trialing') && $end && Carbon::now()->lt(Carbon::createFromTimestamp($end))) {
                        $hasValidAdSubscription = true;
                        $plan = Product::retrieve($sub->items->data[0]->price->product);
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription || !$plan) {
            return response()->json(['message' => 'Your subscription is invalid or expired.', 'status' => 422], 422);
        }
        // dd($plan);
        $posted_ads = Post::where('dealer_id', $userId)->where('feature_ad', '1')->count();
        $posted_ads2 = BikePost::where('dealer_id', $userId)->where('is_featured', '1')->count();
        $total_ads = $posted_ads + $posted_ads2;

        if ($plan->metadata->allowed_feature_ads !== 'unlimited') {
            // dd($plan->allowed_ads);
            if ($total_ads >= (int)$plan->metadata->allowed_feature_ads) {
                $post->feature_ad = 0;
            } else {
                $post->feature_ad = $validatedData['feature_ad'] ?? 0;
            }
        }


        if ($user->role == 2) {
            $post->employee_id = $user->id;
            $post->dealer_id = $user->dealer_id;
        } else {
            $post->employee_id = null;
            $post->dealer_id = $user->id;
        }
        $post->save();



        if (isset($request->Features)) {
            $this->handleFeatures($post->id, $request->Features);
        }


        // $this->validateStep($request, ['filedata' => 'required']);
        // dd($request->filedata);
        if (is_array($request->filedata) && count($request->filedata) > 0) {
            $this->handleFileUpload($post->id, $request->filedata);
        } else {
            return response()->json(['message' => 'No valid files uploaded'], 400);
        }


        // if ($request->file('document_brocuhre') || $request->file('document_auction')) {
        //     $this->handleDocuments($post->id, $request);
        // }


        $this->handleLocation($post->id, $request);



        $this->handleContactInfo($post->id, $request);
        // $this->updatePostStatus();

        $p = Post::where(['submitedby' => 'dealer'])->with(['feature', 'document', 'location', 'contact'])->find($post->id);
        $check = Whishlist::where('post_id', $p->id)->where('status', 1)->first();

        if ($check) {
            $p->favorite = 1;
        } else {
            $p->favorite = 0;
        }
        $user = User::find($p->dealer_id);
        $user->ads_count += 1;
        $user->save();
        $user1 = User::find($request->dealer_id);
        $user1->free_package_availed = (int)$user1->free_package_availed;

        return response()->json(['message' => 'Post Added Successfully!', 'status' => 200, 'data' => $user1], 200);
    }

    private function handleStepFour($post, $request) {}

    private function handleFeatures($postId, $features)
    {
        foreach ($features as $featureId) {
            // dd($featureId);
            $data = MainFeature::find($featureId);
            // dd($data);
            if ($data) {
                Feature::updateOrCreate(
                    ['post_id' => $postId, 'feature_id' => $data->id],
                    ['feature_name' => $data->Sub_feature, 'status' => 1, 'feature' => $data->feature]
                );
            }
        }
    }

    private function handleDocuments($postId, $request)
    {
        $this->uploadDocument($postId, $request->file('document_brochure'), 'Brochure Document');
        $this->uploadDocument($postId, $request->file('document_auction'), 'Auction Document');
    }

    private function uploadDocument($postId, $file, $type)
    {
        if ($file) {
            $filename = now()->format('His') . $file->getClientOriginalName();
            $file->move(public_path('posts/doc/'), $filename);
            Document::create([
                'post_id' => $postId,
                'doc_name' => $filename,
                'doc_type' => $type,
            ]);
        }
    }

    private function handleLocation($postId, $request)
    {
        location::updateOrCreate(
            ['post_id' => $postId],
            [
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'area' => $request->area,
                'address' => $request->street_address,
            ]
        );
    }

    private function handleContactInfo($postId, $request)
    {
        ContactInfo::updateOrCreate(
            ['post_id' => $postId],
            [
                'first_name' => $request->firstName,
                'last_name' => $request->secondName,
                'email' => $request->email,
                'number' => $request->number,
                'website' => $request->website ?? 'https://autojazera.pk/',
                'linkedIn' => $request->linkedin,
                'twitter' => $request->twitter,
            ]
        );
    }

    private function updatePostStatus()
    {
        $post = Post::where(['submitedby' => 'dealer', 'status' => 2])->latest()->first();
        if ($post) {
            $post->status = 0;
            $post->save();
        }
    }

    private function validateStep($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    }

    private function handleFileUpload($postId, $filedata)
    {
        foreach ($filedata as $fileEntry) {


            if ($fileEntry['type'] === 'file' && $fileEntry['path'] instanceof \Illuminate\Http\UploadedFile) {

                if ($fileEntry['path']->isValid()) {
                    $filename = uniqid() . '.' . $fileEntry['path']->getClientOriginalExtension();
                    $fileEntry['path']->move(public_path('posts/doc/'), $filename);
                    $thumbnail = $fileEntry['thumbnail'] === 'false' ? 0 : 1;
                    $fileExtension = strtolower($fileEntry['path']->getClientOriginalExtension());
                    $docType = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($fileExtension, ['mp4', 'mov', 'avi']) ? 'video' : 'other');

                    $doc = new Document();
                    $doc->post_id = $postId;
                    $doc->doc_name = $filename;
                    $doc->doc_type = $docType;
                    $doc->thumbnail = $thumbnail;
                    $doc->save();
                }
            }
        }
    }

    private function handleFileUpdate($postId, $filedata)
    {

        $existingDocs = Document::where('post_id', $postId)->get();
        foreach ($filedata as $fileEntry) {

            // Check if the file type is URL
            if ($fileEntry['type'] === 'url') {

                // If it's a URL, ensure the record exists in the database
                if (!is_null($fileEntry['id'])) {
                    // log::info($fileEntry['id']);
                    $document = Document::find($fileEntry['id']);
                    $thumbnail = $fileEntry['thumbnail'] === 'false' ? 0 : 1;
                    $document->thumbnail = $thumbnail;
                    $document->save();
                }
                continue; // Skip further processing for URLs
            }

            // Process uploaded files (type: file)
            if ($fileEntry['type'] === 'file' && $fileEntry['path'] instanceof \Illuminate\Http\UploadedFile) {
                // log::info('file');
                if ($fileEntry['id'] == 'null') {

                    // New file, create a new record
                    if ($fileEntry['path']->isValid()) {
                        $filename = uniqid() . '.' . $fileEntry['path']->getClientOriginalExtension();
                        $fileEntry['path']->move(public_path('posts/doc/'), $filename);
                        $thumbnail = $fileEntry['thumbnail'] === 'false' ? 0 : 1;
                        $fileExtension = strtolower($fileEntry['path']->getClientOriginalExtension());
                        $docType = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($fileExtension, ['mp4', 'mov', 'avi']) ? 'video' : 'other');

                        $doc = new Document();
                        $doc->post_id = $postId;
                        $doc->doc_name = $filename;
                        $doc->doc_type = $docType;
                        $doc->thumbnail = $thumbnail;
                        $doc->save();
                    }
                } else {

                    // Existing file, update the record
                    $document = Document::find($fileEntry['id']);
                    if ($document && $fileEntry['path']->isValid()) {
                        // Delete the old file
                        $oldFile = public_path('posts/doc/' . $document->doc_name);
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }

                        // Save the new file
                        $filename = uniqid() . '.' . $fileEntry['path']->getClientOriginalExtension();
                        $fileEntry['path']->move(public_path('posts/doc/'), $filename);

                        $fileExtension = strtolower($fileEntry['path']->getClientOriginalExtension());
                        $docType = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($fileExtension, ['mp4', 'mov', 'avi']) ? 'video' : 'other');
                        $thumbnail = $fileEntry['thumbnail'] === 'false' ? 0 : 1;
                        $document->doc_name = $filename;
                        $document->doc_type = $docType;
                        $document->thumbnail = $thumbnail;
                        $document->save();
                    } else {
                        $thumbnail = $fileEntry['thumbnail'] === 'false' ? 0 : 1;
                        $document->thumbnail = $thumbnail;
                        $document->save();
                    }
                    // log::info($$document);
                }
            }
        }

        // Handle deletion of documents no longer referenced in `filedata`
        // foreach ($existingDocs as $oldDoc) {
        //     if (!collect($filedata)->pluck('id')->contains($oldDoc->id)) {
        //         // Delete old file if not in the current filedata
        //         $oldFile = public_path('posts/doc/' . $oldDoc->doc_name);
        //         if (file_exists($oldFile)) {
        //             unlink($oldFile);
        //         }
        //         $oldDoc->delete();
        //     }
        // }

        // Handle deletion of documents no longer referenced in `removeMeta`


    }




    public function wishlist(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        $wishlist = Whishlist::with(['user', 'post', 'post.feature', 'post.document', 'post.location', 'post.location.city', 'post.location.province', 'post.contact'])->where('user_id', $user->id)->where('status', 1)->get();
        if ($wishlist->isNotEmpty()) {
            foreach ($wishlist as $list) {
                $list->post->favorite = 1;
                $pricealertCheck = PriceAlert::where('post_id', $list->post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                if ($pricealertCheck) {
                    $list->post->price_alert = 1;
                } else {
                    $list->post->price_alert = 0;
                }
            }
            return response()->json([

                "data" => $wishlist,
                "status" => 200,
                "message" => "wishlist found"


            ], 200);
        } else {
            return response()->json([
                "data" => $wishlist,
                "status" => 200,
                "message" => "wishlist not found"


            ], 200);
        }
    }

    public function addWishlist(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        // dd($user);
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ], [
            'post_id.exists' => 'The selected post does not exist.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $existingWishlist = Whishlist::where('post_id', $request->post_id)
            ->where('user_id', $user->id)
            // ->where('status', 0)
            ->first();

        if ($existingWishlist) {
            if ($existingWishlist->status === 1) {
                return response()->json(['message' => 'Already added to wishlist', 'status' => 200]);
            }

            $existingWishlist->status = 1;
            $existingWishlist->save();
            //  if ($user->fcm_token) {
            //    $tokens[] = $user->fcm_token;
            //   $notificationInstance = new SendFcmNotification();
            //   $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Wishlist Notification', "body" => 'Added to wishlist successfully']);
            // }
            return response()->json(['message' => 'Added to wishlist successfully', 'status' => 200]);
        }

        $wishlist = Whishlist::create([
            'post_id' => $request->post_id,
            'user_id' => $user->id,
            'status' => 1,
        ]);

        // Post::where('id', $request->post_id)->update(['favorite' => 1]);
        //   if ($user->fcm_token) {
        //     $tokens[] = $user->fcm_token;
        //    $notificationInstance = new SendFcmNotification();
        //   $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Wishlist Notification', "body" => 'Added to wishlist successfully']);
        // }
        return response()->json([
            'message' => 'Post added to wishlist successfully.',
            'data' => $wishlist,
            'status' => 200
        ]);
    }

    public function clearWishlist(Request $request)
    {

        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        if ($request->has('post_id')) {
            $data = Whishlist::where('user_id', $user->id)
                ->where('post_id', $request->post_id)
                ->update(['status' => 0]);

            // Post::where('id', $request->post_id)->update(['favorite' => 0]);
            if ($data) {
                // if ($user->fcm_token != null) {
                //    $tokens[] = $user->fcm_token;
                //   $notificationInstance = new SendFcmNotification();
                //  $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Wishlist Notification', "body" => 'Wishlist item cleared successfully']);
                // }
                return response()->json(['status' => 200, 'message' => 'Wishlist item cleared successfully']);
            }
            return response()->json([
                'status' => 400,
                'message' => 'No matching wishlist item found to clear.'
            ]);
        }

        // $data = Whishlist::where('user_id', $user->id)->update(['status' => 0]);
        $wishlistIds = Whishlist::where('user_id', $user->id)->pluck('post_id');
        $data = Whishlist::where('user_id', $user->id)->update(['status' => 0]);

        // Post::whereIn('id', $wishlistIds)->update(['favorite' => 0]);

        if ($data) {
            //   if ($user->fcm_token != null) {
            //      $tokens[] = $user->fcm_token;
            //    $notificationInstance = new SendFcmNotification();
            //     $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Wishlist Notification', "body" => 'All wishlist items cleared successfully']);
            //  }
            return response()->json([
                'message' => 'All wishlist items cleared successfully.',
                'status' => 200
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'No wishlist items found to clear.'
        ]);
    }

    public function dealer_inventory(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        // dd($user);
        $posts = Post::with('feature', 'document', 'location', 'location.province', 'location.city', 'contact')->orderby('id', 'desc')->where('dealer_id', $user->id)->where('status', '!=', 2)->get();
        // $posts->each(function ($car) {
        //     $car->shareable_link = route('cardetail', ['id' => $car->id]);
        // });
        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($posts as $post) {
                    $check = Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                    $pricealertCheck = PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                    if ($pricealertCheck) {
                        $post->price_alert = 1;
                    } else {
                        $post->price_alert = 0;
                    }
                    if ($check) {
                        $post->favorite = 1;
                    } else {
                        $post->favorite = 0;
                    }
                }
            } else {


                foreach ($posts as $post) {
                    $post->favorite = 0;
                    $post->price_alert = 0;
                }
            }
            return response()->json([
                "data" => $posts,
                "status" => 200,
                "message" => $posts->count() . " posts found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 402,
                "message" => "posts not found"


            ], 402);
        }
    }

    public function my_ads(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        if ($user->role == 2) {
            $id = $user->id;
            $dealer_id = $user->dealer_id;
            // $posts = Post::with(['feature' => function ($query) {
            //     $query->with('mainfeature')->get();
            // }, 'document', 'location', 'location.province', 'location.city', 'contact', 'document', 'dealer'])->orderby('id', 'desc')->where('dealer_id', $dealer_id)->where('employee_id', $id)->get();
            $posts = Post::with(['feature' => function ($query) {
                $query->with('mainfeature')->get();
            }, 'document', 'location', 'location.province', 'location.city', 'contact', 'document', 'dealer'])->orderby('id', 'desc')->where('dealer_id', $dealer_id)->get();
        } else {
            $id = $user->id;
            $posts = Post::with(['feature' => function ($query) {
                $query->with('mainfeature')->get();
            }, 'document', 'location', 'location.province', 'location.city', 'contact', 'document', 'dealer'])->orderby('id', 'desc')->where('dealer_id', $id)->get();
        }

        // $posts = Post::with('feature', 'document', 'location', 'location.province', 'location.city', 'contact', 'document')->orderby('id', 'desc')->where('dealer_id', $id)->get();
        // $posts = Post::with('feature', 'document', 'location', 'location.province', 'location.city', 'contact', 'document')->orderby('id', 'desc')->where('status', '!=', 2)->where('dealer_id', $user->id)->get();

        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($posts as $post) {
                    $check = Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                    $pricealertCheck = PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                    if ($pricealertCheck) {
                        $post->price_alert = 1;
                    } else {
                        $post->price_alert = 0;
                    }
                    if ($check) {
                        $post->favorite = 1;
                    } else {
                        $post->favorite = 0;
                    }
                }
            } else {

                foreach ($posts as $post) {
                    $post->favorite = 0;
                    $post->price_alert = 0;
                }
            }
            return response()->json([
                "data" => $posts,
                "status" => 200,
                "message" => "posts found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 200,
                "message" => "posts not found"
            ], 200);
        }
    }

    public function submitted_form(Request $request)
    {
        // dd($request);
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'number' => 'required|string',
            'fullname' => 'required|string',
            // 'DateOfBirth' => 'required',
            // 'Time' => 'required',
            // 'Method' => 'required',
            'Comment' => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 402,], 402);
        }
        $sub = SubmittedForm::where('user_id', $request->user_id)->where('post_id', $request->post_id)->where('requesttype', $request->type)->first();
        if ($sub) {
            return response()->json([
                // "data" => $sub,
                "status" => 200,
                "message" => "Form Already Submitted"
            ], 200);
        } else {
            $sub = new SubmittedForm();
            $sub->fullname = $request->fullname;
            $sub->email = $request->email;
            $sub->post_id = $request->post_id;
            $sub->dealer_id = $request->dealer_id;
            $sub->user_id = $request->user_id;
            $sub->number = $request->number;
            $sub->requesttype = $request->type;
            if ($request->DateOfBirth) {
                $sub->dob = $request->DateOfBirth;
            }
            if ($request->Time) {
                $sub->apointment_time = $request->Time;
            }
            if ($request->friend_name) {
                $sub->friendFullname = $request->friend_name;
            }
            if ($request->friend_email) {
                $sub->friendemail = $request->friend_email;
            }
            if ($request->Method) {
                $sub->perefered_contact_method = $request->Method;
            }

            $sub->comment = $request->Comment;
            $sub->save();
            $post = Post::with('document')->find($request->post_id);
            $mainDoc = $post->document->first() ?? null;
            $post->setAttribute('image', $mainDoc ? url('posts/doc/' . $mainDoc->doc_name) : url('web/images/default-car.jpg'));
            $post->setAttribute('mileage_icon', 'bi bi-speedometer2');
            $post->setAttribute('transmission_icon', 'bi bi-car-front-fill');
            $post->setAttribute('fuel_icon', 'bi bi-fuel-pump-diesel');
            $user = User::find($request->dealer_id);
            //$body = view('emails.new_lead', compact('sub'));
            //sendmail($user->name, $user->email, 'Auto Jazeera Notification', 'You have a new Lead', $body);
            Mail::to($user->email)->send(new New_lead($post));

            $fcm_tokens = [$user->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Sales Lead', 'body' => 'New Sales Lead for ' . $post->makeName . ' ' . $post->modelname]);



                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'New Sales Lead',
                    'body' => 'New Sales Lead for ' . $post->makeName . ' ' . $post->modelname,
                    'url' => url('lead'),
                ]);
            }

            return response()->json([
                // "data" => $sub,
                "status" => 200,
                "message" => "Your form submitted successfully"
            ], 200);
        }
    }

    public function submited_form(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        $forms = SubmittedForm::with(['user', 'post.feature', 'post.document', 'post.location', 'post.location.city', 'post.location.province', 'post.contact'])->where('status', 1)->where('user_id', $user->id)->get();

        if ($forms) {
            return response()->json([
                "data" => $forms,
                "status" => 200,
                "message" => "submitted form found"


            ], 200);
        } else {
            return response()->json([
                "data" => $forms,
                "status" => 402,
                "message" => "submitted form not found"


            ], 402);
        }
    }

    public function received_form(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        if ($user->role == 2 || $user->role == '2') {
            $user_id = $user->dealer_id;
        } else {

            $user_id = $user->id;
        }

        $forms = SubmittedForm::with(['user', 'post', 'post.feature', 'post.document', 'post.location', 'post.location.city', 'post.location.province', 'post.contact'])->where('dealer_id', $user_id)->get();

        if ($forms) {
            return response()->json([
                "data" => $forms,
                "status" => 200,
                "message" => "received submitted form found"


            ], 200);
        } else {
            return response()->json([
                "data" => $forms,
                "status" => 402,
                "message" => "received submitted form not found"


            ], 402);
        }
    }

    public function ContactUs(Request $request)
    {


        $contact = new ContactUs();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->number = $request->number;
        $contact->message = $request->message;
        $contact->save();
        //$body = view('emails.contact_us', compact('contact'));
        //sendMail($contact->first_name, $contact->email, 'Auto Jazeera', 'Auto Jazera Contact', $body);
        //sendMail($contact->first_name, 'contactus@autojazeera.pk', 'Auto Jazeera', 'Auto Jazera Contact', $body);
        Mail::to($contact->email)->send(new Contact($contact));
        Mail::to('contactus@autojazeera.pk')->send(new Contact($contact));
        if ($contact) {
            return response()->json([
                "data" => $contact,
                "status" => 200,
                "message" => "Thanks for contacting us. Our team will get in touch with you"


            ], 200);
        } else {
            return response()->json([
                "data" => $contact,
                "status" => 402,
                "message" => "contact form not submitted"


            ], 402);
        }
    }

    public function find_cars(Request $request)
    {
        log::info($request->all());

        $posts = Post::query()->where('status', 1);

        $posts->when(
            $request->filled('condition') && !empty($request->condition) && $request->condition != 'both',
            fn($query) => $query->where('condition', $request->condition)
        );

        $posts->when(
            $request->filled('year.from') && $request->filled('year.to'),
            fn($query) => $query->whereBetween('year', [$request->year['from'], $request->year['to']])
        );

        $posts->when(
            $request->filled('make'),
            fn($query) => $query->where('make', $request->make)
        );

        if ($request->filled('model') && !empty($request->model)) {
            $posts->whereIn('model', (array) $request->model);
        }

        $posts->when(
            $request->filled('price.from') && $request->filled('price.to'),
            fn($query) => $query->whereBetween('price', [$request->price['from'], $request->price['to']])
        );

        if ($request->filled('engineCapacity') && !empty($request->engineCapacity)) {
            $posts->whereIn('engine_capacity', (array) $request->engineCapacity);
        }

        $posts->when(
            $request->filled('milleage.from') && $request->filled('milleage.to'),
            fn($query) => $query->whereBetween('milleage', [$request->milleage['from'], $request->milleage['to']])
        );

        if ($request->filled('province') && !empty($request->province)) {

            $post_ids = location::when($request->filled('province'), fn($q) => $q->where('province', $request->province))
                ->pluck('post_id')
                ->toArray();

            if (!empty($post_ids)) {
                $posts->whereIn('id', $post_ids);
            }
        }




        if ($request->filled('province') && !empty($request->province) && $request->filled('city') && !empty($request->city)) {
            $post_idss = location::whereIn('city', (array) $request->city)
                ->pluck('post_id')
                ->toArray();
            //   dd($post_ids);

            if (!empty($post_idss)) {
                $posts->whereIn('id', $post_idss);
            }
        }

        $posts->when(
            $request->filled('feature_ad'),
            fn($query) => $query->where('feature_ad', $request->feature_ad)
        );

        foreach (['exterior_color', 'transmission', 'fuel', 'assembly', 'doors', 'seating_capacity'] as $field) {
            if ($request->filled($field) && !empty($request->$field)) {
                $posts->whereIn($field, (array) $request->$field);
            }
        }

        if ($request->filled('bodytype') && !empty($request->bodytype)) {
            $posts->whereIn('body_type', (array) $request->bodytype);
        }

        // Log SQL Query BEFORE Executing it
        $sql = $posts->toSql();
        $bindings = $posts->getBindings();
        log::info("Generated SQL Query: $sql", $bindings);

        // Now execute the query
        $posts = $posts->with([
            'bodytype1',
            'make1',
            'location',
            'location.province',
            'location.city',
            'document',
            'contact',
            'dealer',
            'feature' => fn($query) => $query->with('mainfeature')->get(),
        ])->get();

        if ($posts->isNotEmpty()) {
            if ($request->filled('seller_type') && !empty($request->seller_type)) {
                foreach ($posts as $post) {
                    $dealers_ids[] = $post->dealer_id;
                }
                // $dealers_ids = Post::whereIn('dealer_id', $posts->dealer_id)->pluck('dealer_id')->toArray();

                $dealersQuery = User::whereIn('id', $dealers_ids);

                if ($request->seller_type == 'both') {
                    $dealersQuery->whereIn('userType', ['car_dealer', 'private_seller']);
                } else {
                    $dealersQuery->where('userType', $request->seller_type);
                }

                $dealers = $dealersQuery->pluck('id')->toArray();

                $posts = collect($posts)->whereIn('dealer_id', $dealers)->values();
            }
            // sort($posts);
        }

        $user = auth('sanctum')->user();

        $posts->each(function ($post) use ($user) {
            $post->favorite = $user ? Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->exists() : 0;
            $post->price_alert = $user ? PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->exists() : 0;
        });

        return response()->json([
            "data" => $posts,
            "status" => 200,
            "message" => $posts->isNotEmpty() ? "Posts found {$posts->count()}" : "Posts not found"
        ], 200);
    }

    public function similar_cars(Request $request)
    {
        Log::info($request->all());
        $query = Post::where('status', 1)
            ->orderBy('feature_ad', 'DESC')
            ->orderBy('created_at', 'DESC');

        if ($request->make || $request->model) {
            $query->where(function ($q) use ($request) {
                if ($request->make) {
                    $q->orWhere('make', $request->make);
                }
                if ($request->model) {
                    $q->orWhere('model', $request->model);
                }
            });
        }

        $posts = $query->with([
            'bodytype1',
            'make1',
            'location',
            'location.province',
            'location.city',
            'document',
            'dealer',
            'feature' => fn($q) => $q->with('mainfeature'),
        ])->get();

        $user = auth('sanctum')->user();

        if ($user && $posts->isNotEmpty()) {
            $postIds = $posts->pluck('id')->toArray();

            $favorites = Whishlist::whereIn('post_id', $postIds)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->pluck('post_id')
                ->toArray();

            $alerts = PriceAlert::whereIn('post_id', $postIds)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->pluck('post_id')
                ->toArray();

            foreach ($posts as $post) {
                $post->favorite = in_array($post->id, $favorites) ? 1 : 0;
                $post->price_alert = in_array($post->id, $alerts) ? 1 : 0;
            }
        } else {
            foreach ($posts as $post) {
                $post->favorite = 0;
                $post->price_alert = 0;
            }
        }

        return response()->json([
            'data' => $posts,
            'status' => $posts->isNotEmpty() ? 200 : 402,
            'message' => $posts->isNotEmpty() ? 'similar posts found' : 'similar posts not found',
        ], $posts->isNotEmpty() ? 200 : 402);
    }


    public function delete_post(Request $request)
    {
        // if (!auth('sanctum')->check()) {
        //     return response()->json([
        //         'status' => 401,
        //         'message' => 'You are not authorized to access this route'
        //     ], 401);
        // }

        $user = auth('sanctum')->user();

        if ($user) {
            $post_id = $request->id;
            $post = Post::find($post_id);

            if (!$post) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Post not found'
                ]);
            }

            // if ($post->dealer_id !== $user->id) {
            //     return response()->json([
            //         'status' => 422,
            //         'message' => 'You are not authorized to delete this post'
            //     ]);
            // }

            $post->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Post deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 501,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    public function update_post(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }

        $post = Post::find($request->id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 200);
        }

        if ($post->price != $request->price) {
            $sendfcm = true;
        } else {
            $sendfcm = false;
        }

        // Validate only non-null fields
        $validationRules = [
            'dealer_id' => 'required',
            'dealer' => 'nullable',
            // 'title' => 'nullable',
            'condition' => 'nullable',
            'assembly' => 'nullable',
            // 'dealerType' => 'nullable',
            'price' => 'nullable',
            'makecompany' => 'nullable',
            'model' => 'nullable',
            'year' => 'nullable',
            'mileage' => 'nullable',
            'bodyType' => 'nullable',
            'doorcount' => 'nullable',
            'fuelType' => 'nullable',
            'seatingCapacity' => 'nullable',
            'engineCapacity' => 'nullable',
            'transmission' => 'nullable',
            // 'driveType' => 'nullable',
            'exterior_color' => 'nullable',


            'Features' => 'required',
            'Features.*'   => 'integer|exists:main_features,id',

            'filedata' => 'nullable',
            // 'filedata.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi',



            // 'country' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            // 'street_address' => 'nullable',


            // 'firstName' => 'nullable',
            // 'secondName' => 'nullable',
            'email' => 'nullable|email',
            //  'area' => 'required',
            'number' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Merge new non-null values with existing ones
        $data = array_filter($request->only(array_keys($validationRules)), function ($value) {
            return $value !== null;
        });
        // dd($data);

        if ($request->document_auction) {
            $auctionData = $request->document_auction;

            // Handle deletion if `isDelete` is true
            if (isset($auctionData['isDelete']) && $auctionData['isDelete'] === 'true') {
                if ($post->document_auction) {
                    $existingAuctionPath = public_path('posts/auction/' . $post->document_auction);
                    if (file_exists($existingAuctionPath)) {
                        unlink($existingAuctionPath); // Delete the file
                    }
                    $post->document_auction = null; // Clear the field in the database
                }
            }

            // Handle new file upload (if `path` is not a string)
            if (isset($auctionData['path']) && !is_string($auctionData['path'])) {
                $auctionFile = $request->file('document_auction.path'); // Access file from 'path' key
                if ($auctionFile && $auctionFile->isValid()) {
                    $auctionFilename = now()->format('His') . '_' . $auctionFile->getClientOriginalName();
                    $auctionFile->move(public_path('posts/auction/'), $auctionFilename);

                    // Delete the old auction document if it exists
                    if ($post->document_auction) {
                        $existingAuctionPath = public_path('posts/auction/' . $post->document_auction);
                        if (file_exists($existingAuctionPath)) {
                            unlink($existingAuctionPath);
                        }
                    }

                    $post->document_auction = $auctionFilename; // Update with the new filename
                }
            }
        }




        if ($request->document_brochure) {
            $brochureData = $request->document_brochure;

            // Handle deletion if `isDelete` is true
            if (isset($brochureData['isDelete']) && $brochureData['isDelete'] === 'true') {
                if ($post->document_brochure) {
                    $existingBrochurePath = public_path('posts/brochure/' . $post->document_brochure);
                    if (file_exists($existingBrochurePath)) {
                        unlink($existingBrochurePath); // Delete the file
                    }
                    $post->document_brochure = null; // Clear the field in the database
                }
            }

            // Handle new file upload (if `path` is not a string)
            if (isset($brochureData['path']) && !is_string($brochureData['path'])) {
                $brochureFile = $request->file('document_brochure.path'); // Access file from 'path' key
                if ($brochureFile && $brochureFile->isValid()) {
                    $brochureFilename = now()->format('His') . '_' . $brochureFile->getClientOriginalName();
                    $brochureFile->move(public_path('posts/brochure/'), $brochureFilename);

                    // Delete the old brochure file if it exists
                    if ($post->document_brochure) {
                        $existingBrochurePath = public_path('posts/brochure/' . $post->document_brochure);
                        if (file_exists($existingBrochurePath)) {
                            unlink($existingBrochurePath);
                        }
                    }

                    $post->document_brochure = $brochureFilename; // Update with the new filename
                }
            }
        }


        $oldprice = $post->price;
        $post->fill(
            [

                'title' => 'none',
                'condition' => $request->condition,
                'assembly' => $request->assembly,
                'company_conection' => $request->dealerType,
                'currency' => $request->currency,
                // 'price' => $request->price,
                'negotiated_price' => $request->negotiatedPrice,
                'make' => $request->makecompany,
                'model' => $request->model,
                'year' => $request->year,
                'milleage' => $request->mileage,
                'body_type' => $request->bodyType,
                'doors' => $request->doorcount,
                'fuel' => $request->fuelType,
                'seating_capacity' => $request->seatingCapacity,
                'engine_capacity' => $request->engineCapacity,
                'transmission' => $request->transmission,
                'drive_type' => $request->driveType,
                'exterior_color' => $request->exterior_color,
                'dealer_comment' => $request->dealer_comment,
                'submitedby' => 'dealer',
                'feature_ad' => $request->feature_ad,
                'street_address' => $request->street_address,
                'registered' => $request->registered,
                'latitude' => $request->latitude,
                'longitude' => $request->registered,
            ]
        );

        if (isset($request->Features)) {
            $this->handleFeatures($post->id, $request->Features);
        }



        if ($request->filedata) {

            $this->handleFileUpdate($post->id, $request->filedata);
        }
        if ($request->removeMeta) {
            $removePhotos = $request->removeMeta;

            if (is_array($removePhotos)) { // Ensure it's an array
                foreach ($removePhotos as $removePhoto) {
                    if (isset($removePhoto['id']) && isset($removePhoto['path'])) { // Check if `id` and `path` exist
                        $photo = Document::find($removePhoto['id']); // Assuming `Document` is the model for these files

                        // Delete the file if it exists and the type is not a URL
                        if ($photo && filter_var($removePhoto['path'], FILTER_VALIDATE_URL)) {
                            $filePath = public_path(parse_url($removePhoto['path'], PHP_URL_PATH));

                            if (file_exists($filePath)) {
                                unlink($filePath); // Remove the file from the server
                            }

                            $photo->delete(); // Delete the database record
                        }
                    }
                }
            }
        }



        $this->handleLocation($post->id, $request);

        $this->handleContactInfo($post->id, $request);



        if ($request->has('price') && $request->price != $post->price) {
            // Store the previous price
            $post->previous_price = $oldprice;

            // Update the current price
            $post->price = $request->price;

            // Calculate the percentage difference if the previous price is not zero

            $difference = $request->price - $oldprice; // Difference between new and previous price
            $percentageChange = ($difference / $oldprice) * 100; // Calculate percentage change
            $post->percentage_diff = round($percentageChange, 2); // Round to 2 decimal places

        }

        $user = User::find($request->dealer_id);
        $userId = $user->role == 2 ? $user->dealer_id : $user->id;
        // $subscription = AdsSubscriptions::where('user_id', $userId)->orderBy('id', 'desc')->first();
        $user = User::find($userId);

        // dd($subscription);
        // $plan = AdsSubscriptionPlans::where('id', $subscription->plan_id)->first();

        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;
        $plan = null;

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            try {
                $sub = Subscription::retrieve($subscriptionId);
                $type = $sub->metadata['sub_type'] ?? null;

                if ($type === 'ads') {
                    $end = $sub->current_period_end ?? null;
                    $status = $sub->status;

                    if (($status === 'active' || $status === 'trialing') && $end && Carbon::now()->lt(Carbon::createFromTimestamp($end))) {
                        $hasValidAdSubscription = true;
                        $plan = Product::retrieve($sub->items->data[0]->price->product);
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription || !$plan) {
            return response()->json(['message' => 'Your subscription is invalid or expired.', 'status' => 422], 422);
        }
        // dd($plan);
        $posted_ads = Post::where('dealer_id', $userId)->where('feature_ad', '1')->count();
        $posted_ads2 = BikePost::where('dealer_id', $userId)->where('is_featured', '1')->count();
        $total_ads = $posted_ads + $posted_ads2;

        if ($plan->metadata->allowed_feature_ads !== 'unlimited') {
            // dd($plan->allowed_ads);
            if ($total_ads >= (int)$plan->metadata->allowed_feature_ads) {
                $post->feature_ad = 0;
            } else {
                $post->feature_ad = $validatedData['feature_ad'] ?? 0;
            }
        }
        if ($user->role == 2) {
            $post->employee_id = $user->id;
            $post->dealer_id = $user->dealer_id;
        } else {
            $post->employee_id = null;
            $post->dealer_id = $user->id;
        }

        $post->save();

        $updatedPost = Post::with(['feature', 'document', 'location', 'location.province', 'contact', 'bodyType1', 'make1', 'makecompany', 'modelcompany', 'dealer'])->find($post->id);
        $check = Whishlist::where('post_id', $updatedPost->id)->where('status', 1)->first();
        if ($check) {
            $updatedPost->favorite = 1;
        } else {
            $updatedPost->favorite = 0;
        }
        if ($sendfcm == true) {
            $user_ids = PriceAlert::where('post_id', $request->id)->where('status', 1)->pluck('user_id')->toArray();
            if (count($user_ids) > 0) {
                // dd($updatedPost->makecompany);
                $fcm_tokens = User::wherein('id', $user_ids)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                if ($fcm_tokens) {
                    // dd('zaid');
                    $this->sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert', 'body' => 'Vehicle ' . $updatedPost->makecompany->name . ' ' . $updatedPost->modelcompany->name . ' has been updated']);
                }
                $post = Post::with(['modelcompany', 'makecompany'])->where('id', $updatedPost->id)->first();
                $url = url('/');
                $url = $url . '/car-detail/' . $request->id;
                $post->url = $url;
                // $post->url = route('cardetail', $post->id);
                $post->updated_at = Carbon::parse($post->updated_at)->format('d M Y');
                foreach ($user_ids as $id) {
                    $user = User::find($id);
                    if ($user) {
                        //$body = view('emails.price_alert', compact('post'));
                        //sendMail($user->name, $user->email, 'Auto Jazeera', 'Auto Jazeera Price Alert', $body);
                        Mail::to($user->email)->send(new PriceAlertMail($post));
                    }
                }
            }
        }
        $user = User::find($request->dealer_id);
        return response()->json(['message' => 'Post update successfully', 'status' => 200, 'data' => $user], 200);
    }

    public function dealer_contact(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }

        $user = auth('sanctum')->user();
        $user_id = $user->id;

        $dealer = User::where('id', $request->dealer_id)->first();
        $dealer_id = $dealer->id;
        $dealer_email = $dealer->email;
        $dealer_name = $dealer->name;

        $dealerContact = new DealerContact();
        $dealerContact->dealer_id = $dealer_id;
        $dealerContact->user_id = $user_id;
        $dealerContact->full_name = $request->full_name;
        $dealerContact->email = $request->email;
        $dealerContact->contact_num = $request->contact_num;
        $dealerContact->message = $request->message;
        $dealerContact->save();

        if ($dealerContact) {

            Mail::to($dealer_email)->send(new DealerContactMail($dealerContact, $dealer_name));

            return response()->json([
                "data" => $dealerContact,
                "status" => 200,
                "message" => "Email sent successfully"
            ], 200);
        } else {
            return response()->json([
                "data" => $dealerContact,
                "status" => 402,
                "message" => "Email not send"
            ], 402);
        }
    }

    public function price_alert(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }

        $user = auth('sanctum')->user();
        $user_id = $user->id;

        $post_id = $request->post_id;

        $price_alert = PriceAlert::where('user_id', $user_id)->where('post_id', $post_id)->first();
        if ($price_alert) {
            $price_alert->status = $request->status;
            $price_alert->save();
            if ($request->status == 0) {
                $message = 'Price alert disabled';
            } else {
                $message = 'Price alert enabled';
            }
            // Post::where('id', $request->post_id)->update(['price_alert' => $request->status]);

            // Send notification
            // $user->notify(new PriceAlertStatusNotification('Your price alert status has been updated.'));


            //if ($user->fcm_token != null) {
            //   $notificationInstance = new SendFcmNotification();
            //  $notificationInstance->sendAddWishlistNotification($user->fcm_token, ["title" => 'Price Alert', "body" => $message]);
            // }

            if ($request->status == 0) {
                $message = 'Price alert disabled';
            } else {
                $message = 'Price alert enabled';
            }
            return response()->json([
                'message' => $message,
                'status' => 200,
            ]);
        } else {
            $newPriceAlert = PriceAlert::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'status' => $request->status,
            ]);
            if ($request->status == 0) {
                $message = 'Price alert disabled';
            } else {
                $message = 'Price alert enabled';
            }

            // Post::where('id', $request->post_id)->update(['price_alert' => $request->status]);

            // Send notification
            // $user->notify(new PriceAlertStatusNotification('A new price alert has been created.'));


            //if ($user->fcm_token != null) {
            //   $notificationInstance = new SendFcmNotification();
            //  $notificationInstance->sendAddWishlistNotification($user->fcm_token, ["title" => 'Price Alert', "body" => $message]);
            //}

            return response()->json([
                'message' => 'Price alert enabled',
                'status' => 200,
            ]);
        }
    }

    public function price_drop(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 422,
                'message' => 'You are not authorized to access this route.',
            ]);
        }

        $user = auth('sanctum')->user();
        $user_id = $user->id;
        // $post_id = $request->post_id;

        // $exists = PriceAlert::where('post_id', $post_id)->exists();

        // if (!$exists) {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'The specified post does not exist.',
        //     ]);
        // }

        $price_alerts = PriceAlert::where('user_id', $user_id)
            // ->where('post_id', $post_id)
            ->where('status', 1)
            ->get();

        if ($price_alerts->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No price alerts found for this post.',
                'data' => []
            ]);
        }

        $post_ids = $price_alerts->pluck('post_id')->filter()->unique()->toArray();

        $posts = Post::whereIn('id', $post_ids)
            ->with(['feature', 'document', 'location', 'location.province', 'location.city', 'contact', 'bodyType1', 'make1', 'dealer'])
            ->orderBy('id', 'Desc')->get();
        $user = auth('sanctum')->user();
        if ($user) {


            foreach ($posts as $post) {
                $check = Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                $pricealertCheck = PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                if ($pricealertCheck) {
                    $post->price_alert = 1;
                } else {
                    $post->price_alert = 0;
                }
                if ($check) {
                    $post->favorite = 1;
                } else {
                    $post->favorite = 0;
                }
            }
        } else {


            foreach ($posts as $post) {
                $post->favorite = 0;
                $post->price_alert = 0;
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Posts fetched successfully.',
            'data' => $posts,
        ]);
    }

    public function leads(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 422,
                'message' => 'You are not authorized to access this route.',
            ]);
        }

        $user = auth('sanctum')->user();
        if ($user->role_id == 2 || $user->role_id == '2') {
            $user_id = $user->dealer_id;
        } else {

            $user_id = $user->id;
        }

        $posts = Post::where('dealer_id', $user_id)->with(['feature', 'document', 'location', 'location.province', 'location.city', 'contact', 'bodyType1', 'make1', 'dealer'])->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No posts found.',
            ]);
        }

        $user = auth('sanctum')->user();
        if ($user) {


            foreach ($posts as $post) {
                $check = Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                $pricealertCheck = PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                if ($pricealertCheck) {
                    $post->price_alert = 1;
                } else {
                    $post->price_alert = 0;
                }

                if ($check) {
                    $post->favorite = 1;
                } else {
                    $post->favorite = 0;
                }
            }
        } else {


            foreach ($posts as $post) {
                $post->favorite = 0;
                $post->price_alert = 0;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Posts fetched successfully.',
            'posts' => $posts,
        ]);
    }

    public function delete_dealer_inventory()
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }

        $user = auth('sanctum')->user();

        $post_id = request()->id;

        if ($post_id) {
            $post = Post::find($post_id);
            if (!$post) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Post not found'
                ]);
            }

            if ($post->dealer_id !== $user->id) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You are not authorized to delete this post'
                ]);
            }

            $post->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Post deleted successfully'
            ]);
        } else {
            $deletedCount = Post::where('dealer_id', $user->id)->delete();

            return response()->json([
                'status' => 200,
                'message' => $deletedCount > 0 ? 'All posts deleted' : 'No post found'
            ]);
        }
        // dd($user);
    }

    public function delete_submited_form(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }
        // dd($request->all());
        $user = auth('sanctum')->user();

        if ($request->id) {
            $submitted_form_id = $request->id;

            if ($submitted_form_id) {
                $submitted_form = SubmittedForm::find($submitted_form_id);
                if (!$submitted_form) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Submitted form not found'
                    ]);
                }

                if ($submitted_form->user_id !== $user->id) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'You are not authorized to delete this form'
                    ]);
                }

                $submitted_form->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'Form deleted successfully'
                ]);
            }
        } else {
            SubmittedForm::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'All forms deleted'
            ]);
        }
        // dd($user);
    }

    public function plans()
    {
        $url = "https://api.stripe.com/v1/products";
        // key also in function subscription
        //  $apiKey = "sk_test_51P9UuSP2COuPjTaib6y4UhgtnfJk1uOLe1FJC7wNPu0dEwbpnlhRYtiMk0N1kqyj3PrCZhVq5jMxIbTSHv9XO28O00fcplIRdr";
        $apiKey = "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";
        $response = Http::withToken($apiKey)->get($url);

        if ($response->successful()) {
            return response()->json([
                'status' => 200,
                'data' => $response->json()['data'] ?? [],
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => $response->json('error.message', 'Unknown error occurred.'),
        ], $response->status());
    }

    // public function subscription(Request $request)
    // {
    //     if (!auth('sanctum')->check()) {
    //         return response()->json([
    //             'status' => 422,
    //             'message' => 'You are not authorized to access this route'
    //         ]);
    //     }

    //     $user = auth('sanctum')->user();

    //     if (!$user->package) {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Package not found'
    //         ]);
    //     }

    //     $packageId = $user->package;
    //     // dd($packageId);
    //     $url = "https://api.stripe.com/v1/products/" . $packageId;

    //     $apiKey = "sk_test_51P9UuSP2COuPjTaib6y4UhgtnfJk1uOLe1FJC7wNPu0dEwbpnlhRYtiMk0N1kqyj3PrCZhVq5jMxIbTSHv9XO28O00fcplIRdr";

    //     $response = Http::withToken($apiKey)->get($url);

    //     if ($response->successful()) {
    //         return response()->json([
    //             'status' => 200,
    //             'data' => $response->json(),
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 404,
    //         'message' => $response->json('error.message', 'Unknown error occurred.'),
    //     ], $response->status());
    // }


    public function subscription(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 422,
                'message' => 'You are not authorized to access this route'
            ]);
        }

        $user = auth('sanctum')->user();


        if ($user->role == '2') {
            return response()->json([
                'status' => 422,
                'message' => 'You are not authorized to access this route'
            ]);
        }

        // $ads_subscriptions = AdsSubscriptions::with('plan')->where('user_id', $user->id)->get();
        // $service_subscriptions = ServiceSubscriptions::with('plan')->where('user_id', $user->id)->get();
        // $data['ads_subscriptions'] = $ads_subscriptions;
        // $data['service_subscriptions'] = $service_subscriptions;
        Stripe::setApiKey(config('services.stripe.secret'));
        if ($user->package && $user->package != null && $user->package != '') {
            $sub1 = Product::retrieve($user->package);
        } else {
            $sub1 = null;
        }
        if ($user->shop_package && $user->shop_package != null && $user->shop_package != '') {
            $sub2 = Product::retrieve($user->shop_package);
        } else {
            $sub2 = null;
        }


        $data['ads_subscriptions'] = $sub1;
        $data['service_subscriptions'] = $sub2;

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }



    // public function budgetCars(Request $request)
    // {
    //     //dd($request->all());
    //     $posts = Post::with(['feature' => function ($query) {
    //         $query->with('mainfeature')->get();
    //     }, 'document', 'location', 'location.province', 'location.city', 'contact'])
    //         ->where(['status' => 1])
    //         ->when($request->budget, function ($query) use ($request) {
    //             return $query->whereBetween('price', [$request->from, $request->to]);
    //         })
    //         ->with(['bodytype1', 'make1', 'document', 'location', 'location.province', 'location.city', 'contact' => function ($query) use ($request) {
    //             $query->when($request->city, function ($query) use ($request) {
    //                 $query->where('city', $request->city);
    //             });
    //         }])

    //         ->get();

    //     $posts->each(function ($car) {
    //         $car->shareable_link = route('cardetail', ['id' => $car->id]);
    //     });

    //     if ($posts->isNotEmpty()) {
    //         $user = auth('sanctum')->user();
    //         if ($user) {


    //             foreach ($posts as $post) {
    //                 $check = Whishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();

    //                  $pricealertCheck = PriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
    //                 if($pricealertCheck){
    //                     $post->price_alert = 1;
    //                 }
    //                 else{
    //                     $post->price_alert = 0;
    //                 }
    //                 if ($check) {
    //                     $post->favorite = 1;
    //                 } else {
    //                     $post->favorite = 0;
    //                 }
    //             }
    //         } else {


    //             foreach ($posts as $post) {
    //             $post->favorite = 0;
    //             $post->price_alert = 0;

    //         }
    //     }
    //         return response()->json([
    //             "data" => $posts,
    //             "status" => 200,
    //             "message" => "cars found"


    //         ], 200);
    //     } else {
    //         return response()->json([
    //             "data" => $posts,
    //             "status" => 200,
    //             "message" => "cars not found"


    //         ], 200);
    //     }
    // }
    public function send_notification(Request $request)
    {
        try {
            SendFcmNotification::dispatch(['fKgj44gcRjy7pIDHF9l9vG:APA91bESVXhpr8tAWO65uVv9-cRRS9C2ceXrWJBbUYzFc626546SlGjlufQKL5e1WNnRtdWg9KqPp0VbfkM1L_h_8LLrEt5scU5ZnZ0k083K5tYt8ckEJjQ'], ['id' => 1, 'name' => 'Audi A3', 'updated_at' => '152454754']);
            echo "sent";
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public  function sendPriceAlertNotification(array $fcmTokens, array $notificationData)
    {
        $messaging = app('firebase.messaging');

        $notification = Notification::create()
            ->withTitle($notificationData['title'])
            ->withBody($notificationData['body']);

        $data = [
            'vehicle_id' => $notificationData['vehicle_id'] ?? null,
            'updated_at' => now()->toDateTimeString(),
        ];

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

        $messaging->sendMulticast($message, $fcmTokens);
    }

    public function findCarById(Request $request)
    {

        $validationRules = [];


        $validationRules = array_merge($validationRules, [
            'id' => 'required|integer|exists:posts,id',
        ]);

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $searchcar = Post::with(['feature' => function ($query) {
            $query->with('mainfeature')->get();
        }, 'document', 'location', 'location.province', 'location.city', 'contact', 'dealer'])->where(['status' => 1, 'id' => $request->id]);
        $car = $searchcar->first();

        if ($car) {
            return response()->json([
                "data" => $car,
                "status" => 200,
                "message" => "Car found successfully"
            ], 200);
        } else {
            return response()->json([
                "data" => null,
                "status" => 404,
                "message" => "Car not found"
            ], 404);
        }
    }


    public function uploadAttachment(Request $request)
    {

        $validationRules = [];


        $validationRules = array_merge($validationRules, [
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('firebase_chat_attachments'), $filename);

            $url = url('firebase_chat_attachments/' . $filename);

            $firebaseChatAttachment = new FireBaseChatAttachments;
            $firebaseChatAttachment->url = $url;
            $firebaseChatAttachment->save();

            return response()->json([
                'status' => 200,
                'data' => [
                    'url' => $url
                ]
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'File upload failed'
        ], 400);
    }
    public function uploadShopAttachment(Request $request)
    {

        $validationRules = [];


        $validationRules = array_merge($validationRules, [
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('firebase_service_chat_attachments'), $filename);

            $url = url('firebase_service_chat_attachments/' . $filename);

            $firebaseChatAttachment = new FireBaseChatAttachments;
            $firebaseChatAttachment->url = $url;
            $firebaseChatAttachment->save();

            return response()->json([
                'status' => 200,
                'data' => [
                    'url' => $url
                ]
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'File upload failed'
        ], 400);
    }

    public function getcardetails($id)
    {
        $car = Post::withTrashed()->with(['feature' => function ($query) {
            $query->with('mainfeature')->get();
        }, 'document', 'location', 'location.province', 'location.city', 'contact', 'dealer'])->where(['status' => 1, 'id' => $id])->first();

        // $car = $post->get();
        if ($car) {
            $car->shareable_link = route('cardetail', ['id' => $car->id]);
            $user = auth('sanctum')->user();
            if ($user) {



                $check = Whishlist::where('post_id', $car->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();

                $pricealertCheck = PriceAlert::where('post_id', $car->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                if ($pricealertCheck) {
                    $car->price_alert = 1;
                } else {
                    $car->price_alert = 0;
                }
                if ($check) {
                    $car->favorite = 1;
                } else {
                    $car->favorite = 0;
                }
            } else {

                $car->favorite = 0;
            }
            return response()->json([
                "data" => $car,
                "status" => 200,
                "message" => "Car found successfully"
            ], 200);
        } else {
            return response()->json([
                "data" => null,
                "status" => 404,
                "message" => "Car not found"
            ], 404);
        }
    }

    private function getOrCreateCustomer($user)
    {
        $customers = Customer::all(['limit' => 10000]);
        foreach ($customers->data as $cust) {
            if ($cust->email === $user->email) {
                return $cust;
            }
        }

        return Customer::create([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
