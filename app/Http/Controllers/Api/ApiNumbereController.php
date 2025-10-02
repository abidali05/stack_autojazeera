<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use GPBMetadata\Google\Rpc\Status;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class ApiNumbereController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function requestOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $phoneNumber = $request->input('number');
        $user = User::where('number', $phoneNumber)->first();
        if (!$user) {
            return response()->json([
                'message' => 'No user found with this number, please register first.',
                'status' => 401
            ], 401);
            exit;
        }
        if ($user->status == 'inactive') {
            return response()->json([
                'message' => 'Your account is not active, please contact to admin.',
                'status' => 401
            ], 401);
            exit;
        }


        $otp = mt_rand(100000, 999999);

        $d = Otp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp' => $otp, 'created_at' => now()]
        );

        try {
            // Send OTP via SMS
            //    $data = $this->twilio->messages->create($phoneNumber, [
            //      'from' => '+13655361575',
            //    'body' => "Your OTP For login to AutoJazeera is: $otp"
            //  ]);

            return  response()->json([
                'otp' => $otp,
                'message' => 'OTP Send successfully.',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Failed to send OTP.', 'status' => 500], 500);
            // $hardcodedOtp = env('FALLBACK_OTP', 123456);

            // Otp::updateOrCreate(
            //     ['phone_number' => $phoneNumber],
            //     ['otp' => $hardcodedOtp, 'created_at' => now()]
            // );

            return response()->json([
                // 'otp' => $hardcodedOtp,
                'message' => 'Something went wrong! ',
                'status' => 200
            ], 200);
        }
    }

    public function verifyOTP(Request $request)
    {

        $request->validate([
            'number' => 'required|string',
            'otp' => 'required|string',
        ]);

        $phoneNumber = $request->input('number');
        $otp = $request->input('otp');
        $record = Otp::where('phone_number', $phoneNumber)->first();
        $user = User::where('number', $phoneNumber)->first();
        if ($record && $record->otp === $otp) {

            if (!$user) {
                return response()->json([
                    'data' => null,
                    'message' => 'No user found with this number, please register first.',
                    'status' => 401
                ], 401);
                exit;
            } else {
                $credentials = $request->only('number');

                if (Auth::login($user)) {

                    $token = $user->createToken('auth:sanctum')->plainTextToken;
                    $user->free_package_availed = (int)$user->free_package_availed;
                    return response()->json([
                        "data" => $user,
                        "token" => $token,
                        "message" => 'login successfully',
                        'status' => 200
                    ], 200);
                }
            }


            Auth::login($user);

            $token = $user->createToken('auth:sanctum')->plainTextToken;
            $user->free_package_availed = (int)$user->free_package_availed;
            return response()->json([
                "data" => $user,
                "token" => $token,
                "message" => 'login successfully',
                'status' => 200
            ], 200);
            // return response()->json(['message' => 'OTP verified successfully!'], 200);
        }
        return response()->json([
            "message" => 'invalid otp',
            'status' => 422
        ], 422);
    }

    public function send_number_otp($number, $otp)
    {



        try {
            // Send OTP via SMS
            //   $data = $this->twilio->messages->create($number, [
            //     'from' => '+13655361575',
            //    'body' => "Your OTP for login to AutoJazeera is: $otp"
            //  ]);


            return  response()->json([
                'otp' => $otp,
                'message' => 'OTP Send successfully.',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP.', 'status' => 500], 500);
        }
    }
}
