<?php

namespace App\Http\Controllers\Bikes\User;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Product;
use App\Models\City;
use App\Models\Post;
use App\Models\User;
use Stripe\Customer;
use App\Models\Color;
use App\Models\Province;
use Stripe\Subscription;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikePost;
use App\Models\Bike\BikeLeads;
use App\Models\Bike\BikeMedia;
use App\Models\Bike\BikeModels;
use App\Models\AdsSubscriptions;
use App\Models\Bike\BikeContact;
use App\Models\Bike\BikeFeature;
use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikeLocation;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use App\Models\Bike\BikePriceAlert;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Auth;
use App\Models\Bike\BikeMainFeatures;
use App\Models\Notifications;

class BikeAdsController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->search) {
            $query = BikePost::query();

            $search = $request->search;

            // Check for matching make and model
            $check = BikeMake::where('name', $request->search)->first();
            $check2 = BikeModels::where('name', $request->search)->first();

            // Safely extract IDs
            $makeId = $check ? $check->id : null;
            $modelId = $check2 ? $check2->id : null;

            // Search in multiple columns
            $query->where(function ($q) use ($search, $makeId, $modelId) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere(function ($query) use ($makeId) {
                        if ($makeId) {
                            $query->where('make', 'like', '%' . $makeId . '%');
                        }
                    })
                    ->orWhere(function ($query) use ($modelId) {
                        if ($modelId) {
                            $query->where('model', 'like', '%' . $modelId . '%');
                        }
                    })
                    ->orWhere('year', $search)
                    ->orWhere('dealer_comment', 'like', '%' . $search . '%');
            });

            // Include relationships if necessary
            $posts = $query->with(['features', 'location', 'contacts', 'media', 'dealer'])->get();
        } elseif ($request->post_id) {
            $user = Auth::user();
            // if ($user->role == 2) {
            //     $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['id' => $request->post_id, 'dealer_id' => $user->dealer_id, 'employee_id' => $user->id])->paginate(25);
                        if ($user->role == 2) {
                $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['id' => $request->post_id, 'dealer_id' => $user->dealer_id])->paginate(25);
            } else {
                $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['id' => $request->post_id, 'dealer_id' => $user->id])->paginate(25);
            }
        } else {
            $user = Auth::user();
            if ($user->role == 2) {
                // $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['dealer_id' => $user->dealer_id, 'employee_id' => $user->id])->paginate(25);
                                $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['dealer_id' => $user->dealer_id])->paginate(25);
            } else {
                $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['dealer_id' => $user->id])->paginate(25);
            }
        }
        return view('user.post.bikes.index', compact('posts'));
    }

    public function create()
    {
        $user = Auth::user();
        $userId = $user->role == 2 ? $user->dealer_id : $user->id;

        $user = User::find($userId);

        if (empty($user->package)) {
            return redirect()->route('dashboard')->with('error', 'Please upgrade your plan to post an ad.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;

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
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription) {
            return redirect()->route('dashboard')->with('error', 'Please upgrade your subscription to post an ad.');
        }

        try {
            $plan = Product::retrieve($user->package);
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Subscription plan not found.');
        }

        $posted_ads = Post::where('dealer_id', $userId)->count();
        $posted_ads2 = BikePost::where('dealer_id', $userId)->count();
        $total_ads = $posted_ads + $posted_ads2;

        if (($plan->metadata->allowed_ads ?? '0') !== 'unlimited' && $total_ads >= (int) $plan->metadata->allowed_ads) {
            return redirect()->back()->with('error', 'You have reached plan maximum ads limit, kindly upgrade your plan to post more ads.');
        }
        if (empty($user->dealershipName)) {
            return redirect()->route('personal_info')->with('register_error', 'Please complete your dealership information first to post an ad.');
        }

        if (empty($user->package)) {
            return redirect()->route('dashboard')->with('error', 'Please upgrade your plan to post an ad.');
        }

        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get()->groupBy('category');

        return view('user.post.bikes.create', compact('makes', 'models', 'colors', 'provinces', 'bodytypes', 'cities', 'features'));
    }

    public function store(Request $request)
    {

        Log::info($request->all());
        $request->validate([
            'make' => 'required|integer|exists:bike_makes,id',
            'model' => 'required|integer|exists:bike_models,id',
            'mileage' => 'required|string',
            'year' => 'required|integer',
            'is_featured' => 'required|boolean',
            'is_registered' => 'required|boolean',
            'body_type' => 'required|integer|exists:bike_body_types,id',
            'fuel_type' => 'required|string',
            'fuel_capacity' => 'required|string',
            'transmission' => 'required|string',
            'assembly' => 'required|string',
            'exterior_color' => 'required|integer|exists:colors,id',
            'price' => 'required|numeric',
            'condition' => 'required|string',
            'features' => 'required|array',
            'features.*' => 'integer|exists:bike_main_features,id',
            'province' => 'required|integer|exists:provinces,id',
            'city' => 'required|integer|exists:cities,id',
            'street_address' => 'required|string',
            'firstName' => 'required|string',
            'secondName' => 'required|string',
            'email' => 'required|email',
            'number' => 'required|string',
            'website' => 'nullable|string',
            'document_auction' => 'nullable|file|mimes:pdf|max:16384',
            'document_brochure' => 'nullable|file|mimes:pdf|max:16384',
            'filedata.*' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();

            $post = new BikePost();
            $post->make = $request->make;
            $post->model = $request->model;
            $post->mileage = $request->mileage;
            $post->year = $request->year;
            $post->is_featured = $request->is_featured;
            $post->is_registered = $request->is_registered;
            $post->body_type = $request->body_type;
            $post->fuel_type = $request->fuel_type;
            $post->fuel_capacity = $request->fuel_capacity;
            $post->transmission = $request->transmission;
            $post->assembly = $request->assembly;
            $post->color = $request->exterior_color;
            $post->price = $request->price;
            $post->condition = $request->condition;
            $post->dealer_id = $user->dealer_id ?? $user->id;
            $post->employee_id = $user->role == 2 ? $user->id : null;
            $post->description = $request->description;

            if ($request->hasFile('document_auction')) {
                $file = $request->document_auction;
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $post->document_auction = 'posts/doc/bikes/docs/' . $filename;
            }

            if ($request->hasFile('document_brochure')) {
                $file = $request->document_brochure;
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $post->document_brochure = 'posts/doc/bikes/docs/' . $filename;
            }
            $post->longitude = $request->longitude;
            $post->latitude = $request->latitude;
            $post->save();

            foreach ($request->features as $featureId) {
                BikeFeature::create([
                    'ad_id' => $post->id,
                    'bike_main_feature_id' => $featureId
                ]);
            }

            if ($request->hasFile('filedata')) {
                foreach ($request->file('filedata') as $i => $file) {
                    $timestamp = microtime(true) * 10000;
                    $extension = $file->getClientOriginalExtension();
                    $filename = $timestamp . '.' . $extension;
                    $file->move(public_path('posts/doc/bikes/images/'), $filename);

                    BikeMedia::create([
                        'ad_id' => $post->id,
                        'file_path' => 'posts/doc/bikes/images/' . $filename,
                        'thumbnail' => $i == 0 ? 1 : 0,
                    ]);
                }
            }

            BikeLocation::create([
                'ad_id' => $post->id,
                'province' => $request->province,
                'city' => $request->city,
                'street_address' => $request->street_address,
            ]);

            BikeContact::create([
                'ad_id' => $post->id,
                'first_name' => $request->firstName,
                'second_name' => $request->secondName,
                'email' => $request->email,
                'phone_number' => $request->number,
                'website' => $request->website,
            ]);

            $user = Auth::user();
            $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;

            if ($user->role == 2) {
                $post->employee_id = $user->id;
                $post->dealer_id = $user->dealer_id;
            } else {

                $user->save();
                $post->employee_id = null;
                $post->dealer_id = $user->id;
            }

            // Check valid Stripe subscription
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
                return redirect()->route('dashboard')->with('error', 'Your subscription is invalid or expired.');
            }

            // Check feature ad limit
            $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', '1')->count();
            $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', '1')->count();
            $total_ads = $posted_ads + $posted_ads2;

            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                if ($total_ads >= (int) $plan->metadata->allowed_feature_ads) {
                    $post->is_featured = 0;
                } else {
                    $post->is_featured = $request->is_featured === '1' ? 1 : 0;
                }
            } else {
                $post->is_featured = $request->is_featured === '1' ? 1 : 0;
            }
            $post->save();

            DB::commit();
            return redirect()->route('thankyou');
            // return redirect()->route('bike_ads.index')->with('success', 'Bike ad created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return back()->with('error', 'Failed to create bike ad: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $id)->first();
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get()->groupBy('category');
        $bike_features = BikeFeature::where('ad_id', $id)->pluck('bike_main_feature_id')->toArray();

        return view('user.post.bikes.edit', compact('makes', 'models', 'colors', 'provinces', 'bodytypes', 'cities', 'features', 'post', 'bike_features'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        Log::info($request->all());
        $request->validate([
            'make' => 'required|integer|exists:bike_makes,id',
            'model' => 'required|integer|exists:bike_models,id',
            'mileage' => 'required|string',
            'year' => 'required|integer',
            'is_featured' => 'required|boolean',
            'is_registered' => 'required|boolean',
            'body_type' => 'required|integer|exists:bike_body_types,id',
            'fuel_type' => 'required|string',
            'fuel_capacity' => 'required|string',
            'transmission' => 'required|string',
            'assembly' => 'required|string',
            'exterior_color' => 'required|integer|exists:colors,id',
            'price' => 'required|numeric',
            'condition' => 'required|string',
            'features' => 'required|array',
            'features.*' => 'integer|exists:bike_main_features,id',
            'province' => 'required|integer|exists:provinces,id',
            'city' => 'required|integer|exists:cities,id',
            'street_address' => 'required|string',
            'firstName' => 'required|string',
            'secondName' => 'required|string',
            'email' => 'required|email',
            'number' => 'required|string',
            'website' => 'nullable|string',
            'document_auction' => 'nullable|file|mimes:pdf|max:16384',
            'document_brochure' => 'nullable|file|mimes:pdf|max:16384',
            'filedata.*' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $post = BikePost::find($request->post_id);
            if ($post->price > $request->price) {
                $sendfcm = true;
            } else {
                $sendfcm = false;
            }

            $user = Auth::user();

            $old_price = $post->price;
            $new_price = $request->price;

            if ($old_price != $new_price) {
                $post->price = $request->price;
                $post->previous_price = $old_price;
            }
            $post->make = $request->make;
            $post->model = $request->model;
            $post->mileage = $request->mileage;
            $post->year = $request->year;
            $post->is_featured = $request->is_featured;
            $post->is_registered = $request->is_registered;
            $post->body_type = $request->body_type;
            $post->fuel_type = $request->fuel_type;
            $post->fuel_capacity = $request->fuel_capacity;
            $post->transmission = $request->transmission;
            $post->assembly = $request->assembly;
            $post->color = $request->exterior_color;
            $post->price = $request->price;
            $post->condition = $request->condition;
            $post->dealer_id = $user->dealer_id ?? $user->id;
            $post->employee_id = $user->role == 2 ? $user->id : null;
            $post->description = $request->description;

            if ($request->hasFile('document_auction')) {

                if ($post->document_auction && file_exists(public_path($post->document_auction))) {
                    unlink(public_path($post->document_auction));
                }

                $file = $request->document_auction;
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $post->document_auction = 'posts/doc/bikes/docs/' . $filename;
            }

            if ($request->hasFile('document_brochure')) {

                if ($post->document_brochure && file_exists(public_path($post->document_brochure))) {
                    unlink(public_path($post->document_brochure));
                }

                $file = $request->document_brochure;
                $filename = microtime(true) * 10000 . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts/doc/bikes/docs/'), $filename);
                $post->document_brochure = 'posts/doc/bikes/docs/' . $filename;
            }

            // Get authenticated user info
            $user = Auth::user();
            $userId = $user->role == 2 ? $user->dealer_id : $user->id;



            // Set Stripe API
            Stripe::setApiKey(config('services.stripe.secret'));

            // Get Stripe customer
            $customer = $this->getOrCreateCustomer($user);

            // Get all invoices
            $invoices = Invoice::all([
                'customer' => $customer->id,
                'limit' => 100000,
                'expand' => ['data.lines.data.price']
            ])->data;

            // Validate Stripe Subscription
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

            // Abort if no valid plan
            if (!$hasValidAdSubscription || !$plan) {
                return redirect()->route('dashboard')->with('error', 'Your subscription is invalid or expired.');
            }

            // Count existing featured ads
            $posted_ads = Post::where('dealer_id', $userId)->where('feature_ad', '1')->count();
            $posted_ads2 = BikePost::where('dealer_id', $userId)->where('is_featured', '1')->count();
            $total_ads = $posted_ads + $posted_ads2;

            // Handle feature_ad flag
            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                if ($total_ads >= (int) $plan->metadata->allowed_feature_ads) {
                    $post->is_featured = 0;
                } else {
                    $post->is_featured = $request->is_featured === '1' ? 1 : 0;
                }
            } else {
                $post->is_featured = $request->is_featured === '1' ? 1 : 0;
            }

            // Assign employee/dealer IDs
            if ($user->role == 2) {
                $post->employee_id = $user->id;
                $post->dealer_id = $user->dealer_id;
            } else {
                $post->employee_id = null;
                $post->dealer_id = $user->id;
            }


            $post->save();
            BikeFeature::where('ad_id', $post->id)->delete();
            foreach ($request->features as $featureId) {
                BikeFeature::create([
                    'ad_id' => $post->id,
                    'bike_main_feature_id' => $featureId
                ]);
            }

            if ($request->hasFile('filedata')) {
                foreach ($request->file('filedata') as $i => $file) {
                    $timestamp = microtime(true) * 10000;
                    $extension = $file->getClientOriginalExtension();
                    $filename = $timestamp . '.' . $extension;
                    $file->move(public_path('posts/doc/bikes/images/'), $filename);

                    BikeMedia::create([
                        'ad_id' => $post->id,
                        'file_path' => 'posts/doc/bikes/images/' . $filename,
                        'thumbnail' => $i == 0 ? 1 : 0,
                    ]);
                }
            }

            BikeLocation::updateOrCreate(
                ['ad_id' => $post->id],
                [
                    'province' => $request->province,
                    'city' => $request->city,
                    'street_address' => $request->street_address,
                ]
            );

            BikeContact::updateOrCreate(
                ['ad_id' => $post->id],
                [
                    'first_name' => $request->firstName,
                    'second_name' => $request->secondName,
                    'email' => $request->email,
                    'phone_number' => $request->number,
                    'website' => $request->website,
                ]
            );


            DB::commit();

            if ($sendfcm == true) {
                $user_ids = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->pluck('user_id')->toArray();
                if (count($user_ids) > 0) {

                    $fcm_tokens = User::wherein('id', $user_ids)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert', 'body' => 'Bike ' . $post->makename . ' ' . $post->modelname . ' has been updated']);


                        $users = User::wherein('fcm_token', $fcm_tokens)->get();

                        foreach ($users as $user) {
                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Price Alert',
                                'body' => 'Bike ' . $post->makename . ' ' . $post->modelname . ' has been updated',
                                'url' => route('bikedetail', $post->id),
                            ]);
                        }
                    }
                    $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $post->id)->first();


                    $url = url('/');
                    $url = $url . '/bike-details/' . $post->id;
                    $post->url = $url;
                    // $post->url = route('cardetail', $post->id);
                    $post->updated_at = Carbon::parse($post->updated_at)->format('d M Y');
                    // $body = view('emails.bikes.price_alert', compact('post'));

                    // sendMail('azharmehmood', 'azharmehmood74600@gmail.com', 'Auto Jazeera', 'Auto Jazeera Price Alert', $body);
                    foreach ($user_ids as $id) {
                        $user = User::find($id);
                        if ($user) {

                            $body = view('emails.bikes.price_alert', compact('post'));
                            sendMail($user->name, $user->email, 'Auto Jazeera', 'Auto Jazeera Price Alert', $body);
                            //Mail::to($user->email)->send(new PriceAlertMail($post));
                        }
                    }
                }
            }
            return redirect()->route('thankyou');
            //  return redirect()->route('bike_ads.index')->with('success', 'Bike ad updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return back()->with('error', 'Failed to update bike ad: ' . $e->getMessage())->withInput();
        }
    }


    public function deletepostold_image($post_id, $image_id)
    {
        DB::beginTransaction();

        try {
            $imagecount = BikeMedia::where('ad_id', $post_id)->count();

            if ($imagecount <= 5) {
                return redirect()->back()->with('imgdeleteresponse', 'At least 5 images are required.');
            }

            $image = BikeMedia::find($image_id);

            if (!$image) {
                return redirect()->back()->with('imgdeleteresponse', 'Image not found.');
            }

            if (file_exists(public_path($image->file_path))) {
                unlink(public_path($image->file_path));
            }

            $image->delete();

            DB::commit();

            return redirect()->back()->with('imgdeleteresponse', 'Image deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('imgdeleteresponse', 'Something went wrong. Please try again.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $post = BikePost::find($id);
        $post->delete();
        return redirect()->route('bike_ads.index')->with('success', 'Bike ad deleted successfully.');
    }
    public function bikedetail($id)
    {
        $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $id)->first();
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('make', $post->make)->where('status', '1')
            ->where('id', '!=', $post->id) // Exclude the current post
            ->get();
        $features = BikeMainFeatures::where('status', 1)->get()->groupBy('category');
        $bike_features = BikeFeature::where('ad_id', $id)->pluck('bike_main_feature_id')->toArray();
        if (!$post) {
            abort(404);
        } else {
            $post->views += 1;
            $post->save();
            return view('user.post.bikes.details', compact('post', 'features', 'bike_features', 'posts'));
        }
    }

    // request more information (details page)
    public function request_more_info(Request $request)
    {
        $lead = BikeLeads::where('post_id', $request->post_id)->where('user_id', Auth::user()->id)->where('requesttype', $request->type)->first();
        if ($lead) {
            return redirect()->back()->with('request_more_info_response', 'You have already requested more information for this ad.');
        } else {
            $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $request->post_id)->where('status', 1)->first();
            if (!$post) {
                return redirect()->back()->with('request_more_info_response', 'Ad not found.');
            }
            BikeLeads::create([
                'post_id' => $request->post_id,
                'user_id' => Auth::user()->id,
                'fullname' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'comment' => $request->message,
                'dealer_id' => $post->dealer_id,
                'requesttype' => $request->type,
            ]);
            $dealer = User::where('id', $post->dealer_id)->first();
            $body = view('emails.bikes.new_lead', compact('post'));
            sendMail($request->name, $dealer->email, 'Auto Jazeera', 'New Sales Lead', $body);
            return redirect()->back()->with('request_more_info_response', 'Your request has been submitted successfully.');
        }
    }
    public function book_appointment(Request $request)
    {
        $lead = BikeLeads::where('post_id', $request->post_id)->where('user_id', Auth::user()->id)->where('requesttype', $request->type)->first();
        if ($lead) {
            return redirect()->back()->with('book_appointment_response', 'Appointment already bookeds');
        } else {
            $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $request->post_id)->where('status', 1)->first();
            if (!$post) {
                return redirect()->back()->with('book_appointment_response', 'Ad not found.');
            }
            BikeLeads::create([
                'post_id' => $request->post_id,
                'user_id' => Auth::user()->id,
                'fullname' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'dob' => $request->date,
                'apointment_time' => $request->time,
                'perefered_contact_method' => $request->method,
                'comment' => $request->message,
                'dealer_id' => $post->dealer_id,
                'requesttype' => $request->type,
            ]);

            $dealer = User::where('id', $post->dealer_id)->first();
            $body = view('emails.bikes.new_lead', compact('post'));
            sendMail($request->name, $dealer->email, 'Auto Jazeera', 'New Sales Lead', $body);
            $fcm_tokens = [$dealer->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Sales Lead', 'body' => 'New Sales Lead for ' . $post->makename . ' ' . $post->modelname]);



                    Notifications::create([
                        'user_id' => $dealer->id,
                        'title' => 'New Sales Lead',
                        'body' => 'New Sales Lead for ' . $post->makename . ' ' . $post->modelname,
                        'url' => route('bikedetail', $post->id),
                ]);
                
            }
            return redirect()->back()->with('request_more_info_response', 'Your request has been submitted successfully.');
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
