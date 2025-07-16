<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\User;
use App\Models\Shops;
use App\Models\BodyType;
use App\Models\Province;
use App\Models\MakeCompany;
use Illuminate\Support\Str;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Notifications;
use App\Models\Bike\BikeModels;

use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\AutoServices\Bookings;
use App\Models\AutoServices\Services;
use App\Models\AutoServices\Amenities;
use App\Models\AutoServices\ShopImages;
use Illuminate\Support\Facades\Storage;
use App\Models\AutoServices\ShopTimings;
use App\Models\AutoServices\ShopServices;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ShopAmenities;
use App\Models\AutoServices\BookingServices;


class ShopController extends Controller
{
    public function index()
    {
        if (Auth::user() && Auth::user()->shop_package != null) {

            $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('dealer_id', Auth::user()->id)->first();
            if (!$shop) {
                return redirect()->route('shop.create')->with('error', 'You have not created a shop yet. Please create a shop first.');
            }
            return view('user.shop.index', compact('shop'));
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
    }

    public function create()
    {

        if (Auth::user()->shop_package != null) {
            $shop = Shops::where('dealer_id', Auth::user()->id)->first();
            if ($shop) {
                return redirect()->route('shop.index')->with('error', 'You have already created a shop. Please edit it instead.');
            }
            $provinces = Province::all();
            $cities = City::all();
            $services = Services::all()->groupBy('category_name');
            $amenities = Amenities::all();
            return view('user.shop.create', compact('provinces', 'cities', 'services', 'services', 'amenities'));
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
    }


    public function store(Request $request)
    {
        // Log::info($request->all());

        // dd($request->all());
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255|unique:shops,name',
            'shop_contact' => 'required|string|max:20|unique:shops,number|min:13',
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

        DB::beginTransaction();

        try {
            // Rename logo
            $logoFile = $request->file('shop_logo');
            $logoName = microtime(true) . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('shop_logos', $logoName, 'public');

            $shop = Shops::create([
                'dealer_id' => Auth::id(),
                'name' => $validated['shop_name'],
                'number' => $validated['shop_contact'],
                'email' => $validated['shop_email'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'address' => $validated['shop_address'],
                'description' => $validated['description'],
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
                'twitter' => $request->input('twitter'),
                'logo' => $logoPath,
                'online_quotes' => $request->input('online_quotes') ? 1 : 0,
                'offer_services' => $request->input('offer_services') ? 1 : 0,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'is_featured' => Auth::user()->shop_pkg->metadata->feature_allowed == '1' ?? '0',

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

            return redirect()->route('shop.index')->with('success', 'Shop created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        if (Auth::user()->shop_package != null) {
            $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->findOrFail($id);
            $provinces = Province::all();
            $cities = City::all();
            $services = Services::all()->groupBy('category_name');
            $amenities = Amenities::all();
            return view('user.shop.edit', compact('shop', 'provinces', 'cities', 'services', 'amenities'));
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
    }

    public function deleteShopImage($image_id, $shop_id)
    {
        $images = ShopImages::where('shop_id', $shop_id)->count();
        if ($images <= 1) {
            return redirect()->back()->with('imagedeleteresponse', 'You must have at least one image.');
        } else {
            $image = ShopImages::find($image_id);
            if (!$image) {
                return redirect()->back()->with('imagedeleteresponse', 'Image not found.');
            } else {

                $iconPath = $image->getRawOriginal('path');


                if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                    Storage::disk('public')->delete($iconPath);
                }
                ShopImages::where('id', $image_id)->delete();

                return redirect()->back()->with('imagedeleteresponse', 'Image deleted successfully.');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255|unique:shops,name,' . $id,
            'shop_contact' => 'required|string|max:20|min:13|unique:shops,number,' . $id,
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

        DB::beginTransaction();

        try {
            $shop = Shops::findOrFail($id);
            if (!$shop) {
                return redirect()->back()->with('imagedeleteresponse', 'Shop not found.');
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
            $shop->name = $validated['shop_name'];
            $shop->number = $validated['shop_contact'];
            $shop->email = $validated['shop_email'];
            $shop->province = $validated['province'];
            $shop->city = $validated['city'];
            $shop->postal_code = $validated['postal_code'];
            $shop->address = $validated['shop_address'];
            $shop->description = $validated['description'];
            $shop->website = $validated['website'];
            $shop->facebook = $validated['facebook'];
            $shop->instagram = $validated['instagram'];
            $shop->twitter = $validated['twitter'];
            $shop->online_quotes = $request->input('online_quotes') == 'Yes' ? 1 : 0;
            $shop->offer_services = $request->input('offer_services') == 'Yes' ? 1 : 0;
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->is_featured = Auth::user()->shop_package->is_featured ?? '0';
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

            return redirect()->route('shop.index')->with('response', 'Shop updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('response', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function shopdetail($id)
    {
        $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('id', $id)->first();
        if (!$shop) {
            return redirect()->back()->with('error', 'Shop not found.');
        }
        $shop->views = $shop->views + 1;
        $shop->save();

        return view('shopdetail', compact('shop'));
    }


    public function get_vehicle_body_type($vehicle)
    {
        if ($vehicle == 'car') {
            $vehicle_body_types = BodyType::where('status', '1')->get();
        } else {
            $vehicle_body_types = BikeBodyTypes::where('status', '1')->get();
        }

        return response()->json(['status' => 200, 'body_types' => $vehicle_body_types]);
    }

    public function get_vehicle_make($vehicle)
    {
        if ($vehicle == 'car') {
            $vehicle_makes = MakeCompany::where('status', '1')->get();
        } else {
            $vehicle_makes = BikeMake::where('status', '1')->get();
        }

        return response()->json(['status' => 200, 'makes' => $vehicle_makes]);
    }

    public function get_vehicle_model($vehicle, $make_id)
    {
        if ($vehicle == 'car') {
            $vehicle_models = ModelCompany::where('status', '1')->where('make_id', $make_id)->get();
        } else {
            $vehicle_models = BikeModels::where('status', '1')->where('make_id', $make_id)->get();
        }

        return response()->json(['status' => 200, 'models' => $vehicle_models]);
    }


    public function submit_quote(Request $request)
    {
        if (Auth::user()->role == '3') {
            return response()->json(['success' => false, 'message' => 'You are not authorized to submit a quote.']);
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
            'g-recaptcha-response' => 'required',
        ], [
            'needs_description.required' => 'Please enter description of your needs.',
            'g-recaptcha-response.required' => 'Captcha verification is required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // reCAPTCHA Verification
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6Ld-aDMrAAAAAKWtw8TU4lXNBRMTChLo_OFhPJ3N',
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return response()->json(['success' => false, 'message' => 'Captcha verification failed']);
        }

        try {
            DB::beginTransaction();

            $shop = Shops::find($request->shop_id);
            if (!$shop) {
                return response()->json(['success' => false, 'message' => 'Shop not found']);
            }

            $user = Auth::user();
            $userId = $user->role == '1' ? $user->id : $user->dealer_id;

            // if ($shop->dealer_id == $userId) {
            //     return response()->json(['success' => false, 'message' => 'You cannot book a quote for your own shop']);
            // }

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
                    'title' => 'New Sales Lead',
                    'body' => 'You have a new services quote from ' . $user->name,
                    'url' => url('service-quotes'),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Quote Submitted Successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote submission failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.']);
        }
    }


    public function get_quotes()   // received quotes
    {

        $user = Auth::user();
        if ($user->role == '3') {
            $userId = $user->dealer_id;
        } else {
            $userId = $user->id;
        }
        // check if shop exists or not 
        $shop = Shops::where('dealer_id', $userId)->first();
        if (!$shop) {
            if ($user->role == '3') {
                return redirect()->route('dashboard')->with('error', 'Your admin has not created a shop yet.');
            } else {
                return redirect()->route('dashboard')->with('error', 'You have not created a shop yet. Please create a shop first.');
            }
        }

        $bookings = Bookings::with(['shop', 'make_r', 'model_r', 'bodytype_r', 'user'])->where('shop_id', $shop->id)->paginate(25);


        return view('user.quotes.index', compact('bookings'));
    }


    public function get_submitted_quotes()   // submitted quotes
    {

        $user = Auth::user();

        if ($user->role == '3') {
            $userId = $user->dealer_id;
        } else {
            $userId = $user->id;
        }

        $bookings = Bookings::with(['shop', 'make_r', 'model_r', 'bodytype_r', 'user'])->where('user_id', $userId)->paginate(25);


        return view('user.quotes.submitted_quotes', compact('bookings'));
    }
}
