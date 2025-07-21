<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Provence;
use App\Models\Province;
use App\Models\State;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PhpParser\Builder\Function_;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class SuperadminController extends Controller
{

    public function showLoginForm()
    {

        return view('superadmin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        // dd($request->all());


        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('superadmin')->attempt($credentials)) {
            // $request->authenticate();

            $request->session()->regenerate();
            // return redirect()->intended('/superadmin/dashboard');
            return redirect('superadmin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect('/superadmin/login');
    }
    
    public function addpost()
    {
        return view('post.add_post');
    }
    public function admin_change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'dealer' => 'required|max:255',
            'old_password' => 'required|string',
            'password' => 'required|min:8|confirmed',

        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = Auth::guard('superadmin')->user();
        // $credentials = $request->only('email', 'password');
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The current password does not match our records.']);
        }

        // Update the password
        $u = Superadmin::find($user->id);
        $u->password = bcrypt($request->password);
        $u->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
