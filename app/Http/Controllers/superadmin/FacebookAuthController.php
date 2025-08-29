<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Models\FacebookToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JoelButcher\Facebook\Facades\Facebook;
use Illuminate\Support\Facades\Http;

class FacebookAuthController extends Controller

{
    private function getDashboardRoute()
    {
        $user = Auth::user();
        return (!$user || !$user->role) ? 'superadmin.dashboard' : 'dashboard';
    }

    public function redirect()
    {
        $permissions = 'pages_manage_posts,pages_read_engagement,pages_show_list,pages_manage_metadata';
        $clientId = config('facebook.app_id');
        $type = auth()->user()->role == null ? 'admin' : 'dealer';
        $type == 'admin' ? $redirectUri = urlencode(config('facebook.admin_redirect_uri')) : $redirectUri = urlencode(config('facebook.redirect_uri_dealer'));
        // $redirectUri = urlencode(config('facebook.redirect_uri'));

        $loginUrl = "https://www.facebook.com/v19.0/dialog/oauth?client_id={$clientId}&redirect_uri={$redirectUri}&scope={$permissions}";

        return redirect()->away($loginUrl);
    }




    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route($this->getDashboardRoute())->with('error', 'No code returned from Facebook.');
        }

        // Step 1: Exchange code for short-lived token
        $tokenResponse = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'client_id' => config('facebook.app_id'),
            'redirect_uri' => config('facebook.redirect_uri'),
            'client_secret' => config('facebook.app_secret'),
            'code' => $request->get('code'),
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->route($this->getDashboardRoute())->with('error', 'Error fetching access token.');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        // Step 2: Exchange short-lived for long-lived token
        $longResponse = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'grant_type' => 'fb_exchange_token',
            'client_id' => config('facebook.app_id'),
            'client_secret' => config('facebook.app_secret'),
            'fb_exchange_token' => $accessToken,
        ]);

        $longLivedToken = $longResponse->json()['access_token'];

        // Step 3: Fetch pages using the long-lived token
        $pagesResponse = Http::get('https://graph.facebook.com/v19.0/me/accounts', [
            'access_token' => $longLivedToken,
        ]);

        if (!$pagesResponse->successful()) {
            return redirect()->route($this->getDashboardRoute())->with('error', 'Error fetching pages from Facebook.');
        }

        $pages = $pagesResponse->json()['data'];

        // Save long-lived token in session
        session(['fb_long_lived_token' => $longLivedToken]);

        return view('facebook.select_page', compact('pages'));
    }


    public function savePage(Request $request)
    {
        $type = auth()->user()->role == null ? 'admin' : 'dealer';
        $request->validate(['page_id' => 'required']);

        [$pageId, $pageToken] = explode('|', $request->page_id);

        FacebookToken::updateOrCreate(
            [
                'dealer_id' => Auth::id(),
                'type' => $type,
            ],
            [
                'page_id' => $pageId,
                'page_access_token' => $pageToken,
            ]
        );


        return redirect(session('facebook_redirect_url', route($this->getDashboardRoute())))
            ->with('success', 'Facebook Page connected successfully!');
    }
}
