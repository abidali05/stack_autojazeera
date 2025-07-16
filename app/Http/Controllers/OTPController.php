<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

class OTPController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        $accountSid = 'ACf7b88a5f46cf4a5f8215d0018c55f355';
        $authToken = '342711440a4f95845b398ebad6f9f7a1';

        // Validate the credentials
        if (!$accountSid || !$authToken) {
            return redirect()->route('number_login')->with('error', 'Twilio credentials are missing');
            // throw new \Exception('Twilio credentials are missing. Please check the .env file.');
        }

        try {
            // Initialize the Twilio Client
            $this->twilio = new Client($accountSid, $authToken);
        } catch (\Exception $e) {
            // throw new \Exception('Failed to initialize Twilio Client: ' . $e->getMessage());
            return redirect()->route('number_login')->with('error', 'Twilio credentials are missing');
        }
    }

    public function requestOTP(Request $request)
    {
        // Validate phone number
        $request->validate([
            'phoneNumber' => 'required|numeric',
        ]);

        $phoneNumber = $request->input('phoneNumber');
        $user = User::where('number', $phoneNumber)->first();
		
        if (!$user) {
			$user = User::create([
				'name' => 'test',
				'password' => '12345678',
            'number' => $phoneNumber,
            'status' => 'active', // Set default status
        ]);
			//dd('e');
           // return redirect()->route('number_login')->with('error', 'No user found with this number, please register first');
           // exit;
        }
        if($user->status == 'inactive'){
            return redirect()->route('number_login')->with('error', 'Your account is not active, please contact to admin');
            exit;
        }
        // Generate a 6-digit OTP
        $otp = mt_rand(100000, 999999);

        // Save OTP with expiration time (e.g., 10 minutes)
        $d = Otp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp' => $otp, 'created_at' => now()]
        );
        // dd($d);
        try {
            // Send OTP via SMS
            $data = $this->twilio->messages->create($phoneNumber, [
                'from' => '+13655361575',
                'body' => "Your OTP For login to AutoJazeera is : $otp"
            ]);
            // dd($data);
            return view('auth.number_login', compact('phoneNumber'))->with('success', 'OTP sent successfully');
        } catch (\Exception $e) {
            // dd($e);
            // \Log::error('Twilio Error: ' . $e->getMessage());
            // return response()->json(['error' => 'Failed to send OTP.'], 500);
            return redirect()->route('number_login')->with('error', 'Twilio credentials are missing');
        }
    }

    public function verifyOTP(Request $request)
    {
        // Validate phone number and OTP
        $request->validate([
            // 'phoneNumber' =>'required|string|unique:users,number',
            'phoneNumber' => 'required|string',
            'otp' => 'required|string',
        ]);

        $phoneNumber = $request->input('phoneNumber');
        $otp = $request->input('otp');

        // Retrieve OTP record
        $record = Otp::where('phone_number', $phoneNumber)->first();
        $user = User::where('number', $phoneNumber)->first();

        // Check if OTP exists, matches, and is not expired (within 10 minutes)
        // if ($record && $record->otp === $otp && $record->created_at->gt(Carbon::now()->subMinutes(10))) {
        if ($record && $record->otp === $otp) {
            //  $record->delete(); // Remove OTP after successful verification
            if (!$user) {
                return redirect()->route('number_login')->with('error', 'No user found with this number, please register first');
                exit;
            }
            // $user = User::create([
            //     'number' => $phoneNumber,
            //   'name'=>'user'.rand(),
            //     'password' => bcrypt('Pa$$word'),
            // ]);
            // event(new Registered($user));



            // $credentials = $request->only('number');

            // if (Auth::attempt($credentials)) {
            //     return redirect()->intended('/dashboard');
            // }


			if (!$user->email || !$user->is_email_verified) {
            return redirect()->route('emailNumber.verification', ['user_id' => $user->id]);
        } else {
				$user->is_email_verified = true;
				$user->save();
			}

            Auth::login($user);
            return redirect('/dashboard');
            // return response()->json(['message' => 'OTP verified successfully!'], 200);
        }
        return redirect()->route('number_login')->with('error', 'Invalid or expired OTP.');

        // return response()->json(['error' => 'Invalid or expired OTP.'], 400);
    }
	
	public function sendOtpNumber(Request $request)
    {
		
        // Validate phone number and OTP
        $request->validate([
            'user_id' => 'required|exists:users,id',
			 'phoneNumber' => 'required|string|unique:users,number',
            //'phoneNumber' => 'required|string|min:13|max:13|regex:/^\+?[0-9]{13}$/',
        ]);
		//dd($request->all());
        $user = User::findOrFail($request->user_id);
        $phoneNumber = $request->phoneNumber;

        // Save/Update Phone Number
        $user->number = $phoneNumber;
        $user->is_number_verified = 0; // Reset verification status
        $user->save();

        // Generate OTP
        $otp = mt_rand(100000, 999999);
        Otp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp' => $otp, 'created_at' => now()]
        );

        // Send OTP (Replace with your SMS API logic)
        try {
            // Fake SMS sending for now
            // $this->sendSms($phoneNumber, "Your OTP is: $otp");
			$data = $this->twilio->messages->create($phoneNumber, [
                'from' => '+13655361575',
                'body' => "Your OTP is : $otp"
            ]);

            return redirect()->back()->with('otp_sent', true)->with('success', 'OTP Sent Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send OTP. Try again.');
        }
        // return response()->json(['error' => 'Invalid or expired OTP.'], 400);
    }
	
	public function verifyOtpNumber(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::findOrFail($request->user_id);
        $otpRecord = Otp::where('phone_number', $user->number)->first();

        if (!$otpRecord || $otpRecord->otp !== $request->otp) {
            return redirect()->back()->with('error', 'Invalid OTP. Try again.');
        }

        // Mark number as verified & log in
        $user->is_number_verified = 1;
        $user->save();
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Phone Verified & Logged In!');
    }
	
	 public function sendOtpEmail(Request $request)
    {
		// dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
			'email' => 'required|email|unique:users,email,' . $request->user_id,
        ]);

        $user = User::findOrFail($request->user_id);
		//dd($user);
         if (!$user->email) {
				$user->email = $request->email;
				$user->save();
			} elseif ($user->email !== $request->email) {
				return redirect()->route('emailNumber.verification', ['user_id' => $user->id])
					->with('error', 'This email is already in use by another user.');
			}

        // Generate a 6-digit OTP
        $otp = mt_rand(100000, 999999);

		 $user->otp = $otp;
		 $user->save();

        // Save OTP in the database
       
$body = view('emails.login_otp',compact('otp'));
            sendMail($user->name, $request->email, 'Auto Jazeera', $otp.' is your secure sign in code', $body);
        // Send OTP via Email

        return redirect()->route('emailNumber.verification', ['user_id' => $user->id])
            ->with('otp_sent', 'OTP sent successfully. Please check your email.');
    }
	
	public function verifyOtpEmail(Request $request)
{
		//dd($request->all());
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'otp' => 'required|string|size:6',
    ]);

    $user = User::find($request->user_id);
		//dd($user->otp);
    if ($user->otp != $request->otp) {
		//dd('here');
        return redirect()->route('emailNumber.verification', ['user_id' => $request->user_id])
            ->with('error', 'Invalid OTP. Please try again.');
    }

    // OTP is correct, update email verification status
    $user->is_email_verified = true;
    $user->otp = null; // Clear OTP after successful verification
    $user->save();

    // Authenticate user
    Auth::login($user);

    return redirect('/dashboard')->with('success', 'Email verified successfully! You are now logged in.');
}

}
