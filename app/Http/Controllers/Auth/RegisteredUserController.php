<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Mail\Welcome;
use App\Mail\LoginOtp;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Normalize email to lowercase
        $email = strtolower($request->email);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->name),
        ]);
        //$body = view('emails.welcome');
        if ($user) {
            //sendMail($user->name, $user->email, 'Auto Jazeera', 'Welcome To Auto Jazera', $body);
           // try {
                Mail::to($user->email)->send(new Welcome());

             //   return response()->json([
            //        "message" => 'OTP sent to your email',
              //      'status' => 200
             //   ], 200);
          //  } catch (\Exception $e) {
            //    return response()->json([
              //      "message" => 'Email not sent, please try again later.',
                //    'status' => 500,
                  //  'error' => $e->getMessage()
           //     ], 500);
        //    }
        }
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->save();
        //$body = view('emails.login_otp', compact('otp'));

        // if (sendMail($user->name, $user->email, 'Auto Jazeera', $otp.' is your secure sign in code', $body)) {
        //     $email = $request->email;
        //     session(['email' => $email]);
        //     return redirect()->route('verify_login_otp');
        // } else {
        //     return redirect()->back()->with('warning', 'signup successfull, please login');
        // }
        try {
            Mail::to($user->email)->send(new LoginOtp($otp));
            $email = $request->email;
            session(['email' => $email]);
            session(['resendOtp' => 'OTP sent to your email']);
            return redirect()->route('verify_login_otp');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'signup successfull, please login');
        }
    }
}
