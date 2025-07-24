<?php

namespace App\Http\Controllers\Autoservices;

use App\Models\City;
use App\Models\Shops;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AutoServices\Services;
use App\Models\AutoServices\Amenities;
use App\Models\AutoServices\ShopServices;
use App\Models\AutoServices\ShopAmenities;
use App\Models\AutoServices\ServiceCategories;

class ServicesController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $service_categories = ServiceCategories::get();
        // $top_rated_services = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('status', '1')->get();
        $top_rated_services = Shops::with([
            'shop_amenities',
            'shop_timings',
            'shop_services',
            'shop_images'
        ])
            ->withCount(['shop_reviews as reviews_count'])
            ->withAvg('shop_reviews', 'rating')
            ->where('status', '1')
            ->having('reviews_count', '>=', 10)
            ->having('shop_reviews_avg_rating', '>=', 4.4)
            ->get();

        // $featured_services = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where([
        //     'status' => '1'

        // ])->get();
        $featured_services = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where([
            'status' => '1',
            'is_featured' => '1'
        ])->get();
        return view('services.home', compact('cities', 'service_categories', 'top_rated_services', 'featured_services'));
    }


    // search from service home page 

    public function search(Request $request)
    {
        // dd($request->all());
        $search = $request->search;     
        $city = $request->input('city') === '1e' ? null : $request->input('city');
        $page = $request->input('page', 1);
        $query = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where('status', '1');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($city) {
            $query->where('city', $city);
        }
        $shops = $query->paginate(25, ['*'], 'page', $page);

        $service_categories = ServiceCategories::all();
        $amenities = Amenities::all();
        $provinces = Province::all();
        return view('services.search', compact('shops', 'service_categories', 'amenities', 'provinces'));
    }

    public function filter(Request $request)
    {
        $categories = $request->input('category', []);
        $amenities = $request->input('amenity', []);

        $serviceIds = Services::whereIn('category_id', $categories)->pluck('id');
        $shopIdsByServices = ShopServices::whereIn('service_id', $serviceIds)->pluck('shop_id');
        $shopIdsByAmenities = ShopAmenities::whereIn('amenity_id', $amenities)->pluck('shop_id');

        $shopIds = array_unique(array_merge($shopIdsByServices->toArray(), $shopIdsByAmenities->toArray()));

        $query = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])
            ->where('status', '1');

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
            Log::info('City filter applied', ['city' => $request->input('city')]);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->input('province'));
            Log::info('Province filter applied', ['province' => $request->input('province')]);
        }

        if (!empty($shopIds)) {
            $query->whereIn('id', $shopIds);
            Log::info('Shop ID filter applied', ['shop_ids' => $shopIds]);
        }

        $shops = $query->get();
        Log::info('Fetched shops count', ['count' => $shops->count()]);

        if (empty($categories) && empty($amenities) && !$request->filled('city') && !$request->filled('province') && empty($shopIds)) {
            Log::info('No filters applied, loading all active shops');
            $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])
                ->where('status', '1')
                ->get();
        }

        $filteredShops = [];

        // Distance filter only applies if city and province are NOT filled and coordinates are provided
        if (
            !$request->filled('city') &&
            !$request->filled('province')
        ) {
            if (!$request->filled('latitude') || !$request->filled('longitude')) {
                Log::warning('Latitude or longitude missing from request; skipping distance filtering', [
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                ]);
                $filteredShops = $shops;
            } else {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');

                // Default distance is 10 km if nothing provided
                $maxDistance = 10;
                if ($request->filled('distance') && $request->input('distance') !== 'custom') {
                    $maxDistance = $request->input('distance');
                } elseif ($request->input('distance') === 'custom' && $request->filled('custom_distance')) {
                    $maxDistance = $request->input('custom_distance');
                }

                Log::info('Applying distance filter', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'max_distance_km' => $maxDistance,
                ]);

                foreach ($shops as $shop) {
                    $shopLat = $shop->latitude;
                    $shopLng = $shop->longitude;

                    if (empty($shopLat) || empty($shopLng)) {
                        Log::warning("Skipping shop ID {$shop->id} due to missing destination coordinates", [
                            'dest_lat' => $shopLat,
                            'dest_lng' => $shopLng,
                        ]);
                        continue;
                    }

                    try {
                        $apiKey = 'AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0';
                        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$latitude},{$longitude}&destinations={$shopLat},{$shopLng}&key={$apiKey}";

                        $response = file_get_contents($url);
                        $data = json_decode($response, true);

                        if (!is_array($data)) {
                            Log::error("Invalid JSON from Google Maps API for shop ID {$shop->id}", ['response' => $response]);
                            continue;
                        }

                        if (!isset($data['status']) || $data['status'] !== 'OK') {
                            Log::warning("Google Maps API returned non-OK status for shop ID {$shop->id}", ['status' => $data['status'] ?? 'MISSING']);
                            continue;
                        }

                        if (
                            !isset($data['rows'][0]['elements'][0]['status']) ||
                            $data['rows'][0]['elements'][0]['status'] !== 'OK'
                        ) {
                            Log::warning("Google Maps API element status NOT_OK for shop ID {$shop->id}", [
                                'element_status' => $data['rows'][0]['elements'][0]['status'] ?? 'MISSING',
                                'full_response' => $data,
                            ]);
                            continue;
                        }

                        if (!isset($data['rows'][0]['elements'][0]['distance']['value'])) {
                            Log::warning("Distance key missing in Google Maps API response for shop ID {$shop->id}", ['response' => $data]);
                            continue;
                        }

                        $distanceMeters = $data['rows'][0]['elements'][0]['distance']['value'];
                        $distanceKm = $distanceMeters / 1000;

                        if ($distanceKm <= $maxDistance) {
                            $shop->distance = round($distanceKm, 2);
                            $filteredShops[] = $shop;
                        } else {
                            Log::info("Shop ID {$shop->id} skipped; distance exceeds max", ['distance_km' => $distanceKm]);
                        }
                    } catch (\Exception $e) {
                        Log::error("Google Maps API Error for shop ID {$shop->id}: " . $e->getMessage());
                    }
                }
            }
        } else {
            Log::info('Skipping distance filtering due to city or province filter being applied');
            $filteredShops = $shops;
        }

        $currentPage = $request->input('page', 1);
        $perPage = 10;

        $paginatedShops = new \Illuminate\Pagination\LengthAwarePaginator(
            collect($filteredShops)->forPage($currentPage, $perPage),
            count($filteredShops),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $html = view('services.filter_partial', ['shops' => $paginatedShops])->render();

        Log::info('Returning filtered shop list', ['total_filtered' => count($filteredShops)]);
        if ($request->is_ajax == '1' || $request->is_ajax == 1) {
            return response()->json(['html' => $html]);
        } else {
            $service_categories = ServiceCategories::all();
            $amenities = Amenities::all();
            $provinces = Province::all();
            $shops = $paginatedShops;
            return view('services.search', compact('shops', 'service_categories', 'amenities', 'provinces'));
        }
    }




    public function searchByCategory($name)
    {
        $category = ServiceCategories::where('name', $name)->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        $services = Services::where('category_id', $category->id)->get();
        $shopservices = ShopServices::whereIn('service_id', $services->pluck('id')->toArray())->pluck('shop_id')->toArray();
        $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->whereIn('id', $shopservices)->where('status', '1')->paginate(25);

        $service_categories = ServiceCategories::all();
        $amenities = Amenities::all();
        $provinces = Province::all();

        return view('services.search', compact('shops', 'service_categories', 'amenities', 'provinces'));
    }

    public function allFeaturedServices()
    {
        // dd('zaid');
        $service_categories = ServiceCategories::all();
        $amenities = Amenities::all();
        $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images'])->where([
            'status' => '1',
            'is_featured' => '1'
        ])->paginate(25);
        $provinces = Province::all();
        return view('services.search', compact('shops', 'service_categories', 'amenities', 'provinces'));
    }


    public function allTopRatedServices()
    {
        // dd('zaid');
        $service_categories = ServiceCategories::all();
        $amenities = Amenities::all();
        $shops = Shops::with([
            'shop_amenities',
            'shop_timings',
            'shop_services',
            'shop_images'
        ])
            ->withCount(['shop_reviews as reviews_count'])
            ->withAvg('shop_reviews', 'rating')
            ->where('status', '1')
            ->having('reviews_count', '>=', 10)
            ->having('shop_reviews_avg_rating', '>=', 4.5)
            ->paginate(25);
        $provinces = Province::all();
        return view('services.search', compact('shops', 'service_categories', 'amenities', 'provinces'));
    }
}
