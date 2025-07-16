<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RefreshExpiredToken
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $request->bearerToken() && $this->isTokenExpired($request->bearerToken())) {
            // Revoke the current token
            $user->currentAccessToken()->delete();

            // Generate a new token
            $newToken = $user->createToken('auth:sanctum')->plainTextToken;

            // Return a custom response with a unique status code
            return response()->json([
                'status' => 420,
                'message' => 'Your token has expired. A new token has been issued.',
                'token' => $newToken,
            ], 420); 
        }

        return $next($request);
    }

    /**
     * Determine if the token is expired.
     */
    private function isTokenExpired($token)
    {
        // Example: Token expiration logic using `created_at`
        $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return true; // If the token doesn't exist, consider it expired
        }

        // Assume tokens expire after 1 hour (3600 seconds)
        $expiresInSeconds = config('sanctum.expiration', 60) * 60;

        // Check if the token creation time + expiration duration is less than the current time
        return Carbon::parse($personalAccessToken->created_at)->addSeconds($expiresInSeconds)->isPast();
    }
}
