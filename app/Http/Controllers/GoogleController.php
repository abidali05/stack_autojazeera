<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // dd('ere');
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
           //  dd($googleUser);
            // $user = User::where('email', $googleUser->getEmail())->first();
            $user = User::where('email',$googleUser->email)->first();
            // dd($user);
            if($user){
                Auth::login($user);
            } else {
				$parts = explode("@", $googleUser->email);
				$name = $parts[0];
                $user = User::create([
                    'name' => $googleUser->name ?? $name ,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('password')
                ]);
                Auth::login($user);
            }
            return redirect('dashboard');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('login');
        }
    }
}

