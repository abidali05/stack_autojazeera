<?php


namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // if (url()->previous() == url('/subscription-plans')) {
        //     session()->put('url.intended', url('/subscription-plans'));
        // }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            //  dd($googleUser);
            // $user = User::where('email', $googleUser->getEmail())->first();
            $user = User::where('email', $googleUser->email)->first();
            // dd($user);
            if ($user) {
                Auth::login($user);
            } else {
                $parts = explode("@", $googleUser->email);
                $name = $parts[0];
                $user = User::create([
                    'name' => $googleUser->name ?? $name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('password')
                ]);
                Auth::login($user);

                if (session()->has('url.intended')) {
                    $intendedUrl = session()->get('url.intended');
                    Log::info($intendedUrl);
                    return redirect($intendedUrl);
                }
            }
            return redirect('dashboard');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('login');
        }
    }
}
