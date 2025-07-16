<?php

namespace App\Http\Controllers\Api\Bike;
use Stripe\Customer;
use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Product;
use App\Models\Post;
use App\Models\User;
use Stripe\Subscription;
use App\Models\Whishlist;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikePost;
use App\Models\Bike\BikeMedia;
use App\Models\Bike\BikeModels;
use App\Models\AdsSubscriptions;
use App\Models\Bike\BikeContact;
use App\Models\Bike\BikeFeature;
use App\Models\Bike\BikeLocation;
use App\Models\Bike\BikeWishlist;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use App\Models\Bike\BikePriceAlert;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use App\Models\Bike\BikeMainFeatures;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BikePostController extends Controller
{

    public function index()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '2') {
            $id = $user->dealer_id;
            $bikes = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('dealer_id', $id)->where('employee_id', $user->id)->get();
        } else {
            $id = $user->id;
            $bikes = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('dealer_id', $id)->get();
        }

        foreach ($bikes as $bike) {
            $check = BikeWishlist::where('post_id', $bike->id)->where('status', 1)->first();
            $pricealertCheck = BikePriceAlert::where('post_id', $bike->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
            if ($pricealertCheck) {
                $bike->price_alert = 1;
            } else {
                $bike->price_alert = 0;
            }

            if ($check) {
                $bike->favorite = 1;
            } else {
                $bike->favorite = 0;
            }
        }
        return response()->json(['status' => 200, 'message' => count($bikes) . ' bikes found', 'data' => $bikes]);
    }

    public function newbikes(Request $request)
    {

        $posts = BikePost::orderBy('is_featured', 'desc')->with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['condition' => 'new', 'status' => '1']);
        if ($request->feature_ad && $request->feature_ad == 1) {
            $posts->where('is_featured', 1);
        }
        $posts = $posts->get();

        $posts->each(function ($car) {
            $car->shareable_link = url('/');
        });

        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($posts as $post) {
                    $check = BikeWishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->first();

                    $pricealertCheck = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
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
                "message" => "new bikes found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 202,
                "message" => "new bikes not found"


            ], 202);
        }
    }
    public function usedbikes(Request $request)
    {
        // dd($request->header('latitude'));

        $posts = BikePost::orderBy('is_featured', 'desc')->with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['condition' => 'used', 'status' => '1']);
        if ($request->feature_ad && $request->feature_ad == 1) {
            $posts->where('is_featured', 1);
        }
        $posts = $posts->get();

        $posts->each(function ($car) {
            $car->shareable_link = url('/');
        });

        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($posts as $post) {
                    $check = BikeWishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->first();

                    $pricealertCheck = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
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
                "message" => "used bikes found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 202,
                "message" => "used bikes not found"


            ], 202);
        }
    }
    public function getallbikes(Request $request)
    {

        $posts = BikePost::orderBy('id', 'desc')->with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['status' => '1']);
        if ($request->feature_ad && $request->feature_ad == 1) {
            $posts->where('is_featured', 1);
        }
        $posts = $posts->get();

        $posts->each(function ($car) {
            $car->shareable_link = url('/');
        });

        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($posts as $post) {
                    $check = BikeWishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->first();
                    $pricealertCheck = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
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
                "message" => " bikes found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 202,
                "message" => " bikes not found"


            ], 202);
        }
    }

    public function getbikedetails(Request $request)
    {
        $user = auth('sanctum')->user();
        $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $request->id)->where('status', '1')->first();

        if ($post) {
            if ($user) {
                $check = BikeWishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->first();
                if ($check) {
                    $post->favorite = 1;
                } else {
                    $post->favorite = 0;
                }
                $pricealertCheck = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                if ($pricealertCheck) {
                    $post->price_alert = 1;
                } else {
                    $post->price_alert = 0;
                }
            } else {
                $post->favorite = 0;
                $post->price_alert = 0;
            }
            return response()->json([
                "data" => $post,
                "status" => 200,
                "message" => "bike details found"
            ], 200);
        } else {
            return response()->json([
                "data" => [],
                "status" => 202,
                "message" => "bike details not found"
            ], 202);
        }
    }
    public function store(Request $request)
    {
        //Log::info($request->all());
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }



        $validator = Validator::make($request->all(), [
            'make' => 'required|integer|exists:bike_makes,id',
            'model' => 'required|integer|exists:bike_models,id',
            'mileage' => 'required|string',
            'year' => 'required|integer',
            'is_featured' => 'boolean',
            'is_registered' => 'boolean',
            'body_type' => 'required|integer|exists:bike_body_types,id',
            'fuel_type' => 'required|string',
            'fuel_capacity' => 'required|string',
            'transmission' => 'required|string',
            'assembly' => 'required|string',
            'color' => 'required|integer|exists:colors,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'condition' => 'required|string',
            'document_auction.path' => 'nullable|file|mimes:pdf|max:5120',
            'document_brochure.path' => 'nullable|file|mimes:pdf|max:5120',
        ]);


        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }
        $imageValidator = Validator::make($request->all(), [
            'images' => 'required|array',
            'images.*.path' => 'required|file|mimes:jpg,jpeg,png',
            'images.*.type' => 'required|string',
            'images.*.thumbnail' => 'required|string',
        ]);


        if ($imageValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $imageValidator->errors()], 422);
        }

        // $documentValidator = Validator::make($request->all(), [
        //     'documents.*' => 'nullable|file|mimes:pdf|max:5120',
        // ]);

        // if ($documentValidator->fails()) {
        //     return response()->json(['status' => 422, 'errors' => $documentValidator->errors()], 422);
        // }
        $featuresValidator = Validator::make($request->all(), [
            'features' => 'required|array',
            'features.*' => 'integer|exists:bike_main_features,id',
        ]);

        if ($featuresValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $featuresValidator->errors()], 422);
        }

        $locationValidator = Validator::make($request->all(), [
            'location.province' => 'required|integer|exists:provinces,id',
            'location.city' => 'required|integer|exists:cities,id',
            'location.street_address' => 'required|string',
        ]);

        if ($locationValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $locationValidator->errors()], 422);
        }

        $contactValidator = Validator::make($request->all(), [
            'contact.first_name' => 'required|string',
            'contact.second_name' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone_number' => 'required|string',
            'contact.website' => 'nullable|string',
        ]);

        if ($contactValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $contactValidator->errors()], 422);
        }


        $validatedData = $validator->validated();
        $user = auth('sanctum')->user();
        if ($user->role == '2') {
            $id = $user->dealer_id;
            $validatedData['dealer_id'] = $id;
            $validatedData['employee_id'] = $user->id;
        } else {
            $id = $user->id;
            $validatedData['dealer_id'] = $id;
        }
        $validatedData['latitude'] = $request->latitude;
        $validatedData['longitude'] = $request->longitude;



        DB::beginTransaction();
        try {
            // Create bike post

            if ($request->document_auction) {
                $auctionData = $request->document_auction;
                if (isset($auctionData['path']) && $auctionData['path'] instanceof \Illuminate\Http\UploadedFile) {
                    $auctionFile = $auctionData['path'];
                    if ($auctionFile->isValid()) {
                        $timestamp = microtime(true) * 10000;
                        $extension = $auctionFile->getClientOriginalExtension();
                        $filename = $timestamp . '.' . $extension;
                        $auctionFile->move(public_path('posts/doc/bikes/docs/'), $filename);
                        $validatedData['document_auction'] = 'posts/doc/bikes/docs/' . $filename;
                    }
                }
            }

            if ($request->document_brochure) {
                $brochureData = $request->document_brochure;
                if (isset($brochureData['path']) && $brochureData['path'] instanceof \Illuminate\Http\UploadedFile) {
                    $auctionFile = $brochureData['path'];
                    if ($auctionFile->isValid()) {
                        $timestamp = microtime(true) * 10000;
                        $extension = $auctionFile->getClientOriginalExtension();
                        $filename = $timestamp . '.' . $extension;
                        $auctionFile->move(public_path('posts/doc/bikes/docs/'), $filename);
                        $validatedData['document_brochure'] = 'posts/doc/bikes/docs/' . $filename;
                    }
                }
            }

            $bikePost = BikePost::create($validatedData);
            $user = auth('sanctum')->user();
            $userId = $user->role == 2 ? $user->dealer_id : $user->id;
            // $subscription = AdsSubscriptions::where('user_id', $userId)->orderBy('id', 'desc')->first();
            
            // dd($subscription);
            // $plan = AdsSubscriptionPlans::where('id', $subscription->plan_id)->first();
            $user = User::find($userId);
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
            $posted_ads = Post::where('dealer_id', auth('sanctum')->user()->role == 2 ? auth('sanctum')->user()->dealer_id : auth('sanctum')->user()->id)->where('feature_ad', '1')->count();
            $posted_ads2 = BikePost::where('dealer_id', auth('sanctum')->user()->role == 2 ? auth('sanctum')->user()->dealer_id : auth('sanctum')->user()->id)->where('is_featured', '1')->count();
            $total_ads = $posted_ads + $posted_ads2;

            if ($plan->metadata->allowed_feature_ads !== 'unlimited') {
                // dd($plan->allowed_ads);
                if ($total_ads >= (int)$plan->metadata->allowed_feature_ads) {
                    $bikePost->is_featured = 0;
                } else {
                    $bikePost->is_featured = $validatedData['is_featured'] ?? 0;
                }
            }
            $bikePost->save();
            // Insert Features
            foreach ($request->features as $feature) {
                BikeFeature::create([
                    'ad_id' => $bikePost->id,
                    'bike_main_feature_id' => $feature,
                ]);
            }

            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $image) {
            //         $timestamp = microtime(true) * 10000;
            //         $extension = $image->getClientOriginalExtension();
            //         $filename = $timestamp . '.' . $extension;
            //         $image->move(public_path('posts/doc/bikes/images/'), $filename);
            //         BikeMedia::create([
            //             'ad_id' => $bikePost->id,
            //             'file_path' => 'posts/doc/bikes/images/' . $filename,
            //             'file_type' => 'image',
            //         ]);
            //     }
            // }
            if ($request->has('images')) {
                foreach ($request->images as $fileEntry) {
                    if (
                        isset($fileEntry['path']) &&
                        $fileEntry['path'] instanceof \Illuminate\Http\UploadedFile &&
                        $fileEntry['path']->isValid()
                    ) {
                        $timestamp = microtime(true) * 10000;
                        $extension = $fileEntry['path']->getClientOriginalExtension();
                        $filename = $timestamp . '.' . $extension;
                        $fileEntry['path']->move(public_path('posts/doc/bikes/images/'), $filename);

                        $thumbnail = isset($fileEntry['thumbnail']) && $fileEntry['thumbnail'] === 'true' ? 1 : 0;
                        $fileExtension = strtolower($extension);
                        $docType = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($fileExtension, ['mp4', 'mov', 'avi']) ? 'video' : 'other');

                        BikeMedia::create([
                            'ad_id' => $bikePost->id,
                            'file_path' => 'posts/doc/bikes/images/' . $filename,
                            'thumbnail' => $thumbnail,
                        ]);
                    }
                }
            }



            // if ($request->hasFile('documents')) {
            //     foreach ($request->file('documents') as $document) {
            //         $timestamp = microtime(true) * 10000;
            //         $extension = $document->getClientOriginalExtension();
            //         $filename = $timestamp . '.' . $extension;
            //         $document->move(public_path('posts/doc/bikes/docs/'), $filename);
            //         BikeMedia::create([
            //             'ad_id' => $bikePost->id,
            //             'file_path' => 'posts/doc/bikes/docs/' . $filename,
            //             'file_type' => 'document',
            //         ]);
            //     }
            // }

            BikeLocation::create([
                'ad_id' => $bikePost->id,
                'province' => $request->location['province'],
                'city' => $request->location['city'],
                'street_address' => $request->location['street_address'],
            ]);

            // Insert Contact
            BikeContact::create([
                'ad_id' => $bikePost->id,
                'first_name' => $request->contact['first_name'],
                'second_name' => $request->contact['second_name'],
                'email' => $request->contact['email'],
                'phone_number' => $request->contact['phone_number'],
                'website' => $request->contact['website'] ?? null,
            ]);

            $user = User::find($bikePost->dealer_id);
            $user->ads_count += 1;
            $user->save();
            $user->free_package_availed = (int)$user->free_package_availed;

            $totalAds = BikePost::where('dealer_id', $bikePost->dealer_id)->where('is_featured', 1)->count();
            if ($totalAds >= 2) {

                $bikePost->is_featured = 0;
                $bikePost->save();
            }
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Bike post created successfully', 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Error creating bike post ' . $e->getMessage(), 'data' => []], 500);
        }
    }


    public function update(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $bikePost = BikePost::find($request->id);
        if (!$bikePost) {
            return response()->json(['status' => 404, 'message' => "Bike post not found"]);
        }

        $validator = Validator::make($request->all(), [
            'make' => 'required|integer|exists:bike_makes,id',
            'model' => 'required|integer|exists:bike_models,id',
            'mileage' => 'required|string',
            'year' => 'required|integer',
            'is_featured' => 'boolean',
            'is_registered' => 'boolean',
            'body_type' => 'required|integer|exists:bike_body_types,id',
            'fuel_type' => 'required|string',
            'fuel_capacity' => 'required|string',
            'transmission' => 'required|string',
            'assembly' => 'required|string',
            'color' => 'required|integer|exists:colors,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'condition' => 'required|string',
            'document_auction.path' => 'nullable|file|mimes:pdf|max:5120',
            'document_brochure.path' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $imageValidator = Validator::make($request->all(), [
            'images' => 'required|array',
            // 'images.*.path' => 'required|file|mimes:jpg,jpeg,png',
            'images.*.path' => 'required',
            'images.*.type' => 'required|string',
            'images.*.thumbnail' => 'required|string',
        ]);


        if ($imageValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $imageValidator->errors()], 422);
        }

        $featuresValidator = Validator::make($request->all(), [
            'features' => 'required|array',
            'features.*' => 'integer|exists:bike_main_features,id',
        ]);
        if ($featuresValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $featuresValidator->errors()], 422);
        }

        $locationValidator = Validator::make($request->all(), [
            'location.province' => 'required|integer|exists:provinces,id',
            'location.city' => 'required|integer|exists:cities,id',
            'location.street_address' => 'required|string',
        ]);
        if ($locationValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $locationValidator->errors()], 422);
        }

        $contactValidator = Validator::make($request->all(), [
            'contact.first_name' => 'required|string',
            'contact.second_name' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone_number' => 'required|string',
            'contact.website' => 'nullable|string',
        ]);
        if ($contactValidator->fails()) {
            return response()->json(['status' => 422, 'errors' => $contactValidator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $user = auth('sanctum')->user();
        if ($user->role == '2') {
            $validatedData['dealer_id'] = $user->dealer_id;
            $validatedData['employee_id'] = $user->id;
        } else {
            $validatedData['dealer_id'] = $user->id;
        }
        $validatedData['latitude'] = $request->latitude;
        $validatedData['longitude'] = $request->longitude;

        $oldprice = $bikePost->price;
        $newprice = $request->price;
        if ($oldprice != $newprice) {
            $validatedData['price'] = $request->price;
            $validatedData['previous_price'] = $oldprice;
        }

        DB::beginTransaction();
        try {
            if ($request->document_auction && isset($request->document_auction['path']) && $request->document_auction['path'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $request->document_auction['path'];
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $validatedData['document_auction'] = 'posts/doc/bikes/docs/' . $filename;
            }

            if ($request->document_brochure && isset($request->document_brochure['path']) && $request->document_brochure['path'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $request->document_brochure['path'];
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $validatedData['document_brochure'] = 'posts/doc/bikes/docs/' . $filename;
            }

            $bikePost->update($validatedData);
            $user = auth('sanctum')->user();
            $userId = $user->role == 2 ? $user->dealer_id : $user->id;
            // $subscription = AdsSubscriptions::where('user_id', $userId)->orderBy('id', 'desc')->first();

            // dd($subscription);
            // $plan = AdsSubscriptionPlans::where('id', $subscription->plan_id)->first();
            // dd($plan);
              $user = User::find($userId);
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
            $posted_ads = Post::where('dealer_id', auth('sanctum')->user()->role == 2 ? auth('sanctum')->user()->dealer_id : auth('sanctum')->user()->id)->where('feature_ad', '1')->count();
            $posted_ads2 = BikePost::where('dealer_id', auth('sanctum')->user()->role == 2 ? auth('sanctum')->user()->dealer_id : auth('sanctum')->user()->id)->where('is_featured', '1')->count();
            $total_ads = $posted_ads + $posted_ads2;

            if ($plan->metadata->allowed_feature_ads !== 'unlimited') {
                // dd($plan->allowed_ads);
                if ($total_ads >= (int)$plan->metadata->allowed_feature_ads) {
                    $bikePost->is_featured = 0;
                } else {
                    $bikePost->is_featured = $validatedData['is_featured'] ?? 0;
                }
            }
            $bikePost->save();

            // Update features (delete old ones first)
            BikeFeature::where('ad_id', $bikePost->id)->delete();
            foreach ($request->features as $feature) {
                BikeFeature::create([
                    'ad_id' => $bikePost->id,
                    'bike_main_feature_id' => $feature,
                ]);
            }

            // Update images (delete old ones first if needed)
            if ($request->has('images')) {
                // BikeMedia::where('ad_id', $bikePost->id)->where('doc_type', 'image')->delete();
                foreach ($request->images as $fileEntry) {
                    if (
                        isset($fileEntry['path']) &&
                        $fileEntry['path'] instanceof \Illuminate\Http\UploadedFile &&
                        $fileEntry['path']->isValid()
                    ) {
                        $timestamp = microtime(true) * 10000;
                        $extension = $fileEntry['path']->getClientOriginalExtension();
                        $filename = $timestamp . '.' . $extension;
                        $fileEntry['path']->move(public_path('posts/doc/bikes/images/'), $filename);

                        $thumbnail = isset($fileEntry['thumbnail']) && $fileEntry['thumbnail'] === 'true' ? 1 : 0;
                        $fileExtension = strtolower($extension);
                        $docType = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($fileExtension, ['mp4', 'mov', 'avi']) ? 'video' : 'other');

                        BikeMedia::create([
                            'ad_id' => $bikePost->id,
                            'file_path' => 'posts/doc/bikes/images/' . $filename,
                            'thumbnail' => $thumbnail,
                        ]);
                    }
                }
            }

            if ($request->removeMeta) {
                $removePhotos = $request->removeMeta;

                if (is_array($removePhotos)) { // Ensure it's an array
                    foreach ($removePhotos as $removePhoto) {
                        if (isset($removePhoto['id']) && isset($removePhoto['path'])) { // Check if `id` and `path` exist
                            $photo = BikeMedia::find($removePhoto['id']); // Assuming `Document` is the model for these files

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

            // Update location
            BikeLocation::updateOrCreate(
                ['ad_id' => $bikePost->id],
                [
                    'province' => $request->location['province'],
                    'city' => $request->location['city'],
                    'street_address' => $request->location['street_address'],
                ]
            );

            // Update contact
            BikeContact::updateOrCreate(
                ['ad_id' => $bikePost->id],
                [
                    'first_name' => $request->contact['first_name'],
                    'second_name' => $request->contact['second_name'],
                    'email' => $request->contact['email'],
                    'phone_number' => $request->contact['phone_number'],
                    'website' => $request->contact['website'] ?? null,
                ]
            );



            DB::commit();
            $user = User::find($bikePost->dealer_id);
            return response()->json(['status' => 200, 'message' => 'Bike post updated successfully', 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Error updating bike post: ' . $e->getMessage(), 'data' => []], 500);
        }
    }



    // get all bike features 


    public function get_features()
    {
        $feature = BikeMainFeatures::where('status', 1)->get()->groupBy('category');
        if ($feature->isNotEmpty()) {
            return response()->json([
                "data" => $feature,
                "status" => 200,
                "message" => "features found"


            ], 200);
        } else {
            return response()->json([
                "data" => $feature,
                "status" => 402,
                "message" => "features not found"


            ], 402);
        }
    }

    // get all body types 


    public function get_bodytypes()
    {
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        if ($bodytypes->isNotEmpty()) {
            return response()->json([
                "data" => $bodytypes,
                "status" => 200,
                "message" => "bodytypes found"


            ], 200);
        } else {
            return response()->json([
                "data" => $bodytypes,
                "status" => 402,
                "message" => "bodytypes not found"


            ], 402);
        }
    }

    public function get_makes()
    {
        $makes = BikeMake::with('models')->where('status', 1)->get();
        if ($makes->isNotEmpty()) {
            return response()->json([
                "data" => $makes,
                "status" => 200,
                "message" => "makes found"


            ], 200);
        } else {
            return response()->json([
                "data" => $makes,
                "status" => 402,
                "message" => "makes not found"


            ], 402);
        }
    }


    // get model based on make 

    public function get_models(Request $request)
    {
        if ($request->make_id && $request->make_id != '') {
            $models = BikeModels::where('status', 1)->where('make_id', $request->make_id)->get();
            if ($models->isNotEmpty()) {
                return response()->json([
                    "data" => $models,
                    "status" => 200,
                    "message" => "models found"


                ], 200);
            } else {
                return response()->json([
                    "data" => $models,
                    "status" => 200,
                    "message" => "models not found"


                ], 200);
            }
        } else {
            $models = BikeModels::where('status', 1)->get();
            if ($models->isNotEmpty()) {
                return response()->json([
                    "data" => $models,
                    "status" => 200,
                    "message" => "models found"


                ], 200);
            } else {
                return response()->json([
                    "data" => $models,
                    "status" => 200,
                    "message" => "models not found"


                ], 200);
            }
        }
    }





    // home screen search filter 


    public function search(Request $request)
    {
        $query = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer']);
        $filtersApplied = false;

        if (!is_null($request->province) || !is_null($request->city)) {
            $query->whereHas('location', function ($q) use ($request) {
                if (!is_null($request->province)) {
                    $q->where('province', $request->province);
                }
                if (!is_null($request->city)) {
                    $q->where('city', $request->city);
                }
            });
            $filtersApplied = true;
        }


        if (!is_null($request->make)) {
            $query->where('make', $request->make);
            $filtersApplied = true;
        }
        if (!is_null($request->model)) {
            $query->where('model', $request->model);
            $filtersApplied = true;
        }
        if (!is_null($request->body_type)) {
            $query->where('body_type', $request->body_type);
            $filtersApplied = true;
        }
        if ($request->has('price')) {
            if (!is_null($request->price['from']) && !is_null($request->price['to'])) {
                $query->whereBetween('price', [$request->price['from'], $request->price['to']]);
                $filtersApplied = true;
            }
        }

        if ($request->has('year')) {
            if (!is_null($request->year['from']) && !is_null($request->year['to'])) {
                $query->whereBetween('year', [$request->year['from'], $request->year['to']]);
                $filtersApplied = true;
            }
        }


        //at least one filter 
        // if (!$filtersApplied) {
        //     return response()->json([
        //         "status" => 400,
        //         "message" => "At least one filter is required",
        //         "data" => [],
        //     ], 400);
        // }
        $query->where('status', '1');
        $posts = $query->get();

        return response()->json([
            "status" => $posts->isNotEmpty() ? 200 : 402,
            "message" => $posts->isNotEmpty() ? count($posts) . " Posts found" : "Posts not found",
            "data" => $posts,
        ], $posts->isNotEmpty() ? 200 : 402);
    }



    // advance filters 

    public function advancedSearch(Request $request)
    {
        Log::info($request->all());
        $query = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer']);
        $filtersApplied = false;

        if (!is_null($request->condition) && $request->condition != 'both') {
            $query->where('condition', $request->condition);
            $filtersApplied = true;
        }

        if (!is_null($request->feature_ad)) {
            $query->where('is_featured', $request->feature_ad);
            $filtersApplied = true;
        }

        if (!is_null($request->registered)) {
            $query->where('is_registered', $request->registered);
            $filtersApplied = true;
        }

        if (!empty($request->assembly) && is_array($request->assembly)) {
            $query->whereIn('assembly', $request->assembly);
            $filtersApplied = true;
        }

        if ($request->has('price')) {
            if (!is_null($request->price['from']) && !is_null($request->price['to'])) {
                $query->whereBetween('price', [$request->price['from'], $request->price['to']]);
                $filtersApplied = true;
            }
        }

        if ($request->has('year')) {
            if (!is_null($request->year['from']) && !is_null($request->year['to'])) {
                $query->whereBetween('year', [$request->year['from'], $request->year['to']]);
                $filtersApplied = true;
            }
        }

        if (!empty($request->transmission) && is_array($request->transmission)) {
            $query->whereIn('transmission', $request->transmission);
            $filtersApplied = true;
        }

        if (!is_null($request->make)) {
            $query->where('make', $request->make);
            $filtersApplied = true;
        }

        if (!empty($request->model) && is_array($request->model)) {
            $query->whereIn('model', $request->model);
            $filtersApplied = true;
        }

        if (!empty($request->bodytype) && is_array($request->bodytype)) {
            $query->whereIn('body_type', $request->bodytype);
            $filtersApplied = true;
        }

        if (!is_null($request->mileage)) {
            $query->where('mileage', '<=', $request->mileage);
            $filtersApplied = true;
        }

        if (!empty($request->fuel_type) && is_array($request->fuel_type)) {
            $query->whereIn('fuel_type', $request->fuel_type);
            $filtersApplied = true;
        }

        if (!is_null($request->fuel_capacity)) {
            $query->where('fuel_capacity', (int)$request->fuel_capacity);
            $filtersApplied = true;
        }

        if (!empty($request->exterior_color) && is_array($request->exterior_color)) {
            $query->whereIn('color', $request->exterior_color);
            $filtersApplied = true;
        }

        if (!empty($request->city) && is_array($request->city)) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->whereIn('city', $request->city);
            });
            $filtersApplied = true;
        }



        // if (!$filtersApplied) {
        //     return response()->json([
        //         "status" => 400,
        //         "message" => "At least one filter is required",
        //         "data" => [],
        //     ], 400);
        // }

        $query->where('status', '1');
        $sql = $this->str_replace_array('?', $query->getBindings(), $query->toSql());
        Log::info($sql);

        $posts = $query->get();

        if (!is_null($request->seller_type)) {
            $posts = $posts->filter(function ($post) use ($request) {
                $user = User::find($post->dealer_id);
                return $user && $user->userType === $request->seller_type;
            })->values(); // Reset keys if needed
        }

        return response()->json([
            "status" => 200,
            "message" => $posts->isNotEmpty() ? count($posts) . " Posts found" : "Posts not found",
            "data" => $posts,
        ], 200);
    }



    public function addRemoveWishlist(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        $postcheck = BikePost::where('id', $request->post_id)->first();
        if (!$postcheck) {
            return response()->json(['status' => 404, 'message' => "Post not found"]);
        }
        $checkIfExist = BikeWishlist::where('post_id', $request->post_id)->where('user_id', $user->id)->first();

        if ($checkIfExist) {
            if ($checkIfExist->status == 1) {
                $checkIfExist->status = 0;
                $checkIfExist->save();
                return response()->json(['status' => 200, 'message' => "Removed from wishlist successfully"]);
            } else {
                $checkIfExist->status = 1;
                $checkIfExist->save();
                return response()->json(['status' => 200, 'message' => "Added to wishlist successfully"]);
            }
        } else {
            BikeWishlist::create([
                'post_id' => $request->post_id,
                'user_id' => $user->id,
                'status' => 1,
            ]);
            return response()->json(['status' => 200, 'message' => "Added to wishlist successfully"]);
        }
    }

    public function clearwishlist(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($request->post_id) {
            BikeWishlist::where('user_id', $user->id)->where('post_id', $request->post_id)->delete();
        } else {
            BikeWishlist::where('user_id', $user->id)->delete();
        }
        return response()->json(['status' => 200, 'message' => "Wishlist cleared successfully"]);
    }

    public function getwishlist()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        $wishlist = BikeWishlist::where('user_id', $user->id)->where('status', 1)->get();
        if ($wishlist->isEmpty()) {
            return response()->json(['status' => 200, 'message' => "Wishlist is empty", 'data' => $wishlist]);
        } else {
            return response()->json(['status' => 200, 'message' => count($wishlist) . ' wishlist items found', 'data' => $wishlist]);
        }
    }


    public function similar_ads(Request $request)
    {
        $posts = BikePost::where('status', 1)
            ->when($request->make || $request->model, function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    if ($request->make) {
                        $subQuery->orWhere('make', $request->make);
                    }
                    if ($request->model) {
                        $subQuery->orWhere('model', $request->model);
                    }
                });
            })
            ->orderBy('is_featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->with(['features', 'location', 'contacts', 'media', 'dealer'])
            ->get();

        if ($posts->isNotEmpty()) {
            $user = auth('sanctum')->user();

            foreach ($posts as $post) {
                $post->favorite = 0;
                $post->price_alert = 0;

                if ($user) {
                    $wishlist = BikeWishlist::where('post_id', $post->id)
                        ->where('user_id', $user->id)
                        ->where('status', 1)
                        ->first();

                    if ($wishlist) {
                        $post->favorite = 1;
                    }

                    // Example if you want to re-enable price alert logic:
                    // $priceAlert = PriceAlert::where('post_id', $post->id)
                    //     ->where('user_id', $user->id)
                    //     ->where('status', 1)
                    //     ->first();
                    // $post->price_alert = $priceAlert ? 1 : 0;
                }
            }

            return response()->json([
                "data" => $posts,
                "status" => 200,
                "message" => "Similar posts found"
            ], 200);
        }

        return response()->json([
            "data" => [],
            "status" => 402,
            "message" => "Similar posts not found"
        ], 402);
    }


    public function deleteBikePost(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        $post = BikePost::find($request->id);
        if (!$post) {
            return response()->json(['status' => 404, 'message' => "Post not found"]);
        }
        if ($post->dealer_id != $user->id) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to delete this post"]);
        }
        $post->delete();
        return response()->json(['status' => 200, 'message' => "Post deleted successfully"]);
    }
    public function str_replace_array($search, array $replace, $subject)
    {
        foreach ($replace as $value) {
            $subject = preg_replace('/' . preg_quote($search, '/') . '/', is_numeric($value) ? $value : "'$value'", $subject, 1);
        }
        return $subject;
    }

    public function udpateviews(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        if ($request->vehicle_type = 'car') {
            $post = BikePost::find($request->vehicle_id);
            if (!$post) {
                return response()->json(['status' => 404, 'message' => "Post not found"]);
            }
            $post->views += 1;
            $post->save();
        } else {
            $post = Post::find($request->vehicle_id);
            if (!$post) {
                return response()->json(['status' => 404, 'message' => "Post not found"]);
            }
            $post->views += 1;
            $post->save();
        }
        return response()->json(['status' => 200, 'message' => "Views updated successfully"]);
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
