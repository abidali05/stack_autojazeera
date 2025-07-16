<?php

namespace App\Http\Controllers\Bikes\superadmin;

use App\Models\City;
use App\Models\User;
use App\Models\Color;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikePost;
use App\Models\Bike\BikeModels;
use App\Models\Bike\BikeBodyTypes;
use App\Http\Controllers\Controller;
use App\Models\Bike\BikeMainFeatures;


class BikePostController extends Controller
{
    public function index()
    {
        $posts = BikePost::all();
        return view('bikes.superadmin.bike_ads.index', compact('posts'));
    }

    public function create(){

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
}
