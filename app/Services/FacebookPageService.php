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

        $fbToken = FacebookToken::where('dealer_id', $user_id)->where('type', 'dealer')->first();
        if (!$fbToken || empty($fbToken->page_access_token)) {
            Log::warning(" No valid Facebook Page token for dealer_id {$user_id}");
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
            "🔖 Hashtags:\n" .
            "#UsedCars #{$post->makeName} #{$post->modelName} #CarForSale #{$post['city']}Cars #DreamCar #AutoDeals #CarShopping #VehiclesForSale";

        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs
            $images = $post->document()->where('doc_type', 'image')->get()
                ->map(fn($d) => url('posts/doc/' . $d->doc_name))
                ->toArray();

            // ==========================
            // ✅ FACEBOOK POSTING
            // ==========================
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

            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
            }

            // ==========================
            // ✅ INSTAGRAM POSTING (Carousel for multiple images)
            // ==========================
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                $childMediaIds = [];

                // Step A: Create child media containers for each image
                foreach ($images as $imageUrl) {
                    $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'image_url'    => $imageUrl,
                        'is_carousel_item' => true,
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($childResponse->successful() && isset($childResponse->json()['id'])) {
                        $childMediaIds[] = $childResponse->json()['id'];
                    } else {
                        Log::error("❌ IG child media creation failed: " . $childResponse->body());
                    }
                }

                if (count($childMediaIds) > 0) {
                    // Step B: Create carousel container
                    $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'caption'       => $message,
                        'children'      => implode(',', $childMediaIds),
                        'media_type'    => 'CAROUSEL',
                        'access_token'  => $fbToken->page_access_token,
                    ]);

                    if ($carouselResponse->successful() && isset($carouselResponse->json()['id'])) {
                        $carouselId = $carouselResponse->json()['id'];

                        // Step C: Publish carousel
                        $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                            'creation_id'  => $carouselId,
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        if ($publishResponse->successful()) {
                            Log::info("✅ Instagram carousel post published for IG account {$fbToken->instagram_business_id}");
                        } else {
                            Log::error("❌ IG carousel publish failed: " . $publishResponse->body());
                        }
                    } else {
                        Log::error("❌ IG carousel container failed: " . $carouselResponse->body());
                    }
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram API Exception: ' . $e->getMessage());
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
            "🔖 Hashtags:\n" .
            "#UsedCars #{$post->makeName} #{$post->modelName} #CarForSale #{$post['city']}Cars #DreamCar #AutoDeals #CarShopping #VehiclesForSale";

        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs
            $images = $post->document()->where('doc_type', 'image')->get()
                ->map(fn($d) => url('posts/doc/' . $d->doc_name))
                ->toArray();

            // ==========================
            // ✅ FACEBOOK POSTING
            // ==========================
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

            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
            }

            // ==========================
            // ✅ INSTAGRAM POSTING (Carousel for multiple images)
            // ==========================
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                $childMediaIds = [];

                // Step A: Create child media containers for each image
                foreach ($images as $imageUrl) {
                    $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'image_url'    => $imageUrl,
                        'is_carousel_item' => true,
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($childResponse->successful() && isset($childResponse->json()['id'])) {
                        $childMediaIds[] = $childResponse->json()['id'];
                    } else {
                        Log::error("❌ IG child media creation failed: " . $childResponse->body());
                    }
                }

                if (count($childMediaIds) > 0) {
                    // Step B: Create carousel container
                    $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'caption'       => $message,
                        'children'      => implode(',', $childMediaIds),
                        'media_type'    => 'CAROUSEL',
                        'access_token'  => $fbToken->page_access_token,
                    ]);

                    if ($carouselResponse->successful() && isset($carouselResponse->json()['id'])) {
                        $carouselId = $carouselResponse->json()['id'];

                        // Step C: Publish carousel
                        $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                            'creation_id'  => $carouselId,
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        if ($publishResponse->successful()) {
                            Log::info("✅ Instagram carousel post published for IG account {$fbToken->instagram_business_id}");
                        } else {
                            Log::error("❌ IG carousel publish failed: " . $publishResponse->body());
                        }
                    } else {
                        Log::error("❌ IG carousel container failed: " . $carouselResponse->body());
                    }
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram API Exception: ' . $e->getMessage());
            return false;
        }
    }









    // ===========================================================Publish Bike Post===============================================


    public function publishBikePost($post, $request, $user)
    {
        $user_id = ($user->role == '2' || $user->role == 2) ? $user->dealer_id : $user->id;

        $fbToken = FacebookToken::where('dealer_id', $user_id)->where('type', 'dealer')->first();
        if (!$fbToken || empty($fbToken->page_access_token)) {
            Log::warning(" No valid Facebook Page token for dealer_id {$user_id}");
            return false;
        }

        $features = $post->features()
            ->get()
            ->pluck('featurename')
            ->flatten()
            ->implode("\n");

        $features = $features ?: "-";

        $message = "{$post->makename} {$post->modelname} {$post->year}\n" .
            "💰 Price: {$post->price} PKR\n" .
            "📍 Location: {$post->location->cityname}, {$post->location->provincename}\n" .
            "📅 Mileage: {$post->mileage} km\n" .
            "⚙️ Transmission: {$post->transmission}\n" .
            "⛽ Fuel Type: {$post->fuel_type}\n\n" .
            "✨ Highlights:\n{$features}\n\n" .
            "📞 Contact: " . optional($post->contact)->phone_number . "\n" .
            "🔖 Hashtags:\n" .
            "#UsedBikes #{$post->makename} #{$post->modelname} #BikeForSale #{$post->location->cityname}Bikes #DreamBike #AutoDeals #BikeShopping #BikesForSale";


        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs
            $images = $post->media()->get()
                ->map(fn($d) => url($d->file_path))
                ->toArray();

            // ==========================
            // ✅ FACEBOOK POSTING
            // ==========================
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

            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
            }

            // ==========================
            // ✅ INSTAGRAM POSTING (Carousel for multiple images)
            // ==========================
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                $childMediaIds = [];

                // Step A: Create child media containers for each image
                foreach ($images as $imageUrl) {
                    $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'image_url'    => $imageUrl,
                        'is_carousel_item' => true,
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($childResponse->successful() && isset($childResponse->json()['id'])) {
                        $childMediaIds[] = $childResponse->json()['id'];
                    } else {
                        Log::error("❌ IG child media creation failed: " . $childResponse->body());
                    }
                }

                if (count($childMediaIds) > 0) {
                    // Step B: Create carousel container
                    $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'caption'       => $message,
                        'children'      => implode(',', $childMediaIds),
                        'media_type'    => 'CAROUSEL',
                        'access_token'  => $fbToken->page_access_token,
                    ]);

                    if ($carouselResponse->successful() && isset($carouselResponse->json()['id'])) {
                        $carouselId = $carouselResponse->json()['id'];

                        // Step C: Publish carousel
                        $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                            'creation_id'  => $carouselId,
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        if ($publishResponse->successful()) {
                            Log::info("✅ Instagram carousel post published for IG account {$fbToken->instagram_business_id}");
                        } else {
                            Log::error("❌ IG carousel publish failed: " . $publishResponse->body());
                        }
                    } else {
                        Log::error("❌ IG carousel container failed: " . $carouselResponse->body());
                    }
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram API Exception: ' . $e->getMessage());
            return false;
        }
    }
    public function publishAdminBikePost($post, $request, $user)
    {
        $fbToken = FacebookToken::where('type', 'admin')->first();
        if (!$fbToken || empty($fbToken->page_access_token)) {
            Log::warning("❌ No valid Facebook Page token for admin");
            return false;
        }

        $features = $post->features()
            ->get()
            ->pluck('featurename')
            ->flatten()
            ->implode("\n");

        $features = $features ?: "-";

        $message = "{$post->makename} {$post->modelname} {$post->year}\n" .
            "💰 Price: {$post->price} PKR\n" .
            "📍 Location: {$post->location->cityname}, {$post->location->provincename}\n" .
            "📅 Mileage: {$post->mileage} km\n" .
            "⚙️ Transmission: {$post->transmission}\n" .
            "⛽ Fuel Type: {$post->fuel_type}\n\n" .
            "✨ Highlights:\n{$features}\n\n" .
            "📞 Contact: " . optional($post->contact)->phone_number . "\n" .
            "🔖 Hashtags:\n" .
            "#UsedBikes #{$post->makename} #{$post->modelname} #BikeForSale #{$post->location->cityname}Bikes #DreamBike #AutoDeals #BikeShopping #BikesForSale";


        try {
            $photoIds = [];

            // ✅ Step 1: Collect all image URLs
            $images = $post->media()->get()
                ->map(fn($d) => url($d->file_path))
                ->toArray();

            // ==========================
            // ✅ FACEBOOK POSTING
            // ==========================
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

            $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                'message'        => $message,
                'attached_media' => $photoIds,
                'access_token'   => $fbToken->page_access_token,
            ]);

            $json = $postResponse->json();

            if ($postResponse->successful() && isset($json['id'])) {
                Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$json['id']}");
            } else {
                Log::error("❌ FB feed post failed: " . json_encode($json));
            }

            // ==========================
            // ✅ INSTAGRAM POSTING (Carousel for multiple images)
            // ==========================
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                $childMediaIds = [];

                // Step A: Create child media containers for each image
                foreach ($images as $imageUrl) {
                    $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'image_url'    => $imageUrl,
                        'is_carousel_item' => true,
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($childResponse->successful() && isset($childResponse->json()['id'])) {
                        $childMediaIds[] = $childResponse->json()['id'];
                    } else {
                        Log::error("❌ IG child media creation failed: " . $childResponse->body());
                    }
                }

                if (count($childMediaIds) > 0) {
                    // Step B: Create carousel container
                    $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                        'caption'       => $message,
                        'children'      => implode(',', $childMediaIds),
                        'media_type'    => 'CAROUSEL',
                        'access_token'  => $fbToken->page_access_token,
                    ]);

                    if ($carouselResponse->successful() && isset($carouselResponse->json()['id'])) {
                        $carouselId = $carouselResponse->json()['id'];

                        // Step C: Publish carousel
                        $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                            'creation_id'  => $carouselId,
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        if ($publishResponse->successful()) {
                            Log::info("✅ Instagram carousel post published for IG account {$fbToken->instagram_business_id}");
                        } else {
                            Log::error("❌ IG carousel publish failed: " . $publishResponse->body());
                        }
                    } else {
                        Log::error("❌ IG carousel container failed: " . $carouselResponse->body());
                    }
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram API Exception: ' . $e->getMessage());
            return false;
        }
    }
}
