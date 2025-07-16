<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // if (!Session::has('user_id')) {
        //     return route('login')->with('error', 'Your session has expired. Please log in again.');
        // }

        return $request->expectsJson() ? null : route('login');
    }
}
