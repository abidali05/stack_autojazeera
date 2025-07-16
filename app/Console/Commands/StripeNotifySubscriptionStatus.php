<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\User;
use Stripe\Customer;
use Stripe\Subscription;
use App\Models\Notifications;
use Illuminate\Console\Command;
use App\Jobs\SendFcmNotification;
use Illuminate\Support\Facades\Log;

class StripeNotifySubscriptionStatus extends Command
{
    protected $signature = 'stripe:notify-subscription-status';
    protected $description = 'Notify users about subscription status dynamically based on hours/days left';

    public function handle()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $users = User::all();

        foreach ($users as $user) {
            $customer = $this->getStripeCustomerByEmail($user->email);
            if (!$customer) continue;

            // ----------- Trial Subscriptions ----------- //
            $trialSubs = Subscription::all([
                'customer' => $customer->id,
                'status' => 'trialing',
                'limit' => 10,
            ]);

            foreach ($trialSubs->data as $sub) {
                if (empty($sub->trial_start) || empty($sub->trial_end)) continue;

                $trialStart = Carbon::createFromTimestamp($sub->trial_start);
                $trialEnd = Carbon::createFromTimestamp($sub->trial_end);

                $totalTrialSeconds = $trialEnd->timestamp - $trialStart->timestamp;
                $secondsPassed = now()->timestamp - $trialStart->timestamp;
                $percentPassed = ($secondsPassed / $totalTrialSeconds) * 100;
                $hoursLeft = now()->diffInHours($trialEnd, false);

                $subType = $sub->metadata['sub_type'] ?? 'unknown';
                $plan = Product::retrieve($sub->items->data[0]->plan->product);
                $plan_name = $plan->name ?? 'Auto Jazera Subscription';
                $trial_end_date = $trialEnd->toFormattedDateString();
                $amount = $sub->items->data[0]->price->unit_amount / 100;

                // Midpoint logic
                if ($percentPassed >= 50 && $percentPassed < 52) {
                    $body = view('emails.mid_trial', compact('user', 'plan_name', 'trial_end_date'))->render();
                    sendMail($user->name, $user->email, 'Auto Jazera Notification', ucfirst($subType) . ' Trial Halfway Done', $body);

                    if ($user->fcm_token) {
                        $fcm_tokens = [$user->fcm_token];
                        if ($fcm_tokens) {

                            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Auto Jazera Notification', 'body' => 'Trial Expires in 15 Days for ' . $plan->name]);



                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Auto Jazera Notification',
                                'body' => 'Trial Expires in 15 Days for ' . $plan->name,
                                'url' => url('subscription'),
                            ]);
                        }
                    }
                    Log::info("Midpoint email sent to {$user->email} for $subType");
                }

                // Ending within 24 hours
                if ($hoursLeft <= 6 && $hoursLeft > 0) {
                    $body = view('emails.one_day_left', compact('user', 'plan_name', 'trial_end_date', 'amount'))->render();
                    sendMail($user->name, $user->email, 'Auto Jazera Notification', ucfirst($subType) . ' Trial Ending Soon', $body);

                    if ($user->fcm_token) {
                        $fcm_tokens = [$user->fcm_token];
                        if ($fcm_tokens) {

                            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Auto Jazera Notification', 'body' => 'Trial Expires in '. $hoursLeft.' Hours']);



                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Auto Jazera Notification',
                                'body' => 'Trial Expires in '. $hoursLeft.' Hours',
                                'url' => url('subscription'),
                            ]);
                        }
                    }


                    Log::info("Trial ending soon (<=18h) email sent to {$user->email} for $subType");
                }
            }

            // ----------- Active Subscriptions ----------- //
            $activeSubs = Subscription::all([
                'customer' => $customer->id,
                'status' => 'active',
                'limit' => 10,
            ]);

            foreach ($activeSubs->data as $sub) {
                if (empty($sub->current_period_end)) continue;

                $periodEnd = Carbon::createFromTimestamp($sub->current_period_end);
                $hoursLeft = now()->diffInHours($periodEnd, false);

                $subType = $sub->metadata['sub_type'] ?? 'unknown';
                $plan = Product::retrieve($sub->items->data[0]->plan->product);
                $plan_name = $plan->name ?? 'Auto Jazera Subscription';
                $expiry_date = $periodEnd->toFormattedDateString();
                $amount = $sub->items->data[0]->price->unit_amount / 100;

                // 7 days left (168 hours)
                if ($hoursLeft <= 168 && $hoursLeft > 144) {
                    $body = view('emails.week_before_sub_expiry', compact('user', 'plan_name', 'expiry_date', 'amount'))->render();
                    sendMail($user->name, $user->email, 'Auto Jazera Notification', ucfirst($subType) . ' Subscription - 1 Week Left', $body);
                    Log::info("7-day notice email sent to {$user->email} for $subType");

                    if ($user->fcm_token) {
                        $fcm_tokens = [$user->fcm_token];
                        if ($fcm_tokens) {

                            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Auto Jazera Notification', 'body' => 'Subscription Expires in 1 Week for ' . $plan->name]);



                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Auto Jazera Notification',
                                'body' => 'Subscription Expires in 1 Week for ' . $plan->name,
                                'url' => url('subscription'),
                            ]);
                        }
                    }
                }

                // 1 day left (<= 24h)
                if ($hoursLeft <= 24 && $hoursLeft > 0) {
                    $body = view('emails.one_day_left', compact('user', 'plan_name', 'expiry_date', 'amount'))->render();
                    sendMail($user->name, $user->email, 'Auto Jazera Notification', ucfirst($subType) . ' Subscription Ending Soon', $body);

                    if ($user->fcm_token) {
                        $fcm_tokens = [$user->fcm_token];
                        if ($fcm_tokens) {

                            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Auto Jazera Notification', 'body' => 'Subscription Expires in 1 Day for ' . $plan->name]);



                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Auto Jazera Notification',
                                'body' => 'Subscription Expires in 1 Day for ' . $plan->name,
                                'url' => url('subscription'),
                            ]);
                        }
                    }

                    Log::info("1-day notice email sent to {$user->email} for $subType");
                }

                // Expired (0 or less)
                if ($hoursLeft <= 0) {
                    $body = view('emails.sub_expired', compact('user', 'plan_name', 'expiry_date', 'amount'))->render();
                    sendMail($user->name, $user->email, 'Auto Jazera Notification', ucfirst($subType) . ' Subscription Expired', $body);

                    if ($user->fcm_token) {
                        $fcm_tokens = [$user->fcm_token];
                        if ($fcm_tokens) {

                            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Auto Jazera Notification', 'body' => 'Subscription Expired for ' . $plan->name]);



                            Notifications::create([
                                'user_id' => $user->id,
                                'title' => 'Auto Jazera Notification',
                                'body' => 'Subscription Expired for ' . $plan->name,
                                'url' => url('subscription'),
                            ]);
                        }
                    }


                    Log::info("Expired email sent to {$user->email} for $subType");
                }
            }
        }
    }

    private function getStripeCustomerByEmail($email)
    {
        $customers = Customer::all(['email' => $email, 'limit' => 1]);
        return $customers->data[0] ?? null;
    }
}
