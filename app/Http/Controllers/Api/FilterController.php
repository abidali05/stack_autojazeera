<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Post;
use App\Models\Color;
use App\Models\BodyType;
use App\Models\Province;
use App\Models\Whishlist;
use App\Models\PriceAlert;
use App\Models\MainFeature;
use App\Models\MakeCompany;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\location;

class FilterController extends Controller
{
    public function model()
    {
        $model = ModelCompany::withCount('posts')->where('status', 1)->get();
        if ($model->isNotEmpty()) {
            return response()->json([
                "data" => $model,
                "status" => 200,
                "message" => "model found"
            ], 200);
        } else {
            return response()->json([
                "data" => $model,
                "status" => 202,
                "message" => "model not found"
            ], 202);
        }
    }

    public function make()
    {
        $make = MakeCompany::with('model')->withCount('posts')->where('status', 1)->get();
        if ($make->isNotEmpty()) {
            return response()->json([
                "data" => $make,
                "status" => 200,
                "message" => "make found"
            ], 200);
        } else {
            return response()->json([
                "data" => $make,
                "status" => 202,
                "message" => "make not found"


            ], 202);
        }
    }

    public function city()
    {
        $city = City::orderByRaw('id = 85 DESC')->get();

        if ($city->isNotEmpty()) {
            return response()->json([
                "data" => $city,
                "status" => 200,
                "message" => "city found"


            ], 200);
        } else {
            return response()->json([
                "data" => $city,
                "status" => 202,
                "message" => "city not found"

            ], 202);
        }
    }

    public function bodytype()
    {
        $bodytype = BodyType::where('status', 1)->get();
        if ($bodytype->isNotEmpty()) {
            return response()->json([
                "data" => $bodytype,
                "status" => 200,
                "message" => "bodytype found"


            ], 200);
        } else {
            return response()->json([
                "data" => $bodytype,
                "status" => 202,
                "message" => "bodytype not found"


            ], 202);
        }
    }
    public function usedcar(Request $request)
    {
        $usedcar = Post::orderBy('feature_ad', 'desc')->with(['feature' => function ($query) {
            $query->with('mainfeature')->get();
        }, 'document', 'location', 'location.province', 'location.city', 'contact', 'dealer'])->where(['status' => 1, 'condition' => 'used']);
        if ($request->feature_ad && $request->feature_ad == 1) {
            $usedcar->where('feature_ad', 1);
        }
        $usedcar = $usedcar->get();


        $usedcar->each(function ($car) {
            $car->shareable_link = route('cardetail', ['id' => $car->id]);
        });

        if ($usedcar->isNotEmpty()) {
            $user = auth('sanctum')->user();
            if ($user) {


                foreach ($usedcar as $post) {
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


                foreach ($usedcar as $post) {
                    $post->favorite = 0;
                }
            }

            return response()->json([
                "data" => $usedcar,
                "status" => 200,
                "message" => "used car found"


            ], 200);
        } else {
            return response()->json([
                "data" => $usedcar,
                "status" => 202,
                "message" => "used car not found"


            ], 202);
        }
    }
    public function newcar(Request $request)
    {
        $posts = Post::orderBy('feature_ad','Desc')->with(['feature' => function ($query) {

            $query->with('mainfeature')->get();
        }, 'document', 'location', 'location.province', 'location.city', 'contact', 'dealer'])->where(['status' => 1, 'condition' => 'new']);
        if ($request->feature_ad && $request->feature_ad == 1) {
            $posts->where('feature_ad', 1);
        }
        $posts = $posts->get();

        $posts->each(function ($car) {
            $car->shareable_link = route('cardetail', ['id' => $car->id]);
        });

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
                "message" => "new cars found"


            ], 200);
        } else {
            return response()->json([
                "data" => $posts,
                "status" => 202,
                "message" => "new cars not found"


            ], 202);
        }
    }
    public function color()
    {
        $color = Color::all();
        if ($color->isNotEmpty()) {
            return response()->json([
                "data" => $color,
                "status" => 200,
                "message" => "color found"


            ], 200);
        } else {
            return response()->json([
                "data" => $color,
                "status" => 402,
                "message" => "color not found"


            ], 402);
        }
    }
    public function province()
    {
        $province = Province::with('city')->get();
        if ($province->isNotEmpty()) {
            return response()->json([
                "data" => $province,
                "status" => 200,
                "message" => "province found"


            ], 200);
        } else {
            return response()->json([
                "data" => $province,
                "status" => 402,
                "message" => "province not found"


            ], 402);
        }
    }
    public function search(Request $request)
{
    $query = Post::with([
        'feature.mainfeature',
        'document',
        'location.province',
        'location.city',
        'contact',
        'dealer',
        'bodytype1',
        'make1'
    ])->where('status', 1)
    ->when($request->filled('bodytype'), fn($q) => $q->where('body_type', $request->bodytype))
    ->when($request->filled('model'), fn($q) => $q->where('model', $request->model))
    ->when($request->filled('budget'), function ($q) use ($request) {
        $budget = (array) $request->budget;
        if (isset($budget['from'], $budget['to'])) {
            $q->whereBetween('price', [(int)$budget['from'], (int)$budget['to']]);
        }
    })
    ->when($request->filled('year'), function ($q) use ($request) {
        $year = (array) $request->year;
        if (isset($year['from'], $year['to'])) {
            $q->whereBetween('year', [(int)$year['from'], (int)$year['to']]);
        }
    })
    ->when($request->filled('price'), function ($q) use ($request) {
        $price = (array) $request->price;
        if (isset($price['from'], $price['to'])) {
            $q->whereBetween('price', [(int)$price['from'], (int)$price['to']]);
        }
    })
    ->when($request->filled('make'), fn($q) => $q->where('make', $request->make));

    if ($request->filled('province')) {
        $provincePostIds = Location::where('province', $request->province)->pluck('post_id');
        $query->whereIn('id', $provincePostIds);
    }

    if ($request->filled('city')) {
        $cityPostIds = Location::where('city', $request->city)->pluck('post_id');
        $query->whereIn('id', $cityPostIds);
    }

    $posts = $query->get();

    $posts->each(function ($car) {
        $car->shareable_link = route('cardetail', ['id' => $car->id]);
    });

    $user = auth('sanctum')->user();
    if ($user) {
        foreach ($posts as $post) {
            $post->favorite = Whishlist::where('post_id', $post->id)
                ->where('status', 1)
                ->where('user_id', $user->id)
                ->exists() ? 1 : 0;

            $post->price_alert = PriceAlert::where('post_id', $post->id)
                ->where('status', 1)
                ->where('user_id', $user->id)
                ->exists() ? 1 : 0;
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
        "message" => $posts->isNotEmpty() ? "cars found" : "cars not found"
    ]);
}

    public function feature()
    {
        $feature = MainFeature::all();
        if ($feature->isNotEmpty()) {
            return response()->json([
                "data" => $feature,
                "status" => 200,
                "message" => "feature found"


            ], 200);
        } else {
            return response()->json([
                "data" => $feature,
                "status" => 402,
                "message" => "feature not found"


            ], 402);
        }
    }
}
