<?php

namespace App\Http\Controllers\Api\Bike;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikeWishlist;
use App\Models\Bike\BikePriceAlert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class BikePriceAlertController extends Controller
{
    public function index()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        $alerts = BikePriceAlert::where('user_id', $user->id)->where('status', 1)->get();
        if ($alerts->isEmpty()) {
            return response()->json(['status' => 200, 'message' => "No price alerts found", 'data' => $alerts]);
        } else {
            $post_ids = $alerts->pluck('post_id')->filter()->unique()->toArray();
            $posts = BikePost::whereIn('id', $post_ids)->with(['features', 'location', 'contacts', 'media', 'dealer'])->get();
            foreach ($posts as $post) {
                $check = BikeWishlist::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
                $pricealertCheck = BikePriceAlert::where('post_id', $post->id)->where('status', 1)->where('user_id', $user->id)->where('status', 1)->first();
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
            return response()->json(['status' => 200, 'message' => count($posts) . ' price alerts found', 'data' => $posts]);
        }
    }


    public function addRemoveBikePriceAlert(Request $request)
    {

        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = auth('sanctum')->user();
        $check = BikePost::where('id', $request->post_id)->first();
        if (!$check) {
            return response()->json(['status' => 404, 'message' => "Post not found"]);
        }
        $checkIfExist = BikePriceAlert::where('post_id', $request->post_id)->where('user_id', $user->id)->first();

        if ($checkIfExist) {
            if ($checkIfExist->status == 1) {
                $checkIfExist->status = 0;
                $checkIfExist->save();
                return response()->json(['status' => 200, 'message' => "Price alert disabled"]);
            } else {
                $checkIfExist->status = 1;
                $checkIfExist->save();

                $dealer = User::where('id', $check->dealer_id)->first();

                $fcm_tokens = [$dealer->fcm_token];
                if ($fcm_tokens) {

                    SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Price Alert Lead', 'body' => 'New Price Alert Lead for ' . $check->makename . ' ' . $check->modelname]);



                    Notifications::create([
                        'user_id' => $dealer->id,
                        'title' => 'New Price Alert Lead',
                        'body' => 'New Price Alert Lead for ' . $check->makename . ' ' . $check->modelname,
                        'url' => url('leads/bikes'),
                    ]);
                }
                return response()->json(['status' => 200, 'message' => "Price alert enabled"]);
            }
        } else {
            BikePriceAlert::create([
                'post_id' => $request->post_id,
                'user_id' => $user->id,
                'status' => 1,
            ]);

            $post = BikePost::find($request->post_id);
            $dealer = User::where('id', $post->dealer_id)->first();

            $fcm_tokens = [$dealer->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Price Alert Lead', 'body' => 'New Price Alert Lead for ' . $post->makename . ' ' . $post->modelname]);



                Notifications::create([
                    'user_id' => $dealer->id,
                    'title' => 'New Price Alert Lead',
                    'body' => 'New Price Alert Lead for ' . $post->makename . ' ' . $post->modelname,
                    'url' => url('leads/bikes'),
                ]);
            }


            return response()->json(['status' => 200, 'message' => "Price alert enabled"]);
        }
    }


    public function clearpricealert(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        if ($request->post_id) {
            BikePriceAlert::where('user_id', $user->id)->where('post_id', $request->post_id)->delete();
        } else {
            BikePriceAlert::where('user_id', $user->id)->delete();
        }
        return response()->json(['status' => 200, 'message' => "Price alert cleared successfully"]);
    }
}
