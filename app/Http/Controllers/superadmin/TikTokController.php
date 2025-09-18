<?php
namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\TiktokTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TikTokController extends Controller
{
    /**
     * Redirect user to TikTok OAuth
     */
    public function redirectToTikTok()
    {
        $state = uniqid(); // store in session ideally

        $params = [
            'client_key'    => config('tiktok.client_key'),
            'scope'         => 'user.info.basic,video.upload,video.publish', // request posting scopes
            'response_type' => 'code',
            'redirect_uri'  => config('tiktok.admin_redirect_uri'),
            'state'         => $state,
        ];

        $url = 'https://www.tiktok.com/v2/auth/authorize/?' . http_build_query($params);

        return redirect($url);
    }

    /**
     * Handle TikTok callback and save tokens
     */
    public function handleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return redirect()->route('dashboard')->with('error', 'TikTok login failed.');
        }

        $ch = curl_init();

        $postFields = http_build_query([
            'client_key'    => config('tiktok.client_key'),
            'client_secret' => config('tiktok.client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => config('tiktok.admin_redirect_uri'),
        ]);

        curl_setopt_array($ch, [
            CURLOPT_URL            => "https://open.tiktokapis.com/v2/oauth/token/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/x-www-form-urlencoded"
            ],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            dd("cURL Error: " . curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);
        // dd($data);

        $token = new TiktokTokens();
        $token->user_id = auth()->id();
        $token->type = auth()->user()->role == null ? 'admin' : 'user';
        $token->tiktok_access_token = $data['access_token'] ?? null;
        $token->tiktok_refresh_token = $data['refresh_token'] ?? null;
        $token->tiktok_open_id = $data['open_id'] ?? null;
        $token->tiktok_token_expires = now()->addSeconds($data['expires_in'] ?? 0);
        $token->save();

        if(auth()->user()->role == null){
          return redirect(url('superadmin/social-links'))->with('success', 'TikTok connected!');
            
        }

        return redirect()->route('dashboard')->with('success', 'TikTok connected!');
    }

    /**
     * Refresh TikTok Access Token
     */
    public function refreshToken($refreshToken)
    {
        $ch = curl_init();

        $postFields = http_build_query([
            'client_key'    => config('tiktok.client_key'),
            'client_secret' => config('tiktok.client_secret'),
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        curl_setopt_array($ch, [
            CURLOPT_URL            => "https://open.tiktokapis.com/v2/oauth/token/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return ["error" => curl_error($ch)];
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Publish video ad to TikTok
     */
    public function publishVideo($filePath, $caption = 'New Vehicle Ad!')
    {
        $user = auth()->user();

        $response = Http::withToken($user->tiktok_access_token)
            ->attach('video', fopen($filePath, 'r'), basename($filePath))
            ->post("https://open.tiktokapis.com/v2/post/publish/video/", [
                'post_info' => json_encode([
                    'title' => $caption,
                ]),
            ]);

        return $response->json();
    }
}
