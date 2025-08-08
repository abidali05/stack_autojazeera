<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\State;
use App\Mail\LoginOtp;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (url()->previous() == url('/subscription-plans')) {
            session()->put('url.intended', url('/subscription-plans'));
        }

        Log::info(session()->get('url.intended'));

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This account doesn\'t exist. Please <a href="/register" style="color:#FD5631;text-decoration: underline;"><strong>Sign Up</strong></a>.'
        ]);
        $check = User::where(['email' => $request->email, 'status' => 'active'])->first();
        if (isset($check)) {
            $otp = rand(100000, 999999);
            $check->otp = $otp;
            $check->save();

            //$imageUrl = url('web/images/emallgo.png');

            //$body = view('emails.login_otp',compact('otp'));
            //Mail::to($check->email)->send(new LoginOtp($otp));
            try {
                Mail::to($check->email)->send(new LoginOtp($otp));

                $email = $request->email;
                session(['email' => $email]);
                return redirect()->route('verify_login_otp')->with('resendOtp', 'OTP has been sent to your email');
            } catch (\Exception $e) {
                return response()->json([
                    "message" => 'Failed to send OTP',
                    'status' => 500,
                    'error' => $e->getMessage()
                ], 500);
            }
            //sendMail($check->name, $check->email, 'Auto Jazeera', $otp.' is your secure sign in code', $body);

            // return redirect()->back()->with('warning','OTP has been sent to your email');


            // dd(session()->all());
            // return view('auth.validate_login_otp');      

            // return redirect()->back()->with('success','OTP has been sent to your email', 'otpshow', true);
            // $request->authenticate();

            // $request->session()->regenerate();

            // return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect()->back()->with('warning', 'This account doesnt exists . Please sign up.');
        }
    }


    public function viewLoginOtp(Request $request)
    {
        if (session()->has('email')) {
            return view('auth.validate_login_otp');
        } else {
            return redirect()->route('login')->with('warning', 'You are not authorized to view this page');
        }
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $otp = implode('', $request->input('otp'));
        $otp = (int) $otp;

        $check = User::where(['email' => $request->email, 'otp' => $otp])->first();
        if (isset($check)) {
            $check->otp = null;
            if ($check->is_email_verified == 0) {
                $check->is_email_verified = 1;
            }

            $check->save();

            //if (!$check->number && !$check->is_number_verified) {
            //    return redirect()->route('number.verification', ['user_id' => $check->id]);
            //}

            Auth::login($check);

            if (session()->has('url.intended')) {
                $intendedUrl = session()->get('url.intended');
                Log::info($intendedUrl);
                return redirect($intendedUrl);
            }


            session()->forget('email');

            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect()->route('verify_login_otp')->with('resendOtp', 'OTP is Invalid');
        }
    }


    public function create_number()
    {
        // if (url()->previous() == url('/subscription-plans')) {
        //     session()->put('url.intended', url('/subscription-plans'));
        // }
        return view('auth.number_login');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function resendOtp(Request $request)
    {
        $check = User::where(['email' => $request->email])->first();
        if (isset($check)) {
            if ($check->status == 'active') {
                $otp = rand(100000, 999999);
                $check->otp = $otp;
                $check->save();

                //$body = view('emails.login_otp', compact('otp'));
                //sendMail($check->name, $check->email, 'Auto Jazeera', $otp . ' is your secure sign in code', $body);
                Mail::to($check->email)->send(new LoginOtp($otp));
                return redirect()->back()->with('resendOtp', 'OTP has been sent to your email');
            } else {
                return redirect()->back()->with('resendOtp', 'Your account is inactive, Please contact admin');
            }
        } else {
            return redirect()->back()->with('resendOtp', 'This account doesnt exists . Please sign up.');
        }
    }
}
