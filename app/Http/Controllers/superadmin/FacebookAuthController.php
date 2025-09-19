<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\FacebookToken;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\FacebookPageService;
use JoelButcher\Facebook\Facades\Facebook;

class FacebookAuthController extends Controller

{
    private function getDashboardRoute()
    {
        $user = Auth::user();
        return (!$user || !$user->role) ? 'superadmin.dashboard' : 'dashboard';
    }

    public function redirect()
    {
        if (!session()->has('facebook_redirect_url') || empty(session('facebook_redirect_url'))) {
            session(['facebook_redirect_url' => url()->previous()]);
        }

        $permissions = 'pages_manage_posts,pages_read_engagement,pages_show_list,instagram_basic,instagram_content_publish';

        $clientId = config('facebook.app_id');
        $type = auth()->user()->role == null ? 'admin' : 'dealer';
        $redirectUri = $type == 'admin'
            ? config('facebook.admin_redirect_uri')
            : config('facebook.redirect_uri');

        $loginUrl = "https://www.facebook.com/v19.0/dialog/oauth?client_id={$clientId}&redirect_uri={$redirectUri}&scope={$permissions}";

        return redirect()->away($loginUrl);
    }





    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route($this->getDashboardRoute())->with('error', 'No code returned from Facebook.');
        }

        $type = auth()->user()->role == null ? 'admin' : 'dealer';
        $redirectUri = $type == 'admin'
            ? config('facebook.admin_redirect_uri')
            : config('facebook.redirect_uri');

        // Step 1: Exchange code for short-lived token
        $tokenResponse = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'client_id'     => config('facebook.app_id'),
            'redirect_uri'  => $redirectUri, // ✅ matches what was used in redirect()
            'client_secret' => config('facebook.app_secret'),
            'code'          => $request->get('code'),
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->route($this->getDashboardRoute())->with('error', 'Error fetching access token.');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        // Step 2: Exchange short-lived for long-lived token
        $longResponse = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'grant_type'        => 'fb_exchange_token',
            'client_id'         => config('facebook.app_id'),
            'client_secret'     => config('facebook.app_secret'),
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
        // dd($pages);

        // ✅ Step 4: For each page, also fetch IG Business Account (if connected)
        foreach ($pages as &$page) {
            // Use the page access token instead of the user long-lived token
            $igResponse = Http::get("https://graph.facebook.com/v19.0/{$page['id']}", [
                'fields'       => 'instagram_business_account',
                'access_token' => $page['access_token'], // ✅ page token, not user token
            ]);
            //dd($igResponse);

            if ($igResponse->successful()) {
                $page['instagram_business_account'] =
                    $igResponse->json()['instagram_business_account']['id'] ?? null;
            } else {
                $page['instagram_business_account'] = null;
            }
        }

        // Save long-lived token in session
        session(['fb_long_lived_token' => $longLivedToken]);

        if ($type == 'admin') {
            return view('facebook.adminselect_page', compact('pages'));
        } else {
            return view('facebook.select_page', compact('pages'));
        }
    }


    public function savePage(Request $request)
    {
        $type = auth()->user()->role == null ? 'admin' : 'dealer';
        $request->validate(['page_id' => 'required']);

        // Now it comes in as "pageId|pageToken|igBusinessId"
        $parts = explode('|', $request->page_id);
        $pageId     = $parts[0] ?? null;
        $pageToken  = $parts[1] ?? null;
        $igBusiness = $parts[2] ?? null;

        FacebookToken::updateOrCreate(
            [
                'dealer_id' => Auth::id(),
                'type'      => $type,
            ],
            [
                'page_id'              => $pageId,
                'page_access_token'    => $pageToken,
                'instagram_business_id' => $igBusiness,
            ]
        );
        if (!empty($igBusiness)) {
            return redirect(session('facebook_redirect_url', route($this->getDashboardRoute())))
                ->with('success', 'Facebook Page and Instagram connected successfully!');
        } else {
            return redirect(session('facebook_redirect_url', route($this->getDashboardRoute())))
                ->with('success', 'Facebook Page connected successfully!');
        }
    }



    public function bike()
    {
        $post = BikePost::with('media', 'location', 'features')->withTrashed()->first();
        //dd($post);
        $fb = new FacebookPageService();
        $fb->publishAdminBikePost($post, null, null);
        dd('posyed');
    }


    public function post_on_social_media($id, $type)
    {
        try {
            if (!in_array($type, ['bike', 'car'])) {
                return redirect()->back()->with('error', 'Invalid post type.');
            }

            $post = $type === 'bike'
                ? BikePost::with(['media', 'location', 'features'])->find($id)
                : Post::with(['document', 'feature', 'location', 'contact'])->find($id);

            if (!$post) {
                return redirect()->back()->with('error', ucfirst($type) . ' post not found.');
            }

            $fb = new FacebookPageService();
            $results = [];

            if ($type === 'bike') {
                $results[] = $fb->publishPost($post, null, null);
                $results[] = $fb->publishAdminBikePost($post, null, null);
            }

            if ($type === 'car') {
                $results[] = $fb->publishPost($post, null, null);
                $results[] = $fb->publishAdminPost($post, null, null);
            }

            if (collect($results)->filter()->isNotEmpty()) {
                $post->posted_on_social_handles = 1;
                $post->save();
                return redirect()->back()->with('success', 'Post published successfully on social media.');
            }

            return redirect()->back()->with('error', 'Failed to publish post.');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'An unexpected error occurred while publishing the post.');
        }
    }
}
