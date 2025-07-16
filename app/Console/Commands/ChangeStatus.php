<?php

namespace App\Console\Commands;

use App\Mail\GraceSubscriptionEnded;
use App\Mail\SubscriptionEnded;
use App\Models\DeallerSubscription;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status of users and send notifications for expired subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get subscriptions that expired yesterday
        $subscriptions = DeallerSubscription::where('billing_end', Carbon::yesterday())->get();

        // Get subscriptions that expired more than a week ago
        $expiredSubscriptions = DeallerSubscription::where('billing_end', '<=', Carbon::now()->subWeek())->get();

        // Handle expired subscriptions
        if ($expiredSubscriptions->isNotEmpty()) {
            $userIds1 = $expiredSubscriptions->pluck('user_id');

            // Update the status of posts and users
            Post::whereIn('dealer_id', $userIds1)->where('status', 1)->update(['status' => 0]);
          //  User::whereIn('id', $userIds1)->where('status', 'active')->update(['status' => 'inactive']);

            // Queue emails for expired subscriptions
            foreach ($userIds1 as $userId) {
                $user = User::find($userId);
				
                if ($user && $user->status == 'active') {
					 $user->status = 'inactive';
                $user->save();
				$body = view('emails.GraceSubscriptionEnded');
          sendMail($user->name, $user->email, 'Auto Jazeera', 'Subscription Expired', $body);
                    // Dispatch queued job for email
                    dispatch(new \App\Jobs\SendEmailJob(new GraceSubscriptionEnded($user), $user->email));
                }
            }
        }

        // Handle subscriptions that expired yesterday
        if ($subscriptions->isNotEmpty()) {
            $userIds = $subscriptions->pluck('user_id');

            // Queue emails for subscriptions expired yesterday
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    // Dispatch queued job for email
                    dispatch(new \App\Jobs\SendEmailJob(new SubscriptionEnded($user), $user->email));
                }
            }

            $this->info('Status changed successfully and emails queued for ' . $userIds->count() . ' users!');
        } else {
            $this->info('No subscriptions found with billing_end yesterday.');
        }
    }
}
