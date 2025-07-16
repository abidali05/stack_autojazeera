<?php

namespace App\Http\Controllers\Api\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Shops;
use App\Models\PriceAlert;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Models\ShopReviewImage;
use App\Jobs\SendFcmNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Bike\BikePriceAlert;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\AutoServices\Bookings;
use App\Models\AutoServices\Services;
use App\Models\AutoServices\Amenities;
use App\Models\AutoServices\ShopImages;
use Illuminate\Support\Facades\Storage;
use App\Models\AutoServices\ShopTimings;
use App\Models\AutoServices\ShopServices;
use App\Models\AutoServices\ShopWishlist;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ShopAmenities;
use App\Models\AutoServices\BookingServices;
use App\Models\AutoServices\ServiceCategories;


class ShopController extends Controller
{
    public function services()
    {
        $services = Services::all()->groupBy('category_name');
        // Log::info($services);
        return response()->json([
            'status' => 200,
            'message' => 'Services fetched successfully',
            'data' => $services
        ], 200);
    }

    public function amenities()
    {
        $amenities = Amenities::all();
        return response()->json([
            'status' => 200,
            'message' => 'Amenities fetched successfully',
            'data' => $amenities
        ], 200);
    }

    public function service_categories()
    {
        $service_categories = ServiceCategories::all();
        return response()->json([
            'status' => 200,
            'message' => 'Service categories fetched successfully',
            'data' => $service_categories
        ], 200);
    }

    public function create_shop(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        Log::info($request->all());
        $user = auth('sanctum')->user();
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255|unique:shops,name',
            'shop_contact' => 'required|string|max:20|unique:shops,number',
            'shop_email' => 'required|email|max:255|unique:shops,email',
            'province' => 'required|exists:provinces,id',
            'city' => 'required|exists:cities,id',
            'postal_code' => 'required|string|max:20',
            'shop_address' => 'required|string',
            'description' => 'required|string',
            'shop_logo' => 'required|image|mimes:jpeg,png,jpg|max:8192',
            'shop_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'days' => 'required|array',
            'days.*.start' => 'required_with:days.*.end|date_format:H:i',
            'days.*.end' => 'required_with:days.*.start|date_format:H:i',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            log::info($validator->errors());
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        DB::beginTransaction();

        try {
            // Rename logo
            $logoFile = $request->file('shop_logo');
            $logoName = microtime(true) . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('shop_logos', $logoName, 'public');

            $shop = Shops::create([
                'dealer_id' => $user->id,
                'name' => $request['shop_name'],
                'number' => $request['shop_contact'],
                'email' => $request['shop_email'],
                'province' => $request['province'],
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
                'address' => $request['shop_address'],
                'description' => $request['description'],
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
                'twitter' => $request->input('twitter'),
                'logo' => $logoPath,
                'online_quotes' => $request->input('online_quotes') ? 1 : 0,
                'offer_services' => $request->input('offer_services') ? 1 : 0,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);

            foreach ($request->services as $service_id) {
                ShopServices::create([
                    'shop_id' => $shop->id,
                    'service_id' => $service_id,
                ]);
            }

            if ($request->amenities) {
                foreach ($request->amenities as $amenity_id) {
                    ShopAmenities::create([
                        'shop_id' => $shop->id,
                        'amenity_id' => $amenity_id,
                    ]);
                }
            }

            foreach ($request->days as $day => $data) {
                if (!isset($data['start'], $data['end'])) {
                    continue;
                }

                ShopTimings::create([
                    'shop_id' => $shop->id,
                    'day' => $day,
                    'start_time' => $data['start'],
                    'end_time' => $data['end'],
                    // 'active' => isset($data['active']),
                ]);
            }

            if ($request->hasFile('shop_images')) {
                foreach ($request->file('shop_images') as $img) {
                    if (!$img) continue;

                    $imageName = microtime(true) . '.' . $img->getClientOriginalExtension();
                    $path = $img->storeAs('shop_images', $imageName, 'public');

                    ShopImages::create([
                        'shop_id' => $shop->id,
                        'path' => $path,
                    ]);
                }
            }

            DB::commit();
            $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('dealer_id', $user->id)->first();
            return response()->json([
                'status' => 200,
                'message' => 'Shop created successfully',
                'data' => $shop
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function shop_detail()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'shop_reviews'])->where('dealer_id', $user->id)->first();
        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'You have not created a shop yet. Please create a shop first.',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Shop details fetched successfully',
            'data' => $shop
        ], 200);
    }

    public function update_shop(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        Log::info($request->all());
        $user = auth('sanctum')->user();
        $shop = Shops::where('dealer_id', $user->id)->first();
        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'You have not created a shop yet. Please create a shop first.',
            ], 404);
        }
        $id = $shop->id;


        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255|unique:shops,name,' . $id,
            'shop_contact' => 'required|string|max:20|unique:shops,number,' . $id,
            'shop_email' => 'required|email|max:255|unique:shops,email,' . $id,
            'province' => 'required|exists:provinces,id',
            'city' => 'required|exists:cities,id',
            'postal_code' => 'required|string|max:20',
            'shop_address' => 'required|string',
            'description' => 'required|string',
            'shop_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'shop_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'days' => 'required|array',
            'days.*.start' => 'required_with:days.*.end',
            'days.*.end' => 'required_with:days.*.start',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        DB::beginTransaction();

        try {
            $shop = Shops::findOrFail($id);
            if (!$shop) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Shop not found',
                ], 404);
            }



            // Update logo if provided
            if ($request->hasFile('shop_logo')) {
                // Delete old logo if exists
                if ($shop->logo && Storage::disk('public')->exists($shop->getRawOriginal('logo'))) {
                    Storage::disk('public')->delete($shop->getRawOriginal('logo'));
                }

                // Rename and store new logo
                $logoFile = $request->file('shop_logo');
                $logoName = microtime(true) . '.' . $logoFile->getClientOriginalExtension();
                $logoPath = $logoFile->storeAs('shop_logos', $logoName, 'public');
                $shop->logo = $logoPath;
            }

            // Update shop details
            $shop->name = $request->shop_name;
            $shop->number = $request->shop_contact;
            $shop->email = $request->shop_email;
            $shop->province = $request->province;
            $shop->city = $request->city;
            $shop->postal_code = $request->postal_code;
            $shop->address = $request->shop_address;
            $shop->description = $request->description;
            $shop->website = $request->website;
            $shop->facebook = $request->facebook;
            $shop->instagram = $request->instagram;
            $shop->twitter = $request->twitter;
            $shop->online_quotes = $request->input('online_quotes') == 'Yes' ? 1 : 0;
            $shop->offer_services = $request->input('offer_services') == 'Yes' ? 1 : 0;
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->save();


            ShopServices::where('shop_id', $shop->id)->delete();
            ShopAmenities::where('shop_id', $shop->id)->delete();
            ShopTimings::where('shop_id', $shop->id)->delete();


            // Update shop images
            if ($request->hasFile('shop_images')) {
                foreach ($request->file('shop_images') as $img) {
                    if (!$img) continue;

                    $imageName = microtime(true) . '.' . $img->getClientOriginalExtension();
                    $path = $img->storeAs('shop_images', $imageName, 'public');

                    ShopImages::create([
                        'shop_id' => $shop->id,
                        'path' => $path,
                    ]);
                }
            }

            foreach ($request->services as $service_id) {
                ShopServices::create([
                    'shop_id' => $shop->id,
                    'service_id' => $service_id,
                ]);
            }

            if ($request->amenities) {
                foreach ($request->amenities as $amenity_id) {
                    ShopAmenities::create([
                        'shop_id' => $shop->id,
                        'amenity_id' => $amenity_id,
                    ]);
                }
            }

            foreach ($request->days as $day => $data) {
                if (!isset($data['start'], $data['end'])) {
                    continue;
                }

                ShopTimings::create([
                    'shop_id' => $shop->id,
                    'day' => $day,
                    'start_time' => $data['start'],
                    'end_time' => $data['end'],
                    // 'active' => isset($data['active']),
                ]);
            }


            DB::commit();
            $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'shop_reviews'])->where('id', $id)->first();
            return response()->json([
                'data' => $shop,
                'status' => 200,
                'message' => 'Shop updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_featured_services()
    {
        $featured_services = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'shop_reviews'])
            ->where('status', '1')->where('is_featured', '1')
            ->get();

        $user = auth('sanctum')->user();

        $data = [];

        foreach ($featured_services as $shop) {
            $is_wishlisted = 0;

            if ($user) {
                $is_wishlisted = ShopWishlist::where('user_id', $user->id)
                    ->where('shop_id', $shop->id)
                    ->exists() ? 1 : 0;
            }

            $shopArray = $shop->toArray();
            $shopArray['is_wishlisted'] = $is_wishlisted;

            $data[] = $shopArray;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Featured Shops fetched successfully',
            'data' => $data,
        ], 200);
    }


    public function get_top_rated_services()
    {
        $user = auth('sanctum')->user();
        $userWishlist = [];

        if ($user) {
            $userWishlist = ShopWishlist::where('user_id', $user->id)
                ->pluck('shop_id')
                ->toArray();
        }

        $top_rated_services = Shops::with([
            'shop_amenities',
            'shop_timings',
            'shop_services',
            'shop_images',
            'shop_reviews'
        ])
            ->withCount('shop_reviews as reviews_count')
            ->withAvg('shop_reviews', 'rating')
            ->where('status', '1')
            ->having('reviews_count', '>=', 10)
            ->having('shop_reviews_avg_rating', '>=', 4.5)
            ->get();

        $data = $top_rated_services->map(function ($shop) use ($userWishlist) {
            $shopData = $shop->toArray();
            $shopData['is_wishlisted'] = in_array($shop->id, $userWishlist) ? 1 : 0;
            return $shopData;
        });

        return response()->json([
            'status' => 200,
            'message' => 'Top rated Shops fetched successfully',
            'data' => $data,
        ]);
    }



    public function category_services($category_id)
    {
        $category = ServiceCategories::find($category_id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }

        $services = Services::where('category_id', $category->id)->get();

        $shopservices = ShopServices::whereIn('service_id', $services->pluck('id'))->pluck('shop_id');

        $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'shop_reviews'])
            ->whereIn('id', $shopservices)
            ->where('status', '1')
            ->get();

        $user = auth('sanctum')->user();
        $data = [];

        foreach ($shops as $shop) {
            $is_wishlisted = 0;

            if ($user) {
                $is_wishlisted = ShopWishlist::where('user_id', $user->id)
                    ->where('shop_id', $shop->id)
                    ->exists() ? 1 : 0;
            }

            $shopArray = $shop->toArray();
            $shopArray['is_wishlisted'] = $is_wishlisted;
            $data[] = $shopArray;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Services fetched successfully',
            'data' => $data
        ], 200);
    }


    public function shop_details($id)
    {
        $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'shop_reviews'])->find($id);

        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'Shop not found',
            ], 404);
        }
        $shop->views = $shop->views + 1;
        $shop->save();
        $is_wishlisted = 0;
        $user = auth('sanctum')->user();

        if ($user) {
            $is_wishlisted = ShopWishlist::where('user_id', $user->id)
                ->where('shop_id', $shop->id)
                ->exists() ? 1 : 0;
        }

        $shopData = $shop->toArray();
        $shopData['is_wishlisted'] = $is_wishlisted;

        return response()->json([
            'status' => 200,
            'message' => 'Shop details fetched successfully',
            'data' => $shopData,
        ], 200);
    }


    public function submit_service_quote(Request $request)
    {
        // Log::info($request->all());
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to submit a quote.',
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'vehicle_type' => 'required',
            'body_type' => 'required',
            'vehicle_make' => 'required',
            'vehicle_model' => 'required',
            'year' => 'required',
            'needs_description' => 'required',
            'services' => 'required|array',
            'shop_id' => 'required|exists:shops,id',
            // 'g-recaptcha-response' => 'required',

        ]);
        // ], [
        //     'needs_description.required' => 'Please enter description of your needs.',
        //     'g-recaptcha-response.required' => 'Captcha verification is required',
        // ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // reCAPTCHA Verification
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => '6Ld-aDMrAAAAAKWtw8TU4lXNBRMTChLo_OFhPJ3N',
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->ip(),
        // ]);

        // if (!$response->json('success')) {
        //     return response()->json([
        //         'status' => 422,
        //         'message' => 'Captcha verification failed. Please try again.',
        //     ], 422);
        // }

        try {
            DB::beginTransaction();

            $shop = Shops::find($request->shop_id);
            if (!$shop) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Shop not found',
                ], 404);
            }


            $userId = $user->role == '1' ? $user->id : $user->dealer_id;

            if ($shop->dealer_id == $userId) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You cannot submit a quote for your own shop.',
                ], 422);
            }

            $booking = Bookings::create([
                'type' => $request->vehicle_type,
                'bodytype' => $request->body_type,
                'make' => $request->vehicle_make,
                'model' => $request->vehicle_model,
                'year' => $request->year,
                'comments' => $request->needs_description,
                'user_id' => $user->id,
                'shop_id' => $request->shop_id,
                'status' => '0',
            ]);

            foreach ($request->services as $service_id) {
                BookingServices::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service_id,
                ]);
            }

            $booking = Bookings::with(['shop', 'make_r', 'model_r', 'bodytype_r'])->find($booking->id);
            // dd($booking);
            $body = view('emails.service_quote_submitted', compact('booking'));
            sendMail($user->name, $user->email, 'Auto Jazeera', 'Service Quote Submitted', $body);

            $dealer = User::find($shop->dealer_id);
            $fcm_tokens = [$dealer->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Services Quote', 'body' => 'You have a new services quote from ' . $user->name]);



                Notifications::create([
                    'user_id' => $dealer->id,
                    'title' => 'New Services Quote',
                    'body' => 'You have a new services quote from ' . $user->name,
                    'url' => url('service-quotes'),
                ]);
            }


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Quote submitted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote submission failed: ' . $e->getMessage());
            return response()->json([
                'status' => 422,
                'message' => 'Something went wrong while submitting the quote. Please try again later.',
                'error' => $e->getMessage()
            ], 422);;
        }
    }

    public function filter_services(Request $request)
    {
        // province, city, distance, service type, service, amenity, 

        Log::info($request->all());
        $category = $request->input('service_type');  // single value
        $service = $request->input('service');        // single value
        $amenity = $request->input('amenities');      // single value
        $distance = $request->input('distance');      // in km
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $province = $request->input('province');
        $city = $request->input('city');

        $query = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])
            ->where('status', '1');

        if ($province) {
            $query->where('province', $province);
        }

        if ($city) {
            $query->where('city', $city);
        }
        if ($category) {
            $serviceIds = Services::where('category_id', $category)->pluck('id');
            $shopIds = ShopServices::whereIn('service_id', $serviceIds)->pluck('shop_id');
            $query->whereIn('id', $shopIds);
        }

        if ($service) {
            $shopIds = ShopServices::where('service_id', $service)->pluck('shop_id');
            $query->whereIn('id', $shopIds);
        }

        if ($amenity) {
            $shopIds = ShopAmenities::where('amenity_id', $amenity)->pluck('shop_id');
            $query->whereIn('id', $shopIds);
        }

        $shops = $query->get();
        $filteredShops = [];
        if ($province || $city) {
            if ($latitude && $longitude && $distance) {
                foreach ($shops as $shop) {
                    $shopLat = $shop->latitude;
                    $shopLng = $shop->longitude;

                    try {
                        $apiKey = 'AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0';
                        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$latitude},{$longitude}&destinations={$shopLat},{$shopLng}&key={$apiKey}";

                        $response = file_get_contents($url);
                        $data = json_decode($response, true);

                        if ($data['status'] === 'OK') {
                            $distanceMeters = $data['rows'][0]['elements'][0]['distance']['value'];
                            $distanceKm = $distanceMeters / 1000;

                            if ($distanceKm <= $distance) {
                                $shop->distance = round($distanceKm, 2);
                                $filteredShops[] = $shop;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Google Maps API Error: " . $e->getMessage());
                    }
                }
            } else {
                $filteredShops = $shops;
            }
        } else {
            $filteredShops = $shops;
        }

        return response()->json([
            'status' => true,
            'message' => 'Filtered shops fetched successfully',
            'data' => $filteredShops
        ]);
    }
    public function filter_services_advanced(Request $request)
    {
        $category = $request->input('service_type');  // array
        // $services = $request->input('service');       // array
        $amenities = $request->input('amenities');    // array
        $distance = $request->input('distance');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $province = $request->input('province');
        $city = $request->input('city');

        $query = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])
            ->where('status', '1');

        if ($province) {
            $query->where('province', $province);
        }

        if ($city) {
            $query->where('city', $city);
        }

        if ($category) {
            $serviceIds = Services::whereIn('category_id', $category)->pluck('id');
            $shopIds = ShopServices::whereIn('service_id', $serviceIds)->pluck('shop_id');
            $query->whereIn('id', $shopIds);
        }

        // if (!empty($services) && is_array($services)) {
        //     $shopIds = ShopServices::whereIn('service_id', $services)->pluck('shop_id');
        //     $query->whereIn('id', $shopIds);
        // }

        if (!empty($amenities) && is_array($amenities)) {
            $shopIds = ShopAmenities::whereIn('amenity_id', $amenities)->pluck('shop_id');
            $query->whereIn('id', $shopIds);
        }

        $shops = $query->get();
        $filteredShops = [];

        if ($province || $city) {
            if ($latitude && $longitude && $distance) {
                foreach ($shops as $shop) {
                    $shopLat = $shop->latitude;
                    $shopLng = $shop->longitude;

                    try {
                        $apiKey = 'AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0';
                        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$latitude},{$longitude}&destinations={$shopLat},{$shopLng}&key={$apiKey}";

                        $response = file_get_contents($url);
                        $data = json_decode($response, true);

                        if ($data['status'] === 'OK') {
                            $distanceMeters = $data['rows'][0]['elements'][0]['distance']['value'];
                            $distanceKm = $distanceMeters / 1000;

                            if ($distanceKm <= $distance) {
                                $shop->distance = round($distanceKm, 2);
                                $filteredShops[] = $shop;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Google Maps API Error: " . $e->getMessage());
                    }
                }
            } else {
                $filteredShops = $shops;
            }
        } else {
            $filteredShops = $shops;
        }

        return response()->json([
            'status' => true,
            'message' => 'Filtered shops fetched successfully',
            'data' => $filteredShops
        ]);
    }


    public function submit_review(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'comment' => 'required|string|min:20',
            'rating' => 'required|integer|between:1,5',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            // own shop check 

            if ($user->role == '2') {
                $userid = $user->dealer_id;
            } else {
                $userid = $user->id;
            }

            $check = Shops::where('dealer_id', $userid)->where('id', $request->shop_id)->first();
            if ($check) {
                return response()->json(['status' => 422, 'message' => 'You cannot review your own shop.']);
            }

            $shopReview = ShopReview::create([
                'shop_id' => $request->shop_id,
                'comment' => $request->comment,
                'rating' => $request->rating,
                'user_id' => $user->id,
            ]);

            if ($request->hasFile('review_images')) {
                foreach ($request->file('review_images') as $image) {
                    $imageName = 'review-' . microtime(true) . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('shop_reviews', $imageName, 'public');

                    ShopReviewImage::create([
                        'review_id' => $shopReview->id,
                        'path' => 'storage/shop_reviews/' . $imageName,
                    ]);
                }
            }

            $body = view('emails.new_review', compact('shopReview'));
            $user = User::find($shopReview->shop->dealer_id);
            sendMail($user->name, $user->email, 'Auto Jazeera', 'New Review Submitted', $body);

            $fcm_tokens = [$user->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Review Submitted', 'body' => 'You have a new review on your shop']);



                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Plan Cancelled',
                    'body' => 'You have a new review on your shop',
                    'url' => url('shop'),
                ]);
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Review added successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review Save Failed: ' . $e->getMessage());

            return response()->json(['status' => 500, 'message' => 'Failed to add review', 'error' => $e->getMessage()], 500);
        }
    }

    public function get_services($id)
    {
        $services = Services::where('category_id', $id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'services fetched successfully',
            'data' => $services
        ], 200);
    }

    public function submitted_service_quotes()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to View Quotes.',
            ], 401);
        }
        Log::info($user);
        $quotes = Bookings::with(['shop', 'make_r', 'model_r', 'bodytype_r', 'booking_services'])->where('user_id', $user->id)->get();
        Log::info($quotes);
        // dd($quotes);  

        return response()->json([
            'status' => 200,
            'message' => 'Quotes fetched successfully',
            'data' => $quotes
        ], 200);
    }


    public function received_service_quotes()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '3') {
            $userId = $user->dealer_id;
        } else {
            $userId = $user->id;
        }
        $check = Shops::where('dealer_id', $userId)->first();
        if (!$check) {
            return response()->json([
                'status' => 401,
                'message' => 'You have not created a shop yet. Please create a shop first.',
            ], 401);
        }

        $quotes = Bookings::with(['shop', 'make_r', 'model_r', 'bodytype_r', 'booking_services', 'user'])->where('shop_id', $check->id)->get();
        // dd($quotes);  

        return response()->json([
            'status' => 200,
            'message' => 'Quotes fetched successfully',
            'data' => $quotes
        ], 200);
    }

    public function service_users()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to View Users.',
            ], 401);
        }
        $users = User::where('role', '3')->where('dealer_id', $user->id)->get();
        // dd($users);  
        return response()->json([
            'status' => 200,
            'message' => 'Users fetched successfully',
            'data' => $users
        ], 200);
    }

    public function get_service_user($id)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to View Users.',
            ], 401);
        }
        $user = User::where('role', '3')->where('dealer_id', $user->id)->where('id', $id)->first();
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'User fetched successfully',
            'data' => $user
        ], 200);
    }


    public function create_service_user(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to Create Users.',
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'number' => 'required|string|max:255|unique:users,number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        $userr = new User();
        $userr->name = $request->name;
        $userr->email = $request->email;
        $userr->number = $request->number;
        $userr->password = bcrypt($request->number);
        $userr->role = 3;
        $userr->dealer_id = $user->id;
        $userr->status = 'inactive';
        $userr->save();
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',

        ], 200);
    }

    public function update_service_user(Request $request, $id)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to Update Users.',
            ], 401);
        }

        $userr = User::where('id', $id)->where('role', '3')->where('dealer_id', $user->id)->first();

        if (!$userr) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userr->id,
            'number' => 'required|string|max:255|unique:users,number,' . $userr->id,
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userr->name = $request->name;
        $userr->email = $request->email;
        $userr->number = $request->number;
        $userr->status = $request->status;
        $userr->save();

        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully',
        ], 200);
    }


    public function delete_service_user($id)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role == '3') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to Delete Users.',
            ], 401);
        }
        $userr = User::where('id', $id)->where('role', '3')->where('dealer_id', $user->id)->first();
        if (!$userr) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
        $userr->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully',

        ], 200);
    }

    public function get_price_alert_leads()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if ($user->role != '1') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to View Price Alert leads.',
            ], 401);
        }
        $posts = Post::where('dealer_id', $user->id)->pluck('id')->toArray();

        $car_price_alerts = PriceAlert::with('post', 'user')
            ->whereIn('post_id', $posts)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();

        $bikes = BikePost::where('dealer_id', $user->id)->pluck('id')->toArray();
        $bike_price_alerts = BikePriceAlert::with('post', 'user')
            ->whereIn('post_id', $bikes)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $data['car_price_alerts'] = $car_price_alerts;
        $data['bike_price_alerts'] = $bike_price_alerts;
        return response()->json([
            'status' => 200,
            'message' => 'Price Alert leads fetched successfully',
            'data' => $data,
        ], 200);
    }
}
