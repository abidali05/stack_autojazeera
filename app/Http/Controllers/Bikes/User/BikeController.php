<?php

namespace App\Http\Controllers\Bikes\User;

use App\Models\City;
use App\Models\Post;
use App\Models\User;
use App\Models\Color;
use App\Models\BodyType;
use App\Models\Province;
use App\Models\MainFeature;
use App\Models\MakeCompany;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikePost;
use App\Models\Bike\BikeModels;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Autoservices\ServiceCategories;
use App\Models\Bike\BikeLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Bike\BikeMainFeatures;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BikeController extends Controller
{
    // to view the bike home page 
    public function index()
    {

        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();


        $featured_new_posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->where('is_featured', '1')->where('condition', 'new')->orderBy('created_at', 'DESC')->latest()->take(12)->get();

        $featured_used_posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->where('is_featured', '1')->where('condition', 'used')->orderBy('created_at', 'DESC')->latest()->take(12)->get();

        return view('bikes.user.bike_home', compact('makes', 'models', 'colors', 'provinces', 'cities',  'features', 'bodytypes', 'featured_new_posts', 'featured_used_posts'));
    }



    public function get_model($modelId, Request $request)
    {


        $models = BikeModels::where('make_id', $modelId)->where('status', 1)->get();

        return response()->json($models);
    }

    public function listing()
    {

        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->where('condition', 'new')->orderBy('created_at', 'DESC')->latest()->paginate(12);

        return view('bikes.user.bike_listing', compact('posts', 'makes', 'models', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();

        $posts = BikePost::where('status', 1)
            ->when($request->body_type, fn($q) => $q->where('body_type', $request->body_type))
            ->when($request->model, fn($q) => $q->where('model', $request->model))
            ->when($request->make, fn($q) => $q->where('make', $request->make))
            ->when($request->exterior_color, fn($q) => $q->where('color', $request->exterior_color))
            ->when($request->condition, fn($q) => $q->where('condition', $request->condition))
            ->when(
                $request->filled('province'),
                fn($q) =>
                $q->whereHas('location', fn($sub) => $sub->where('province', $request->province))
            )
            ->when(
                $request->filled('city'),
                fn($q) =>
                $q->whereHas('location', fn($sub) => $sub->where('city', $request->city))
            )
            ->with(['features', 'location', 'contacts', 'media', 'dealer'])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->paginate(25);

        // dd($posts);

        return view('bikes.user.bike_listing', compact(
            'posts',
            'makes',
            'models',
            'colors',
            'provinces',
            'cities',
            'features',
            'bodytypes'
        ));
    }

    public function new_used_bikes($name)
    {
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->where('condition', $name)->orderBy('created_at', 'DESC')->latest()->paginate(25);

        return view('bikes.user.bike_listing', compact(
            'posts',
            'makes',
            'models',
            'colors',
            'provinces',
            'cities',
            'features',
            'bodytypes'
        ));
    }

    public function search_data($id, $type)
    {
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();
        $type = $type == 'bodytype' ? 'body_type' : 'make';
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->where($type, $id)->orderBy('is_featured', 'DESC')->latest()->paginate(25);

        return view('bikes.user.bike_listing', compact(
            'posts',
            'makes',
            'models',
            'colors',
            'provinces',
            'cities',
            'features',
            'bodytypes'
        ));
    }

    public function check_price_range(Request $request)
    {
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('status', 1)->whereRaw("CAST(price AS UNSIGNED) BETWEEN ? AND ?", [(int) $request->min, (int) $request->max])->orderBy('created_at', 'DESC')->latest()->paginate(25);

        return view('bikes.user.bike_listing', compact(
            'posts',
            'makes',
            'models',
            'colors',
            'provinces',
            'cities',
            'features',
            'bodytypes'
        ));
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        $query = BikePost::where('status', '1');

        $query
            ->when($request->condition, fn($q) => $q->whereIn('condition', $request->condition))
            ->when($request->year_from && $request->year_to, fn($q) => $q->whereBetween('year', [$request->year_from, $request->year_to]))
            ->when($request->assembly, fn($q) => $q->where('assembly', $request->assembly))
            ->when($request->make, fn($q) => $q->where('make', $request->make))
            ->when($request->model, fn($q) => $q->where('model', $request->model))
            ->when(
                $request->filled('province'),
                fn($q) =>
                $q->whereHas('location', fn($sub) => $sub->where('province', $request->province))
            )
            ->when(
                $request->filled('city'),
                fn($q) =>
                $q->whereHas('location', fn($sub) => $sub->where('city', $request->city))
            )
            ->when($request->min_price || $request->max_price, fn($q) => $q->whereBetween('price', [(int)$request->min_price, (int)$request->max_price]))
            ->when($request->fuel_capacity, fn($q) => $q->where('fuel_capacity', $request->fuel_capacity))
            ->when($request->mileage_from || $request->mileage_to, fn($q) => $q->whereBetween('mileage', [(int)$request->mileage_from, (int)$request->mileage_to]))
            ->when($request->body_type, fn($q) => $q->where('body_type', $request->body_type))
            ->when($request->color, fn($q) => $q->where('color', $request->color))
            ->when($request->is_featured == 'on', fn($q) => $q->where('is_featured', true))
            // ->when($request->userType, fn($q) => $q->whereIn('user_type', $request->userType))
            ->when($request->fuel_type, fn($q) => $q->where('fuel_type', $request->fuel_type))

            ->when($request->transmission, fn($q) => $q->whereIn('transmission', $request->transmission));

        if ($request->sort_by) {
            match ($request->sort_by) {
                'Newest First' => $query->orderByDesc('created_at'),
                'Oldest First' => $query->orderBy('created_at'),
                'Price: Low to High' => $query->orderBy('price'),
                'Price: High to Low' => $query->orderByDesc('price'),
                'Model Year: Latest First' => $query->orderByDesc('year'),
                'Model Year: Oldest First' => $query->orderBy('year'),
                'Mileage: Low to High' => $query->orderBy('mileage'),
                'Mileage: High to Low' => $query->orderByDesc('mileage'),
                default => null,
            };
        }
        // dd($query->toSql(), $query->getBindings());

        $posts = $query->paginate(25);
        if ($request->filled('userType')) {
            $userTypes = (array) $request->userType;

            $posts->load('dealer');
            // dd($posts[0]->dealer);

            $filtered = $posts->filter(function ($post) use ($userTypes) {
                return $post->dealer && in_array($post->dealer->userType, $userTypes);
            })->values(); // reset keys

            // Manually paginate filtered collection
            $perPage = 25;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $pagedResults = new LengthAwarePaginator(
                $filtered->forPage($currentPage, $perPage),
                $filtered->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $posts = $pagedResults;
        }

        $html = view('partials.filtered_bikes', compact('posts'))->render();
        $perPage = 25;
        return response()->json([
            'html' => $html,
            'count' => count($posts),
        ]);
    }


    public function indexs()
    {
        $cities = City::all();
        $service_categories = ServiceCategories::paginate(25);
        return view('services.home', compact('cities', 'service_categories'));
    }
    public function advertise()
    {
        if(!Auth::check()){
            return redirect('subscription-plans');
        }
        if(Auth::user()->package == Null){
            return redirect('subscription')->with('error', 'Please upgrade your plan to post an ad.');
        }
        return view('advertise');
    }
}
