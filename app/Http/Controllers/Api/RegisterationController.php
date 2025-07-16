<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use App\Models\UserPermission;
use App\Mail\LoginOtp;
use App\Mail\VerificationOtp;
use App\Mail\Welcome;

class RegisterationController extends Controller
{
    public function signup(Request $request)
    {
        try {
            $rules = [];
            $messages = [];

            // Check if provider is missing or invalid
            if ($request->missing('provider') || !in_array($request->input('provider'), ['email', 'phone', 'google'])) {
                $rules['provider'] = 'required|string|in:phone,email,google';
                $messages['provider.required'] = 'Please select a signup method. Either phone, email or google.';
                $messages['provider.in'] = 'Please select a valid signup method: phone, email or google.';
            }

            // If provider is "email", apply email rules
            if ($request->input('provider') === 'email') {
                $rules['identifier'] = 'required|email|max:255|unique:users,email';
                $rules['name'] = 'required|string|max:255';
                $rules['fcm_token'] = 'nullable|string';

                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['identifier.max'] = 'The email may not be greater than 255 characters.';
                $messages['identifier.unique'] = 'The email has already been taken.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'phone') {
                $request->merge(['identifier' => $request->prefix . $request->identifier]);
                $rules['identifier'] = 'required|string|regex:/^\+?\d{7,15}$/|unique:users,number';
                $rules['name'] = 'required|string|max:255';
                $rules['prefix'] = 'required|string';
                $rules['fcm_token'] = 'nullable|string';

                $messages['identifier.required'] = 'The phone number field is required.';
                $messages['identifier.string'] = 'The phone number must be a string.';
                $messages['identifier.regex'] = 'The phone number must be 7-15 digits long.';
                $messages['identifier.unique'] = 'The  phone number has already been taken.';
                $messages['prefix.required'] = 'The country code field is required.';
                $messages['prefix.string'] = 'The country code must be a string.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'google') {
                // Define the validation rules for Google provider
                $rules['identifier'] = 'required|email';
                $rules['name'] = 'required|string|max:255';
                $rules['is_email_verified'] = 'required|boolean';
                $rules['fcm_token'] = 'nullable|string';

                // Define custom error messages
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['name.required'] = 'The name field is required.';
                $messages['name.string'] = 'The name must be a string.';
                $messages['name.max'] = 'The name may not be greater than 255 characters.';
                $messages['is_email_verified.required'] = 'The email verification status is required.';
                $messages['is_email_verified.boolean'] = 'The email verification status must be true or false.';
                $messages['fcm_token.string'] = 'The fcm token must be a string.';
            }


            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'An error occurred while signing in. Please try again later.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }

            // Get the validated data
            $data = $request->only(['provider', 'identifier']);

            // Find the user by email or phone number
            $user = User::where('email', $data['identifier'])
                ->orWhere('number', $data['identifier'])
                ->first();
            // Create new user for google
            if ($request->input('provider') === 'google') {
                User::upsert(
                    [
                        [

                            'name' => $request->name,
                            'email' => $request->identifier,
                            'fcm_token' => $request->fcm_token,
                            'password' => Hash::make('password'),
                            'is_email_verified' => $request->is_email_verified ?? false,
                        ]
                    ],
                    ['email'], // Unique column
                    ['name', 'fcm_token', 'is_email_verified'] // Columns to update
                );

                $user = User::where('email', $request->identifier)->first();

                if ($user->status !== 'active') {
                    return response()->json([
                        'message' => 'Your account is inactive. Please contact support.',
                        'errors' =>  $validator->errors()->all(),
                        'status' => 422
                    ], 422);
                }
                $token = $user->createToken('auth:sanctum')->plainTextToken;
                $user->free_package_availed = (int)$user->free_package_availed;

                if (!$token) {
                    return response()->json([
                        'message' => 'Invalid user credentials.',
                        'errors' =>  $validator->errors()->all(),
                        // 'data' => $user,
                        'status' => 401
                    ], 401);
                }

				//Mail::to($request->identifier)->send(new Welcome());
				
                return response()->json([
                    "data" => $user,
                    "token" => $token,
                    "message" => 'login successfully',
                    'status' => 200
                ], 200);
            }





            if ($request->input('provider') === 'email') {
                $user = new User();
                $user->name = $request->name;
                $user->email = $data['identifier'];
                $user->fcm_token = $request->fcm_token;
                $user->password = Hash::make('password');
                $user->save();

                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                //$body = view('emails.login_otp', compact('otp'));
                // if (sendMail($user->name, $user->email, 'Auto Jazera', $otp . ' is your secure sign in code', $body)) {
                //     return response()->json([
                //         "message" => 'OTP sent to your email',
                //         'status' => 200
                //     ], 200);
                // }
                try {
                    Mail::to($request->identifier)->send(new LoginOtp($otp));

                    return response()->json([
                        "message" => 'OTP sent to your email',
                        'status' => 200
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        "message" => 'Failed to send OTP',
                        'status' => 500,
                        'error' => $e->getMessage()
                    ], 500);
                }
				
				Mail::to($request->identifier)->send(new Welcome());
            }

            if ($request->input('provider') === 'phone') {
                $user = new User();
                $user->name = $request->name;
                $user->number = $data['identifier'];
                $user->fcm_token = $request->fcm_token;
                $user->password = Hash::make('password');
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();

                $otp_instance = new ApiNumbereController();
                $response = $otp_instance->send_number_otp($user->number, $otp);
				// Mail::to($request->identifier)->send(new Welcome());
                return $response;
            }

            return response()->json([
                'message' => 'An error occurred while signing in. Please try again laterrr.',
                // 'data' => $user,
                'status' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                'errors' => $e->getMessage(),
                // 'data' => $user,
                'status' => 500
            ], 500);
        }
    }

    public function signin(Request $request)
    {
        //dd($request->all());
        try {
            $rules = [];
            $messages = [];

            // Check if provider is missing or invalid
            if ($request->missing('provider') || !in_array($request->input('provider'), ['email', 'phone', 'google'])) {
                $rules['provider'] = 'required|string|in:phone,email,google';
                $messages['provider.required'] = 'Please select a signin method. Either phone, email or google.';
                $messages['provider.in'] = 'Please select a valid signin method: phone, email or google.';
            }

            // If provider is "email", apply email rules
            if ($request->input('provider') === 'email') {
                $rules['identifier'] = 'required|email|exists:users,email';
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['identifier.exists'] = 'Account not found . Please sign up first.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'phone') {
                $request->merge(['identifier' => $request->prefix . $request->identifier]);
                $rules['identifier'] = 'required|string|regex:/^\+?\d{7,15}$/|exists:users,number';
                $rules['prefix'] = 'required|string';

                $messages['identifier.required'] = 'The phone number field is required.';
                $messages['identifier.string'] = 'The phone number must be a string.';
                $messages['identifier.regex'] = 'The phone number must be 7-15 digits long.';
                $messages['identifier.exists'] = 'Account not found . Please sign up first';
                $messages['prefix.required'] = 'The country code field is required.';
                $messages['prefix.string'] = 'The country code must be a string.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'google') {
                // Define the validation rules for Google provider
                $rules['identifier'] = 'required|email|exists:users,email';
                $rules['name'] = 'required|string|max:255';
                $rules['is_email_verified'] = 'required|boolean';
                $rules['fcm_token'] = 'nullable|string';

                // Define custom error messages
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['name.required'] = 'The name field is required.';
                $messages['name.string'] = 'The name must be a string.';
                $messages['name.max'] = 'The name may not be greater than 255 characters.';
                $messages['is_email_verified.required'] = 'The email verification status is required.';
                $messages['is_email_verified.boolean'] = 'The email verification status must be true or false.';
                $messages['fcm_token.string'] = 'The fcm token must be a string.';
            }


            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'An error occurred while signing in. Please try again later.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }

            // Get the validated data
            $data = $request->only(['provider', 'identifier']);

            // Find the user by email or phone number
            $user = User::where('email', $data['identifier'])
                ->orWhere('number', $data['identifier'])
                ->first();
            // Create new user for google
            if ($request->input('provider') === 'google') {
                User::upsert(
                    [
                        [

                            'name' => $request->name,
                            'email' => $request->identifier,
                            'fcm_token' => $request->fcm_token,
                            'password' => Hash::make('password'),
                            'is_email_verified' => $request->is_email_verified ?? false,
                        ]
                    ],
                    ['email'], // Unique column
                    ['name', 'fcm_token', 'is_email_verified'] // Columns to update
                );

                $user = User::where('email', $request->identifier)->first();
                if ($user->status !== 'active') {
                    return response()->json([
                        'message' => 'Your account is not active. Please contact support.',
                        'status' => 422
                    ], 422);
                }

                $token = $user->createToken('auth:sanctum')->plainTextToken;
                $user->free_package_availed = (int)$user->free_package_availed;

                if (!$token) {
                    return response()->json([
                        'message' => 'Invalid user credentials.',
                        'errors' =>  $validator->errors()->all(),
                        // 'data' => $user,
                        'status' => 401
                    ], 401);
                }


                return response()->json([
                    "data" => $user,
                    "token" => $token,
                    "message" => 'login successfully',
                    'status' => 200
                ], 200);
            }



            if ($request->input('provider') === 'email') {
                $user = User::where('email', $data['identifier'])->first();
                if ($user->status !== 'active') {
                    return response()->json([
                        'message' => 'Your account is not active. Please contact support.',
                        'status' => 422
                    ], 422);
                }

                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                //$body = view('emails.login_otp', compact('otp'));
                //if(sendMail($user->name, $user->email, 'Auto Jazera', $otp.' is your secure sign in code', $body)) {
                // 	return response()->json([
                // 		"message" => 'OTP sent to your email',
                // 		'status' => 200
                // 	], 200);
                // }
                try {
                    Mail::to($request->identifier)->send(new LoginOtp($otp));

                    return response()->json([
                        "message" => 'OTP sent to your email',
                        'status' => 200
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        "message" => 'Failed to send OTP',
                        'status' => 500,
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            if ($request->input('provider') === 'phone') {

                $user = User::where('number',  $request->identifier)->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                        'status' => 422
                    ], 422);
                }
                if ($user->status !== 'active') {
                    return response()->json([
                        'message' => 'Your account is not active. Please contact support.',
                        'status' => 422
                    ], 422);
                }
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                $otp_instance = new ApiNumbereController();
                $response = $otp_instance->send_number_otp($request->identifier, $otp);

                return $response;
            }

            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function send_otp(Request $request)
    {
        try {
            $rules = [];
            $messages = [];

            // Check if provider is missing or invalid
            if ($request->missing('provider') || !in_array($request->input('provider'), ['email', 'phone'])) {
                $rules['provider'] = 'required|string|in:phone,email';
                $messages['provider.required'] = 'Please select a signin method. Either phone or email.';
                $messages['provider.in'] = 'Please select a valid signin method: phone or email.';
            }

            // If provider is "email", apply email rules
            if ($request->input('provider') === 'email') {
                $rules['identifier'] = 'required|email|exists:users,email';
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['identifier.exists'] = 'The email does not exist in our records.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'phone') {
                $request->merge(['identifier' => $request->prefix . $request->identifier]);
                $rules['identifier'] = 'required|string|regex:/^\+?\d{7,15}$/|exists:users,number';
                $rules['prefix'] = 'required|string';

                $messages['identifier.required'] = 'The phone number field is required.';
                $messages['identifier.exists'] = 'The phone number does not exist in our records.';
                $messages['identifier.string'] = 'The phone number must be a string.';
                $messages['identifier.regex'] = 'The phone number must be 7-15 digits long.';
                $messages['prefix.required'] = 'The country code field is required.';
                $messages['prefix.string'] = 'The country code must be a string.';
            }





            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'An error occurred while signing in. Please try again later.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }

            // Get the validated data
            $data = $request->only(['provider', 'identifier']);

            // Find the user by email or phone number
            $user = User::where('email', $data['identifier'])
                ->orWhere('number', $data['identifier'])
                ->first();
            // Create new user for google


            if (!$user) {
                return response()->json([
                    'message' => 'Invalid user credentials.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 401
                ], 401);
            }



            if ($request->input('provider') === 'email') {
                $user = User::where('email', $data['identifier'])->where('status', 'active')->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                        'status' => 422
                    ], 422);
                }
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                try {
                    Mail::to($request->identifier)->send(new VerificationOtp($otp));

                    return response()->json([
                        "message" => 'OTP sent to your email',
                        'status' => 200
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        "message" => 'Email not sent, please try again later.',
                        'status' => 500,
                        'error' => $e->getMessage()
                    ], 500);
                }
                //$body = view('emails.verification_otp', compact('otp'));
                // if (sendMail($user->name, $user->email, 'Auto Jazera', $otp . ' is your verification code', $body)) {
                //     return response()->json([
                //         "message" => 'OTP sent to your email',
                //         'status' => 200
                //     ], 200);
                // }
            }

            if ($request->input('provider') === 'phone') {
                $user = User::where('number', $data['identifier'])->where('status', 'active')->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                        'status' => 422
                    ], 422);
                }
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();

                $otp_instance = new ApiNumbereController();
                $response = $otp_instance->send_number_otp($user->number, $otp);

                return $response;
            }

            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verify_otp(Request $request)
    {
        try {
            $rules = [];
            $messages = [];

            // Check if provider is missing or invalid
            if ($request->missing('provider') || !in_array($request->input('provider'), ['email', 'phone'])) {
                $rules['provider'] = 'required|string|in:phone,email';
                $messages['provider.required'] = 'Please select a signin method. Either phone or email.';
                $messages['provider.in'] = 'Please select a valid signin method: phone or email.';
            }

            // If provider is "email", apply email rules
            if ($request->input('provider') === 'email') {
                $rules['identifier'] = 'required|email|exists:users,email';
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['identifier.exists'] = 'The email does not exist in our records.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'phone') {
                $request->merge(['identifier' => $request->prefix . $request->identifier]);
                $rules['identifier'] = 'required|string|regex:/^\+?\d{7,15}$/|exists:users,number';
                $rules['prefix'] = 'required|string';

                $messages['identifier.required'] = 'The phone number field is required.';
                $messages['identifier.exists'] = 'The phone number does not exist in our records.';
                $messages['identifier.string'] = 'The phone number must be a string.';
                $messages['identifier.regex'] = 'The phone number must be 7-15 digits long.';
                $messages['prefix.required'] = 'The country code field is required.';
                $messages['prefix.string'] = 'The country code must be a string.';
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'An error occurred while signing in. Please try again later.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }

            // Get the validated data
            $data = $request->only(['provider', 'identifier']);

            // Find the user by email or phone number
            $user = User::where('email', $data['identifier'])
                ->orWhere('number', $data['identifier'])
                ->first();



            if (!$user) {
                return response()->json([
                    'message' => 'Invalid user credentials.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }
            if ($user->status !== 'active') {
                return response()->json([
                    'message' => 'Your account is inactive. Please contact support.',
                    'status' => 422
                ], 422);
            }



            if ($request->input('provider') === 'email') {
                if ($user->otp == $request->input('otp')) {
                    $user->otp = null;
                    $user->is_email_verified = 1;
                    $user->save();

                    $token = $user->createToken('auth:sanctum')->plainTextToken;
                    return response()->json([
                        'message' => 'Login successful',
                        'token' => $token,
                        'user' => $user,
                        'status' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Invalid OTP',
                        'status' => 422
                    ], 422);
                }
            }

            if ($request->input('provider') === 'phone') {
                if ($user->otp == $request->input('otp')) {
                    $user->otp = null;
                    $user->is_number_verified = 1;
                    $user->save();

                    $token = $user->createToken('auth:sanctum')->plainTextToken;
                    return response()->json([
                        'message' => 'Login successful',
                        'token' => $token,
                        'user' => $user,
                        'status' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Invalid OTP',
                        'status' => 422
                    ], 422);
                }
            }

            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {

        $request->merge(['number' => "+92" . $request->number]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'number' => [
                'required',
                'string',
                'unique:users', // Ensures no duplicate phone numbers
                'regex:/[0-9]{10}/' // Validates only the 10-digit local number part
            ],


            // 'password' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['name']);
        $input['status'] = 'active';
        $input['number'] = $request->number;
        $user = User::create($input);
        //$body = view('emails.welcome');
        //sendMail($user->name, $user->email, 'Auto Jazeera', 'Welcome To Auto Jazeera', $body);
       // try {
            Mail::to($user->email)->send(new Welcome());

         //   return response()->json([
           //     "message" => 'OTP sent to your email',
             //   'status' => 200
           // ], 200);
        //} catch (\Exception $e) {
        //    return response()->json([
          //      "message" => 'Email not sent, please try again later.',
            //    'status' => 500,
              //  'error' => $e->getMessage()
           // ], 500);
      //  }
        // $token = $user->createToken('auth:sanctum')->plainTextToken;
        // $otp = random_int(100000, 999999);
        // $data['url'] = $url;
        // $data['email'] = $request->email;
        // $data['title'] = 'Register Account';
        // $data['otp'] = $otp;



        // $data['body'] = 'Otp to register your account';
        // Mail::send('Api.register_account', ['data' => $data], function ($message) use ($data) {
        //     $message->to($data['email'])->subject($data['title']);
        // });
        // $success['name'] =  $user->name;

        return response()->json([
            'message' => 'Registered Successfully',
            // 'data' => $user,
            'status' => 200

        ], 200);
        // return response()->json(['status' => 200, 'message' => 'Item removed Successfully']);
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email|max:255|exists:users,email',

            // 'password' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $otp = rand(100000, 999999);
        $user = User::where(['email' => $request->email, 'status' => 'active'])->first();
        if ($user) {
            $user->otp = $otp;
            $user->save();
            //$body = view('emails.login_otp', compact('otp'));
            //    if(sendMail($user->name, $user->email, 'Auto Jazera', $otp.' is your secure sign in code', $body)){

            //     return response()->json([
            //         "message" => 'OTP sent to your email',
            //         'status' => 200
            //     ], 200);
            // }else{
            //     return response()->json([
            //         "message" => 'Email not sent, please try again later', 
            //         'status' => 422
            //     ], 422);
            // }
            try {
                Mail::to($request->identifier)->send(new LoginOtp($otp));

                return response()->json([
                    "message" => 'OTP sent to your email',
                    'status' => 200
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => 'Email not sent, please try again later.',
                    'status' => 500,
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {

            return response()->json([
                "message" => 'Account is not active, please contact support',
                'status' => 422
            ], 422);
        }
        // if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
        //     $user = auth()->user();
        //     if ($user->status == 'active') {
        //         $token = $user->createToken('auth:sanctum')->plainTextToken;
        //         // $url = URL::to('/active-account/'.$request->email);
        //         $user->free_package_availed = (int)$user->free_package_availed;
        //         // $userToken = $user->createToken()->accessToken;
        //         return response()->json([
        //             "data" => $user,
        //             "token" => $token,
        //             "message" => 'login successfully',
        //             // 'access_token' => $userToken
        //             'status' => 200
        //         ], 200);
        //     } else {
        //         return response()->json([

        //             "message" => 'your account is not active',
        //             'status' => 422
        //         ], 422);
        //     }
        // } else {
        //     return response()->json([

        //         "message" => 'invalid credentials',
        //         'status' => 422
        //     ], 422);
        // }
    }

    public function verifyLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email|max:255|exists:users,email',
            'otp' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where(['email' => $request->email, 'otp' => $request->otp])->first();
        if ($user) {


            $user->otp = null;
            $user->save();

            $token = $user->createToken('auth:sanctum')->plainTextToken;
            $user->free_package_availed = (int)$user->free_package_availed;
            return response()->json([
                "data" => $user,
                "token" => $token,
                "message" => 'login successfully',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                "message" => 'invalid otp',
                'status' => 422
            ], 422);
        }
    }
    public function social_login(Request $request)
    {

        // $sociallogin=Sociallogin::where('email',$request->email)->first();
        if ($request->email) {
            $sociallogin = User::where(['email' => $request->email])->first();

            if (!$sociallogin) {
                $validator = Validator::make($request->all(), [

                    'email' => 'required|string|email|max:255|unique:users',

                ]);
                if ($validator->fails()) {
                    return response(['errors' => $validator->errors()->all()], 422);
                }

                $user = new User();
                $user->name = $request->name;

                $user->email = $request->email;
                $user->role = 0;
                $user->google_id = 'social';

                $user->status = 'active';
                $user->password = Hash::make("password");


                $user->save();
                //$body = view('emails.welcome');
                //sendMail($user->name, $user->email, 'Auto Jazeera', 'Welcome To Auto Jazeera', $body);
                
               // try {
                    Mail::to($user->email)->send(new Welcome());
        
                //    return response()->json([
                       // "message" => 'OTP sent to your email',
                //        'status' => 200
                 //   ], 200);
            //    } catch (\Exception $e) {
              //      return response()->json([
                //        "message" => 'Email not sent, please try again later.',
                  //      'status' => 500,
                    //    'error' => $e->getMessage()
            //        ], 500);
             //   }
                // Auth::login($user);
                $token = $user->createToken('auth:sanctum')->plainTextToken;
                $u = User::where(['email' => $request->email])->first();
                return response()->json([
                    'status' => 200,

                    'user' => $u,
                    'message' => 'User login Successfully',
                    'token' => $token,
                    'status' => 200
                ], 200);
            } else {
                if (auth()->attempt(['email' => $request->input('email'), 'password' => "password"])) {
                    // Auth::login($sociallogin);
                    $token = $sociallogin->createToken('auth:sanctum')->plainTextToken;
                    $sociallogin->free_package_availed = (int)$sociallogin->free_package_availed;
                    return  response()->json([

                        'user' => $sociallogin,
                        'message' => 'User login successfully.',
                        'token' => $token,
                        'status' => 200
                    ], 200);
                } else {
                    return  response()->json([


                        'message' => "please login with email",

                        'status' => 401
                    ], 401);
                }
            }
        }
        if ($request->number) {

            $sociallogin = User::where(['number' => $request->number])->first();

            if (!$sociallogin) {

                $validator = Validator::make($request->all(), [

                    'number' => 'required|unique:users',

                ]);
                if ($validator->fails()) {
                    return response(['errors' => $validator->errors()->all()], 422);
                }
                $phoneNumber = $request->input('number');

                $user = User::create([
                    'number' => $phoneNumber,
                    'name' => 'user' . rand(),
                    'password' => bcrypt('Pa$$word'),
                ]);

                // event(new Registered($user));
                $token = $user->createToken('auth:sanctum')->plainTextToken;

                return  response()->json([

                    'user' => $user,
                    'message' => 'User login successfully.',
                    'token' => $token,
                    'status' => 200
                ], 200);
            } else {

                $token = $sociallogin->createToken('auth:sanctum')->plainTextToken;
                return  response()->json([

                    'user' => $sociallogin,
                    'message' => "ser login successfully.",
                    'token' => $token,
                    'status' => 200
                ], 200);
            }
        }
    }
    // public function active_email(Request $request)
    // {

    //     $user = User::find($request->id);
    //     if ($user) {
    //         $user->status = 1;
    //         $user->update();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Email verified Successfully',

    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status' => 200,

    //             'user' => $user,
    //             'message' => 'User not found',

    //         ], 202);
    //     }
    // }

    public function logout(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        try {
            $user = auth('sanctum')->user();

            if (!$user) {
                return response()->json([
                    'status' => 422,
                    'message' => "You are not authorized to access this route"
                ]);
            }
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => "Successfully logged out",
                'status' => 200,
                'data' => []
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
                'data' => []
            ], 500);
        }
    }

    public function savePayment(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $validator = Validator::make($request->all(), [
            'package_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = auth('sanctum')->user();
        $user->package = $request->package_id;
        $user->save();
        $token = request()->bearerToken();
        return response()->json([
            "data" => $user,
            "token" => $token,
            "message" => 'Plan saved succesfully',
            'status' => 200
        ], 200);
    }

    public function update_login_profile(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'number' => 'nullable|string|max:255|unique:users,number,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('number')) {
            $user->number = $request->number;
        }

        $user->save();

        return response()->json([
            "data" => $user,
            "message" => 'Information updated successfully',
            'status' => 200,
            'token' => null
        ], 200);
    }

    // verification after login 

    public function verification(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        try {
            $rules = [];
            $messages = [];

            // Check if provider is missing or invalid
            if ($request->missing('provider') || !in_array($request->input('provider'), ['email', 'phone'])) {
                $rules['provider'] = 'required|string|in:phone,email';
                $messages['provider.required'] = 'Please select a signin method. Either phone or email.';
                $messages['provider.in'] = 'Please select a valid signin method: phone or email.';
            }

            // If provider is "email", apply email rules
            if ($request->input('provider') === 'email') {
                $rules['identifier'] = 'required|email|unique:users,email,' . $user->id;
                $messages['identifier.required'] = 'The email field is required.';
                $messages['identifier.email'] = 'The email must be a valid email address.';
                $messages['identifier.exists'] = 'The email does not exist in our records.';
                $messages['identifier.unique'] = 'The email has already been taken.';
            }

            // If provider is "phone", apply phone rules
            elseif ($request->input('provider') === 'phone') {
                $request->merge(['identifier' => $request->prefix . $request->identifier]);
                $rules['identifier'] = 'required|string|regex:/^\+?\d{7,15}$/|unique:users,number,' . $user->id;
                $rules['prefix'] = 'required|string';

                $messages['identifier.required'] = 'The phone number field is required.';
                $messages['identifier.exists'] = 'The phone number does not exist in our records.';
                $messages['identifier.string'] = 'The phone number must be a string.';
                $messages['identifier.regex'] = 'The phone number must be 7-15 digits long.';
                $messages['prefix.required'] = 'The country code field is required.';
                $messages['prefix.string'] = 'The country code must be a string.';
                $messages['identifier.unique'] = 'The phone number has already been taken.';
            }





            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'An error occurred while signing in. Please try again later.',
                    'errors' =>  $validator->errors()->all(),
                    // 'data' => $user,
                    'status' => 422
                ], 422);
            }
            if ($request->input('provider') === 'email') {
                $user->email = $request->identifier;
                $user->save();
            } else {
                $user->number = $request->identifier;
                $user->save();
            }

            // Get the validated data
            $data = $request->only(['provider', 'identifier']);

            // Find the user by email or phone number
            $user = User::where('email', $data['identifier'])
                ->orWhere('number', $data['identifier'])
                ->first();
            // Create new user for google






            if ($request->input('provider') === 'email') {
                $user = User::where('email', $data['identifier'])->where('status', 'active')->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                        'status' => 422
                    ], 422);
                }
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                try {
                    Mail::to($request->identifier)->send(new VerificationOtp($otp));

                    return response()->json([
                        "message" => 'OTP sent to your email',
                        'status' => 200
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        "message" => 'Email not sent, please try again later.',
                        'status' => 500,
                        'error' => $e->getMessage()
                    ], 500);
                }
                //$body = view('emails.verification_otp', compact('otp'));
                // if (sendMail($user->name, $user->email, 'Auto Jazera', $otp . ' is your verification code', $body)) {
                //     return response()->json([
                //         "message" => 'OTP sent to your email',
                //         'status' => 200
                //     ], 200);
                // }

            }

            if ($request->input('provider') === 'phone') {
                $user = User::where('number', $data['identifier'])->where('status', 'active')->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                        'status' => 422
                    ], 422);
                }
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->save();

                $otp_instance = new ApiNumbereController();
                $response = $otp_instance->send_number_otp($user->number, $otp);

                return $response;
            }

            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while signing in. Please try again later.',
                // 'data' => $user,
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
