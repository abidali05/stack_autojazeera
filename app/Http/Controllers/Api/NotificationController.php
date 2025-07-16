<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function store_fcm_token(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 401, 'message' => "You are not authorized to access this route"], 401);
        }
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required'
            ]);
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }
        $user = auth('sanctum')->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        return response()->json(['status' => 200, 'message' => "Token saved successfully"],200);
    }



    public function newsLetter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
            ]);
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }
        // Check if the email already exists in the database
        $check = Subscription::where('email', $request->email)->first();
    
        if (!$check) {
            // Create a new subscription
            $subscribe = new Subscription();
            $subscribe->email = $request->email;
            $subscribe->save();
    
            // Return a JSON response for successful subscription
            return response()->json(['status' => 200, 'message' => "Subscribed successfully!"],200);

        } else {
            return response()->json(['status' => 200, 'message' => "Already subscribed!"],200);
        }
    }
}
