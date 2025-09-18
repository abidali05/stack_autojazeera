<?php

namespace App\Services;

use App\Models\FacebookToken;
use App\Models\FacebookInstaPost;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use JoelButcher\Facebook\Facades\Facebook;

class FacebookPageService
{
    /**
     * Publish a text post with optional link.
     */
    public function publishPost($post, $request, $user)
    {
        try {
            $user_id = ($user->role == '2' || $user->role == 2) ? $user->dealer_id : $user->id;

            $fbToken = FacebookToken::where('dealer_id', $user_id)->where('type', 'dealer')->first();
            if (!$fbToken || empty($fbToken->page_access_token)) {
                Log::warning("❌ No valid Facebook Page token for dealer_id {$user_id}");
                return false;
            }

            // ===== FEATURES =====
            $features = $post->feature()
                ->with('mainfeature')
                ->get()
                ->pluck('mainfeature.Sub_feature')
                ->flatten()
                ->implode("\n") ?: "-";

            // ===== MESSAGE =====
            $message = "{$post->makeName} {$post->modelName} {$post->year}\n" .
                "💰 Price: {$post->price} PKR\n" .
                "📍 Location: " . ($post->location['cityname'] ?? '-') . ", " . ($post->location['provincename'] ?? '-') . "\n" .
                "📅 Mileage: {$post->milleage} km\n" .
                "⚙️ Transmission: {$post->transmission}\n" .
                "⛽ Fuel Type: {$post->fuel}\n\n" .
                "✨ Highlights:\n{$features}\n\n" .
                "📞 Contact: " . optional($post->contact)->number . "\n" .
                "🔖 Hashtags:\n" .
                "#UsedCars #{$post->makeName} #{$post->modelName} #CarForSale #" . ($post->city ?? '-') . "Cars #DreamCar #AutoDeals #CarShopping #VehiclesForSale";

            // ===== IMAGES =====
            $images = $post->document()->where('doc_type', 'image')->get()
                ->map(fn($d) => url('posts/doc/' . $d->doc_name))
                ->toArray();

            $photoIds = [];

            // ===== FACEBOOK PHOTOS =====
            foreach ($images as $imageUrl) {
                try {
                    $photoResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/photos", [
                        'url'          => $imageUrl,
                        'published'    => 'false',
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    $photoJson = $photoResponse->json();
                    if ($photoResponse->successful() && !empty($photoJson['id'])) {
                        $photoIds[] = ['media_fbid' => $photoJson['id']];
                    } else {
                        Log::error("❌ FB photo upload failed for {$imageUrl}: " . json_encode($photoJson));
                    }
                } catch (\Exception $ex) {
                    Log::error("❌ FB photo exception for {$imageUrl}: " . $ex->getMessage());
                }
            }

            // ===== FACEBOOK POST =====
            $fbPostId = null;
            try {
                $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                    'message'        => $message,
                    'attached_media' => $photoIds,
                    'access_token'   => $fbToken->page_access_token,
                ]);

                $json = $postResponse->json();
                Log::info('Facebook post response:', $json);

                if ($postResponse->successful() && !empty($json['id'])) {
                    $fbPostId = $json['id'];
                    FacebookInstaPost::updateOrCreate(
                        ['post_id' => $post->id, 'user_id' => $user_id, 'platform' => 'facebook'],
                        [
                            'type'        => 'car',
                            'page_id'     => $fbToken->page_id,
                            'post_fbid'   => $fbPostId,
                            'ig_media_id' => null,
                        ]
                    );
                    Log::info("✅ Post created on Facebook Page {$fbToken->page_id}: {$fbPostId}");
                } else {
                    Log::error("❌ FB feed post failed: " . json_encode($json));
                }
            } catch (\Exception $ex) {
                Log::error("❌ FB feed exception: " . $ex->getMessage());
            }

            // ===== INSTAGRAM POST =====
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                try {
                    $childMediaIds = [];

                    foreach ($images as $imageUrl) {
                        $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                            'image_url'       => $imageUrl,
                            'is_carousel_item' => true,
                            'access_token'    => $fbToken->page_access_token,
                        ]);

                        $childJson = $childResponse->json();
                        if ($childResponse->successful() && !empty($childJson['id'])) {
                            $childMediaIds[] = $childJson['id'];
                        } else {
                            Log::error("❌ IG child media failed for {$imageUrl}: " . json_encode($childJson));
                        }
                    }

                    if (!empty($childMediaIds)) {
                        $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                            'caption'     => $message,
                            'children'    => implode(',', $childMediaIds),
                            'media_type'  => 'CAROUSEL',
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        $carouselJson = $carouselResponse->json();
                        if ($carouselResponse->successful() && !empty($carouselResponse->json()['id'])) {
                            $carouselId = $carouselResponse->json()['id'];

                            $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                                'creation_id'  => $carouselId,
                                'access_token' => $fbToken->page_access_token,
                            ]);

                            $publishJson = $publishResponse->json();
                            Log::info('Instagram publish response:', $publishJson);

                            if ($publishResponse->successful() && isset($publishJson['id'])) {
                                // ✅ Always fetch the real media object
                                $igMediaId = $publishJson['id'];
                                $verifyResponse = Http::get("https://graph.facebook.com/v19.0/{$igMediaId}", [
                                    'fields'       => 'id,caption,media_type,permalink,timestamp,children{media_type,media_url}',
                                    'access_token' => $fbToken->page_access_token,
                                ]);
                                if ($verifyResponse->successful()) {
                                    $verified = $verifyResponse->json();
                                    $igMediaId = $verified['id'];
                                }

                                FacebookInstaPost::updateOrCreate(
                                    ['post_id' => $post->id, 'user_id' => $user_id, 'platform' => 'instagram'],
                                    [
                                        'type'        => 'car',
                                        'page_id'     => $fbToken->page_id,
                                        'post_fbid'   => null,
                                        'ig_media_id' => $igMediaId,
                                    ]
                                );
                                Log::info("✅ Instagram carousel post published for IG account {$fbToken->instagram_business_id}, media_id: {$igMediaId}");
                            } else {
                                Log::error("❌ IG carousel publish failed: " . json_encode($publishJson));
                            }
                        } else {
                            Log::error("❌ IG carousel container failed: " . json_encode($carouselJson));
                        }
                    }
                } catch (\Exception $ex) {
                    Log::error("❌ IG exception: " . $ex->getMessage());
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram API Exception (outer): ' . $e->getMessage());
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
        try {
            $user_id = ($user->role == '2' || $user->role == 2) ? $user->dealer_id : $user->id;

            $fbToken = FacebookToken::where('dealer_id', $user_id)->where('type', 'dealer')->first();
            if (!$fbToken || empty($fbToken->page_access_token)) {
                Log::warning("❌ No valid Facebook Page token for dealer_id {$user_id}");
                return false;
            }

            // ===== FEATURES =====
            $features = $post->features()
                ->get()
                ->pluck('featurename')
                ->flatten()
                ->implode("\n") ?: "-";

            // ===== MESSAGE =====
            $message = "{$post->makename} {$post->modelname} {$post->year}\n" .
                "💰 Price: {$post->price} PKR\n" .
                "📍 Location: " . optional($post->location)->cityname . ", " . optional($post->location)->provincename . "\n" .
                "📅 Mileage: {$post->mileage} km\n" .
                "⚙️ Transmission: {$post->transmission}\n" .
                "⛽ Fuel Type: {$post->fuel_type}\n\n" .
                "✨ Highlights:\n{$features}\n\n" .
                "📞 Contact: " . optional($post->contact)->phone_number . "\n" .
                "🔖 Hashtags:\n" .
                "#UsedBikes #{$post->makename} #{$post->modelname} #BikeForSale #" . optional($post->location)->cityname . "Bikes #DreamBike #AutoDeals #BikeShopping #BikesForSale";

            // ===== IMAGES =====
            $images = $post->media()->get()
                ->map(fn($d) => url($d->file_path))
                ->toArray();

            $photoIds = [];

            // ===== FACEBOOK PHOTOS =====
            foreach ($images as $imageUrl) {
                try {
                    $photoResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/photos", [
                        'url'          => $imageUrl,
                        'published'    => 'false',
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    $photoJson = $photoResponse->json();
                    if ($photoResponse->successful() && !empty($photoJson['id'])) {
                        $photoIds[] = ['media_fbid' => $photoJson['id']];
                    } else {
                        Log::error("❌ FB photo upload failed for {$imageUrl}: " . json_encode($photoJson));
                    }
                } catch (\Exception $ex) {
                    Log::error("❌ FB photo exception for {$imageUrl}: " . $ex->getMessage());
                }
            }

            // ===== FACEBOOK POST =====
            try {
                $postResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->page_id}/feed", [
                    'message'        => $message,
                    'attached_media' => $photoIds,
                    'access_token'   => $fbToken->page_access_token,
                ]);

                $json = $postResponse->json();
                Log::info('Facebook bike post response:', $json);

                if ($postResponse->successful() && !empty($json['id'])) {
                    $fbPostId = $json['id'];

                    FacebookInstaPost::updateOrCreate(
                        ['post_id' => $post->id, 'user_id' => $user_id, 'platform' => 'facebook'],
                        [
                            'type'        => 'bike',
                            'page_id'     => $fbToken->page_id,
                            'post_fbid'   => $fbPostId,
                            'ig_media_id' => null,
                        ]
                    );

                    Log::info("✅ Bike post created on Facebook Page {$fbToken->page_id}: {$fbPostId}");
                } else {
                    Log::error("❌ FB feed bike post failed: " . json_encode($json));
                }
            } catch (\Exception $ex) {
                Log::error("❌ FB feed bike exception: " . $ex->getMessage());
            }

            // ===== INSTAGRAM POST =====
            if (!empty($fbToken->instagram_business_id) && count($images) > 0) {
                try {
                    $childMediaIds = [];

                    foreach ($images as $imageUrl) {
                        $childResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                            'image_url'       => $imageUrl,
                            'is_carousel_item' => true,
                            'access_token'    => $fbToken->page_access_token,
                        ]);

                        $childJson = $childResponse->json();
                        if ($childResponse->successful() && !empty($childJson['id'])) {
                            $childMediaIds[] = $childJson['id'];
                        } else {
                            Log::error("❌ IG child bike media failed for {$imageUrl}: " . json_encode($childJson));
                        }
                    }

                    if (!empty($childMediaIds)) {
                        $carouselResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media", [
                            'caption'     => $message,
                            'children'    => implode(',', $childMediaIds),
                            'media_type'  => 'CAROUSEL',
                            'access_token' => $fbToken->page_access_token,
                        ]);

                        $carouselJson = $carouselResponse->json();
                        if ($carouselResponse->successful() && !empty($carouselResponse->json()['id'])) {
                            $carouselId = $carouselResponse->json()['id'];

                            $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$fbToken->instagram_business_id}/media_publish", [
                                'creation_id'  => $carouselId,
                                'access_token' => $fbToken->page_access_token,
                            ]);

                            $publishJson = $publishResponse->json();
                            Log::info('Instagram bike publish response:', $publishJson);

                            if ($publishResponse->successful() && isset($publishJson['id'])) {
                                // ✅ Always fetch the real media object
                                $igMediaId = $publishJson['id'];
                                $verifyResponse = Http::get("https://graph.facebook.com/v19.0/{$igMediaId}", [
                                    'fields'       => 'id,caption,media_type,permalink,timestamp,children{media_type,media_url}',
                                    'access_token' => $fbToken->page_access_token,
                                ]);
                                if ($verifyResponse->successful()) {
                                    $verified = $verifyResponse->json();
                                    $igMediaId = $verified['id'];
                                }

                                FacebookInstaPost::updateOrCreate(
                                    ['post_id' => $post->id, 'user_id' => $user_id, 'platform' => 'instagram'],
                                    [
                                        'type'        => 'bike',
                                        'page_id'     => $fbToken->page_id,
                                        'post_fbid'   => null,
                                        'ig_media_id' => $igMediaId,
                                    ]
                                );
                                Log::info("✅ Instagram bike carousel post published for IG account {$fbToken->instagram_business_id}, media_id: {$igMediaId}");
                            } else {
                                Log::error("❌ IG bike carousel publish failed: " . json_encode($publishJson));
                            }
                        } else {
                            Log::error("❌ IG bike carousel container failed: " . json_encode($carouselJson));
                        }
                    }
                } catch (\Exception $ex) {
                    Log::error("❌ IG bike exception: " . $ex->getMessage());
                }
            } else {
                Log::warning("❌ No Instagram Business Account linked or no images found for bike post");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Facebook/Instagram Bike API Exception (outer): ' . $e->getMessage());
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


    public function getPosts($fbToken)
    {
        try {

            $localPosts = FacebookInstaPost::where('page_id', $fbToken->page_id)
                ->where('user_id', $fbToken->dealer_id)
                ->latest()
                ->get();

            $posts = [];

            foreach ($localPosts as $post) {
                $postData = [
                    'id'       => $post->id,
                    'type'     => $post->type,
                    'platform' => $post->platform,
                    'created_at' => $post->created_at,
                ];


                if ($post->platform === 'facebook' && $post->post_fbid) {
                    $response = Http::get("https://graph.facebook.com/v19.0/{$post->post_fbid}", [
                          'fields'       => 'id,message,created_time,permalink_url,full_picture',
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($response->successful()) {
                        $postData['data'] = $response->json();
                    } else {
                        Log::error("❌ Failed to fetch FB post {$post->post_fbid}: " . $response->body());
                        $postData['data'] = null;
                    }
                }


                if ($post->platform === 'instagram' && $post->ig_media_id) {
                    $response = Http::get("https://graph.facebook.com/v19.0/{$post->ig_media_id}", [
                        'fields'       => 'id,caption,media_type,media_url,permalink,timestamp',
                        'access_token' => $fbToken->page_access_token,
                    ]);

                    if ($response->successful()) {
                        $postData['data'] = $response->json();
                    } else {
                        Log::error("❌ Failed to fetch IG post {$post->ig_media_id}: " . $response->body());
                        $postData['data'] = null;
                    }
                }

                $posts[] = $postData;
            }

            return $posts;
        } catch (\Exception $e) {
            Log::error("❌ Error in getPosts(): " . $e->getMessage());
            return [];
        }
    }

    public function deleteFacebookPost($facebookToken, $postId)
    {
        $token = $facebookToken->page_access_token;

        $response = Http::delete("https://graph.facebook.com/v19.0/{$postId}", [
            'access_token' => $token,
        ]);

        if ($response->failed()) {
            Log::error('❌ FB post delete failed: ' . $response->body());
            throw new \Exception('Facebook post deletion failed');
        }

        Log::info("✅ Facebook post {$postId} deleted successfully.");
        return true;
    }

    public function deleteInstagramPost($facebookToken, $mediaId)
    {
        $token = $facebookToken->page_access_token;

        $response = Http::delete("https://graph.facebook.com/v19.0/{$mediaId}", [
            'access_token' => $token,
        ]);

        if ($response->failed()) {
            Log::error('❌ IG post delete failed: ' . $response->body());
            throw new \Exception('Instagram post deletion failed');
        }

        Log::info("✅ Instagram post {$mediaId} deleted successfully.");
        return true;
    }
}
