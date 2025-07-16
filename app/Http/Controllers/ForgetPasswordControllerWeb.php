<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Password_reset;

class ForgetPasswordControllerWeb extends Controller
{
    public function index(){
        return view('auth.forgot-password');
    }
    public function sendForgetOtp(Request $request)
    {
        $request->validate([
            'email'=>'required|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        if($user){
            if($user->status == 'active'){

            $otp = rand(10000, 99999);
            $user->otp = $otp;
            $user->save();
            //$data['user'] = $user;
            //$body = view('emails.password_reset_otp', $user);
            //sendMail($user->name, $user->email, 'Auto Jazera', 'Password Reset OTP', $body);
				Mail::to($user->email)->send(new Password_reset($user));
                return response()->json(['status' => 200, 'message' => "OTP sent to your email"]);
            }
            else{
                
                return response()->json(['status' => 402, 'message' => "Your Account is inactive, Contact Admin"]);
            }

        }
        else{
            return response()->json(['status' => 402, 'message' => "Invalid Email Address"]);
        }
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'email'=> 'required|exists:users,email',
            'otp'=>'required'
        ]); 

        $user = User::where('email', $request->email)->first();
        if($user->otp != null && $user->otp == $request->otp){
        $user->otp = null;
        $user->save();
        return response()->json(['status' => 200, 'message' => "OTP validated Successfully"]);
        }
        else{
        return response()->json(['status' => 402, 'message' => "Please use the OTP we sent to your registered email address"]);
        }
    }

    public function updatePassword(Request $request){
        $request->validate([
            'email'=> 'required|exists:users,email',
            'otp'=>'required',
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ]); 
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();
        return response()->json(['status' => 200, 'message' => "Password Updated Successfully"]);

    }
}
