<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Post;
use App\Models\User;
use App\Models\Bike\BikePost;
use App\Mail\MonthlyPostEmail;
use App\Mail\bikes\MonthlyBikePostEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyPostEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:monthly-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly posts to users based on their city';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNotNull('city')->get();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $users = User::whereHas('posts', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear);
        })->get();

        foreach ($users as $user) {
            $posts = $user->posts()
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->get()
                ->map(function ($post) {
                    $mainDoc = $post->document->first() ?? null;
                    $post->setAttribute('image', $mainDoc ? asset('posts/doc/' . $mainDoc->doc_name) : asset('web/images/default-car.jpg'));
                    $post->setAttribute('mileage_icon', 'bi bi-speedometer2');
                    $post->setAttribute('transmission_icon', 'bi bi-car-front-fill');
                    $post->setAttribute('fuel_icon', 'bi bi-fuel-pump-diesel');
                    return $post;
                });
            // dd($posts);
            if ($posts->isNotEmpty()) {
                Mail::to($user->email)->send(new MonthlyPostEmail($user, $posts));
            }
        }

        $this->info('Monthly emails sent successfully!');

        // monthly bikes posts emails
        $users = User::whereNotNull('city')->get();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        foreach ($users as $user) {

            $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->whereHas('location', function ($query) use ($user) {
                    $query->where('city', $user->city);
                })
                ->where('status', 1)
                ->get();

            if ($posts->isNotEmpty()) {
                $body = view('emails.bikes.monthly_post', compact('posts','user'));
                sendMail($user->name, $user->email, 'Auto Jazeera', 'Latest Bike Ads', $body);
                // Mail::to($user->email)->send(new MonthlyBikePostEmail($user, $posts));
            }
            $this->info("Monthly bike posts email sent to user: {$user->email}");
        }

        $this->info('Monthly emails sent successfully!');

    }
}
