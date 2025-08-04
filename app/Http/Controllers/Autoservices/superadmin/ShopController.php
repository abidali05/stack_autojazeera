<?php

namespace App\Http\Controllers\Autoservices\superadmin;

use App\Models\City;
use App\Models\User;
use App\Models\Shops;
use App\Models\Province;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AutoServices\Services;
use App\Models\Autoservices\Amenities;
use App\Models\Autoservices\ShopImages;
use Illuminate\Support\Facades\Storage;
use App\Models\Autoservices\ShopTimings;
use App\Models\AutoServices\ShopServices;
use App\Models\AutoServices\ShopAmenities;


class ShopController extends Controller
{
    public function index()
    {
        $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'dealer'])->get();
        return view('superadmin.autoservices.shops.index', compact('shops'));
    }

    public function update_status(Request $request)
    {

        $shop = Shops::findOrFail($request->id);
        if (!$shop) {
            return redirect()->route('superadmin.shops.index')->with('shopresponse', 'Shop not found.');
        }
        $shop->status = $request->status;
        $shop->rejection_reason = $request->rejection_reason ?? null;
        $shop->save();

        $body = view('emails.shop_status_update', compact('shop'));
        $user = User::where('id', $shop->dealer_id)->first();
        sendMail($user->name, $user->email, 'Auto Jazeera', 'Shop Status Update', $body);
        return redirect()->back()->with('shopresponse', 'Shop updated successfully.');
    }

    public function edit($id)
    {
        $shop = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->findOrFail($id);
        $provinces = Province::all();
        $cities = City::all();
        $services = Services::all()->groupBy('category_name');
        $amenities = Amenities::all();
        if (!$shop) {
            return redirect()->back()->with('shopresponse', 'Shop not found');
        }
        $user = User::findOrFail($shop->dealer_id);
        return view('superadmin.autoservices.shops.edit', compact('shop', 'provinces', 'cities', 'services', 'amenities', 'user'));
       
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
            $user = User::findOrFail($shop->dealer_id);
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
            $shop->is_featured = $user->shop_package->is_featured ?? '0';
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

            return redirect()->route('superadmin.shops.index')->with('response', 'Shop updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('response', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function shop_reviews()
    {
        $reviews = ShopReview::with(['shop', 'review_images'])->get();
        return view('superadmin.autoservices.shops.all_reviews', compact('reviews'));
    }

    public function delete_shop_review(Request $request, $id)
    {

        $review = ShopReview::where('id', $id)->first();

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found.');
        }

        try {
            DB::beginTransaction();

            // Delete associated images from storage and DB
            foreach ($review->review_images as $image) {
                $imagePath = str_replace('storage/', '', $image->path);
                Storage::disk('public')->delete($imagePath);
                $image->delete();
            }

            $review->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review Delete Failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to delete review. Please try again later.');
        }
    }
}
