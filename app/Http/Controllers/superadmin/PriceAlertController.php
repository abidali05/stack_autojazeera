<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Post;
use App\Models\PriceAlert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bike\BikePost;
use App\Models\Bike\BikePriceAlert;
use Illuminate\Support\Facades\Auth;

class PriceAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceAlerts = PriceAlert::with('post', 'user')->where('user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(25);
        return view('user.priceAlert.index', compact('priceAlerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


   public function get_price_alerts()
{
    $user = Auth::user();

    if ($user->role == 1) {
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

        return view('user.priceAlert.dealer_cars_price_alert', compact('car_price_alerts', 'bike_price_alerts'));
    }

    return redirect()->back()->with('error', 'You are not authorized to view this page.');
}

}
