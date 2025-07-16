<?php

namespace App\Http\Controllers\Bikes\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikePriceAlert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BikePricealertController extends Controller
{
    public function add_price_alert($postid){
        $alert = BikePriceAlert::where('post_id', $postid)->where('user_id', Auth::id())->first();
        if (!$alert) {
            $alert = new BikePriceAlert();
            $alert->post_id = $postid;
            $alert->user_id = Auth::id();
            $alert->status = 1;
            $alert->save();

            $post = BikePost::find($postid);

            $dealer = User::find($post->dealer_id);

            if ($dealer && $dealer->fcm_token) {
                $fcm_tokens = [$dealer->fcm_token];
                if ($fcm_tokens) {

                    SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert Lead', 'body' => 'New Price Alert Lead for ' . $post->makename . ' ' . $post->modelname]);



                    Notifications::create([
                        'user_id' => $dealer->id,
                        'title' => 'Price Alert Lead',
                        'body' => 'New Price Alert Lead for ' . $post->makename . ' ' . $post->modelname,
                        'url' => url('get-price-alerts'),
                    ]);
                }
            }
            return redirect()->back()->with('pricealertresponse', 'Price Alert Added');
        } else {
            $alert->delete();
            return redirect()->back()->with('pricealertresponse', 'Price Alert Removed');
        }
    }

    public function index(){
        $priceAlerts = BikePriceAlert::where('user_id', Auth::id())->get();
        return view('bikes.user.pricealerts.index', compact('priceAlerts'));
    }
}
