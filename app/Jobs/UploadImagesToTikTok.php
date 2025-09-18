<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadImagesToTikTok implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $images;      // array of public URLs
    protected $title;
    protected $accessToken;

    public function __construct(array $images, string $title, string $accessToken)
    {
        $this->images = $images;
        $this->title = $title;
        $this->accessToken = $accessToken;
    }

    public function handle()
    {
        try {
            if (!count($this->images)) {
                Log::warning("No images provided for TikTok upload.");
                return;
            }

            // TikTok requires PUBLIC URLs
            $postData = [
                'post_info' => [
                    'title' => $this->title,
                    'description' => $this->title . " #cars #forsale", // optional
                    'privacy_level' => 'PUBLIC_TO_EVERYONE',
                    'disable_comment' => false,
                    'auto_add_music' => true,
                ],
                'source_info' => [
                    'source' => 'PULL_FROM_URL',
                    'photo_cover_index' => 1,
                    'photo_images' => $this->images, // must be public URLs
                ],
                'post_mode' => 'DIRECT_POST',
                'media_type' => 'PHOTO',
            ];

            $response = Http::withToken($this->accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://open.tiktokapis.com/v2/post/publish/content/init/', $postData);

            if ($response->successful()) {
                Log::info("✅ TikTok photo post created successfully: " . $response->body());
            } else {
                Log::error("❌ TikTok photo post failed: " . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('UploadImagesToTikTok job failed: ' . $e->getMessage());
        }
    }
}
