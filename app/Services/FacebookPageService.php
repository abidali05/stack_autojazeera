<?php

namespace App\Services;

use App\Models\FacebookToken;
use JoelButcher\Facebook\Facades\Facebook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FacebookPageService
{
    /**
     * Publish a text post with optional link.
     */
    public function publishPost($post, $request, $user)
    {
        $user_id = ($user->role == '2' || $user->role == 2) ? $user->dealer_id : $user->id;

        $fbToken = FacebookToken::where('dealer_id', $user_id)->first();
        if (!$fbToken || empty($fbToken->page_access_token)) {
            Log::warning("❌ No valid Facebook Page token for dealer_id {$user_id}");
            return false;
        }


        $features = $post->feature()
            ->with('mainfeature')
            ->get()
            ->pluck('mainfeature.Sub_feature')
            ->flatten()
            ->implode("\n");

        $features = $features ?: "-";

        $message = "{$post->makeName} {$post->modelName} {$post->year}\n" .
            "💰 Price: {$post->price} PKR\n" .
            "📍 Location: {$post['location']['cityname']}, {$post['location']['provincename']}\n" .
            "📅 Mileage: {$post->milleage} km\n" .
            "⚙️ Transmission: {$post->transmission}\n" .
            "⛽ Fuel Type: {$post->fuel}\n\n" .
            "✨ Highlights:\n{$features}\n\n" .
            "📞 Contact: {$post->contact->number}\n" .
            "🌐 More details & photos: " . url('/car-detail/' . $post->id) . "\n\n" .
            "🔖 Hashtags:\n" .
            "#UsedCars #{$post->makeName} #{$post->modelName} #CarForSale #{$post['city']}Cars #DreamCar #AutoDeals #CarShopping #VehiclesForSale";

        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs from documents
            $images = $post->document()->where('doc_type', 'image')->get()
                ->map(fn($d) => url('posts/doc/' . $d->doc_name))
                ->toArray();

            foreach ($images as $imageUrl) {
                $photoResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/photos", [
                    'url'          => $imageUrl,
                    'published'    => 'false',
                    'access_token' => $fbToken->page_access_token,
                ]);

                if ($photoResponse->successful() && isset($photoResponse->json()['id'])) {
                    $photoIds[] = ['media_fbid' => $photoResponse->json()['id']];
                } else {
                    Log::error("❌ FB photo upload failed: " . $photoResponse->body());
                }
            }

            // ✅ Step 2: Create the post with message + all images
            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
                $this->publishAdminPost($post, $request, $user);
                return true;
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
                return false;
            }
        } catch (\Exception $e) {
            Log::error('❌ Facebook API Exception: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Publish to admin page / AutoJazeera page
     */



     public function publishAdminPost($post, $request, $user)
    {
       

        $fbToken = FacebookToken::where('type', 'admin')->first();
        if (!$fbToken || empty($fbToken->page_access_token)) {
            Log::warning("❌ No valid Facebook Page token for admin");
            return false;
        }


        $features = $post->feature()
            ->with('mainfeature')
            ->get()
            ->pluck('mainfeature.Sub_feature')
            ->flatten()
            ->implode("\n");

        $features = $features ?: "-";

        $message = "{$post->makeName} {$post->modelName} {$post->year}\n" .
            "💰 Price: {$post->price} PKR\n" .
            "📍 Location: {$post['location']['cityname']}, {$post['location']['provincename']}\n" .
            "📅 Mileage: {$post->milleage} km\n" .
            "⚙️ Transmission: {$post->transmission}\n" .
            "⛽ Fuel Type: {$post->fuel}\n\n" .
            "✨ Highlights:\n{$features}\n\n" .
            "📞 Contact: {$post->contact->number}\n" .
            "🌐 More details & photos: " . url('/car-detail/' . $post->id) . "\n\n" .
            "🔖 Hashtags:\n" .
            "#UsedCars #{$post->makeName} #{$post->modelName} #CarForSale #{$post['city']}Cars #DreamCar #AutoDeals #CarShopping #VehiclesForSale";

        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs from documents
            $images = $post->document()->where('doc_type', 'image')->get()
                ->map(fn($d) => url('posts/doc/' . $d->doc_name))
                ->toArray();

            foreach ($images as $imageUrl) {
                $photoResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/photos", [
                    'url'          => $imageUrl,
                    'published'    => 'false',
                    'access_token' => $fbToken->page_access_token,
                ]);

                if ($photoResponse->successful() && isset($photoResponse->json()['id'])) {
                    $photoIds[] = ['media_fbid' => $photoResponse->json()['id']];
                } else {
                    Log::error("❌ FB photo upload failed: " . $photoResponse->body());
                }
            }

            // ✅ Step 2: Create the post with message + all images
            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
                return true;
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
                return false;
            }
        } catch (\Exception $e) {
            Log::error('❌ Facebook API Exception: ' . $e->getMessage());
            return false;
        }
    }





    // ===========================================================Publish Bike Post===============================================



  
}
