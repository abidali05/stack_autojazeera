<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Models\Bike\BikePost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyInactiveAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:inactive-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users about their inactive ads weekly.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch users with inactive ads
        $usersWithInactiveAds = Post::where('status', 0)->pluck('dealer_id')->unique()->toArray();
        $userswithinactivebikeads = BikePost::where('status', 0)->pluck('dealer_id')->unique()->toArray();
       

        if (empty($usersWithInactiveAds)) {
            $this->info('No inactive ads found to notify.');
            return;
        }

        $users = User::whereIn('id', $usersWithInactiveAds)->get();

        if ($users->isEmpty()) {
            $this->info('No users found with inactive ads.');
            return;
        }

        foreach ($users as $user) {
            $posts = Post::where('dealer_id', $user->id)->where('status', 0)->get();
            // Render email content using a Blade view
            $body = view('emails.inactive_ads', compact('posts'));

            // Send email using your custom sendmail function
            sendmail($user->name, $user->email, 'Auto Jazera Notification', 'Inactive Ads Notification', $body);

            $this->info("Notification sent to user: {$user->email} about their inactive ads.");
        }
        if(empty($userswithinactivebikeads)){
            $this->info('No inactive bike ads found to notify.');
            return;
        }
        $users = User::whereIn('id', $userswithinactivebikeads)->get();

        if ($users->isEmpty()) {
            $this->info('No users found with inactive bike ads.');
            return;
        }
        foreach ($users as $user) {
            $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where('dealer_id', $user->id)->where('status', 0)->get();
            // Render email content using a Blade view
            $body = view('emails.bikes.inactive_ads', compact('posts'));

            // Send email using your custom sendmail function
            sendmail($user->name, $user->email, 'Auto Jazera Notification', 'Inactive Bike Ads Notification', $body);

            $this->info("Notification sent to user: {$user->email} about their inactive bike ads.");
        }

        $this->info('Notifications for inactive ads have been sent successfully.');
    }
}
