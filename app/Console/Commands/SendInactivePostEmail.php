<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\InactivePostEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendInactivePostEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly emails to users with inactive posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereHas('posts', function ($query) {
            $query->where('status', 0);
        })->get();

        foreach ($users as $user) {
            $posts = $user->posts()
                ->where('status', 0)
                ->get()
				->map(function ($post) {
						$mainDoc = $post->document->first() ?? null;
						$post->setAttribute('image', $mainDoc ? asset('posts/doc/' . $mainDoc->doc_name) : asset('web/images/default-car.jpg'));
						$post->setAttribute('mileage_icon', 'bi bi-speedometer2');
						$post->setAttribute('transmission_icon', 'bi bi-car-front-fill');
						$post->setAttribute('fuel_icon', 'bi bi-fuel-pump-diesel');
                    return $post;
                });

            if ($posts->isNotEmpty()) {
                    Mail::to($user->email)->send(new InactivePostEmail($user, $posts));
                    $this->info("Inactive posts email sent to {$user->email}");
            }
        }

        $this->info('Weekly inactive posts email process completed!');
    }
}
