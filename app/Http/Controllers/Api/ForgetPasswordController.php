<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        if($request->email && $request->otp  )
        {
            $resetData = PasswordResetToken::where('token', $request->otp)->first();
    
            if (isset($request->otp)) {
                if(isset($resetData->token))
                {
                    if($request->otp == $resetData->token)
                    {
                    
                    PasswordResetToken::where('email',$request->email)->delete();
                    return response()->json(['message' => "otp checked",'status'=>200],200);
             
                    }
                    else{
                        return response()->json(['message' => "invalid otp",'status'=>422],422);
                    }
                }
                else{
                    return response()->json(['message' => "invalid otp",'status'=>422],422);
                }
           
            
                // $user = User::where('email',$resetData->email)->first();
               
       
            } else {
                return response()->json(['status'=>406,'warning' => "Otp is required"],406);
            }
        }
        elseif($request->email && $request->password )
        {
            $user = User::where('email',$request->email)->first();
            
            $user->password = bcrypt($request->password);
    
            $user->save();
            return response()->json(['status'=>200,'message' => "password reset successfully"],200);
        }
        else{
            // $resetData = PasswordResetToken::where('email', $request->email)->first();
            // if($resetData){
            //     return response()->json(['status'=>406,'warning' => "Otp is required"],406);
            // }
        try {
            $user = User::where('email', $request->email)->get();
          
            if (count($user) > 0) {
              
                $token = Str::Random(40);
                $otp =random_int(100000, 999999);
           
                $domain = URL::to('/');
                // $url = $domain . '/reset-password?token=' . $token;
                // $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password reset';
                $data['otp'] = $otp;
               
               
                $data['body'] = 'Please verify your OTP to reset password';
                Mail::send('Api.forgetpasswordmail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                
                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordResetToken::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $otp,
                        // 'otp' => $otp,
                        'created_at' => $datetime,


                    ]

                );
               
                $taketoken=User::where('email',$request->email)->first();
                $taketoken->remember_token=$token;
             
         
                $taketoken->update();
              
                return response()->json(['status' => 200, 'message' => "Please check your email to reset your password"]);
            } else {
                return response()->json(['status' => 401, 'message' => "User not found"]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 401, 'message' => $e->getMessage()]);
        }
    }
    }
}
