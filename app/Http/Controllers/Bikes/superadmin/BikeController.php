<?php

namespace App\Http\Controllers\Bikes\superadmin;

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
use App\Models\Bike\BikeMedia;
use App\Models\Bike\BikeModels;
use App\Models\Bike\BikeContact;
use App\Models\Bike\BikeFeature;
use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikeLocation;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use App\Models\Bike\BikePriceAlert;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Bike\BikeMainFeatures;


class BikeController extends Controller
{
    public function index()
    {
        $bike_posts = BikePost::get();
        $users = User::where('role', 1)->get();
        return view('bikes.superadmin.bike_ads.index', compact('bike_posts', 'users'));
    }

    public function create()
    {
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get()->groupBy('category');
        $users = User::where('role', 1)->get();

        return view('bikes.superadmin.bike_ads.create', compact('makes', 'models', 'colors', 'provinces', 'bodytypes', 'cities', 'features', 'users'));
    }

    public function store(Request $request)
    {
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
            $user = User::find($request->dealer);

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
            $post->dealer_id = $request->dealer;
            $post->employee_id = null;
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
            $post->posted_by = 'superadmin';

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

            $user = User::find($post->dealer_id);
            $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;
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
                    Log::error('Stripe Subscription Error: ' . $e->getMessage());
                }
            }

            if (!$hasValidAdSubscription || !$plan) {
                DB::rollBack();
                return redirect()->to(url('superadmin/ads'))->with('error', 'Dealer subscription is invalid or expired.');
            }

            $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', 1)->count();
            $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', 1)->count();
            $total_ads = $posted_ads + $posted_ads2;

            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                $post->is_featured = $total_ads >= (int) $plan->metadata->allowed_feature_ads ? 0 : ($request->is_featured);
            } else {
                $post->is_featured = $request->is_featured;
            }

            $post->save();

            DB::commit();

            // return redirect()->route('superadmin.bike-ads.index')->with('success', 'Bike ad created successfully.');
            return redirect()->route('superadmin.thankyou');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return back()->with('error', 'Failed to create bike ad: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        // dd($id);
        $post = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $id)->first();
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get()->groupBy('category');
        $bike_features = BikeFeature::where('ad_id', $id)->pluck('bike_main_feature_id')->toArray();
        $users = User::where('role', 1)->get();
        return view('bikes.superadmin.bike_ads.edit', compact('makes', 'models', 'colors', 'provinces', 'bodytypes', 'cities', 'features', 'post', 'bike_features', 'users'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Log::info($request->all());
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
            'dealer' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $post = BikePost::find($request->post_id);
            if ($post->price > $request->price) {
                $sendfcm = true;
            } else {
                $sendfcm = false;
            }

            $user = User::find($request->dealer);
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
            $post->dealer_id = $request->dealer;
            $post->employee_id = null;
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


            Stripe::setApiKey(config('services.stripe.secret'));
            $user = User::find($post->dealer_id);
            $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;
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
                    Log::error('Stripe Subscription Error: ' . $e->getMessage());
                }
            }

            if (!$hasValidAdSubscription || !$plan) {
                DB::rollBack();
                return redirect()->to(url('superadmin/ads'))->with('error', 'Dealer subscription is invalid or expired.');
            }

            $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', 1)->count();
            $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', 1)->count();
            $total_ads = $posted_ads + $posted_ads2;

            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                $post->is_featured = $total_ads >= (int) $plan->metadata->allowed_feature_ads ? 0 : ($request->is_featured);
            } else {
                $post->is_featured = $request->is_featured;
            }


            DB::commit();



            if ($sendfcm == true) {
                $user_ids = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->pluck('user_id')->toArray();
                if (count($user_ids) > 0) {

                    $fcm_tokens = User::wherein('id', $user_ids)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert', 'body' => 'Bike ' . $post->makename . ' ' . $post->modelname . ' has been updated']);
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

            return redirect()->to(url('superadmin/bike-ads'))->with('success', 'Bike ad updated successfully.');
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

    public function destroy(Request $request)
    {
        // dd($request->all());
        $id = $request->deleted_id;
        $post = BikePost::withTrashed()->where('id', $id)->first();
        $post->forceDelete();
        return redirect()->back()->with('success', 'Bike ad deleted successfully.');
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
    public function advertise()
    {
        return view('advertise');
    }

    public function show() {}



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
