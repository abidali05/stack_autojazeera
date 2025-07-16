<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ApiPackageController extends Controller
{
    public function plan(Request $request)
    {
      $plan=SubscriptionPack::all();
      if($plan)
      {
        return response()->json([
           "data"=>$plan,
           "status"=>200,
           "message"=>"plan found"


        ],200);
      }
      else{
          return response()->json([
              "data"=>$plan,
              "status"=>402,
              "message"=>"plan not found"
 
 
           ],402);

      }
    }
}
