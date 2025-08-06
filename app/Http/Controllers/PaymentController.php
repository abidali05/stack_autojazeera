<?php

namespace App\Http\Controllers;

use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\User;
use Stripe\Customer;
use App\Models\Shops;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Mail\TrialStarted;
use Illuminate\Http\Request;
use App\Mail\Billing_failure;
use App\Mail\SubscriptionBuy;
use App\Models\Notifications;
use App\Models\AdsSubscriptions;
use App\Jobs\SendFcmNotification;
use App\Models\DeallerSubscription;
use App\Models\SubscriptionHistory;
use GPBMetadata\Google\Api\Service;
use Illuminate\Support\Facades\Log;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\AutoServices\ServiceSubscriptions;
use App\Models\AutoServices\ServiceSubscriptionPlans;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        Log::info('Web Payment Request Data: ', $request->all());

        $request->validate([
            'cardName' => 'required|string',
            'plan_id' => 'required|string',
            'stripe_token' => 'required|string',
            'sub_type' => 'required|in:ads,service',
        ]);

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $user = Auth::user();
            $product = \Stripe\Product::retrieve($request->plan_id);
            $priceId = $product->default_price;
            $customer = $this->getOrCreateCustomer($user);

            // Cancel previous same-type subscriptions
            $subscriptions = \Stripe\Subscription::all([
                'customer' => $customer->id,
                'status' => 'all',
                'limit' => 100,
            ]);

            foreach ($subscriptions->data as $sub) {
                $subType = $sub->metadata['sub_type'] ?? null;
                if (
                    in_array($sub->status, ['active', 'trialing', 'past_due']) &&
                    $subType === $request->sub_type
                ) {
                    $sub->cancel();
                }
            }

            // Attach & set default payment method
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->stripe_token);
            $paymentMethod->attach(['customer' => $customer->id]);

            \Stripe\Customer::update($customer->id, [
                'invoice_settings' => ['default_payment_method' => $request->stripe_token],
            ]);

            // Trial Logic
            $meta = $product->metadata;
            $trialAllowed = ($meta->trial_allowed ?? '0') === '1';
            $trialDays = null;

            $days = $meta->trial_days ?? $meta->{'trial_days '} ?? null;
            $isService = $request->sub_type === 'service';
            $trialEligible = $isService ? $user->shop_trial_availed == 0 : $user->trial_availed == 0;

            if ($trialEligible && $trialAllowed && is_numeric($days)) {
                $trialDays = (int) $days;
            }

            // Create Subscription
            $subscriptionData = [
                'customer' => $customer->id,
                'items' => [['price' => $priceId]],
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'user_id' => $user->id,
                    'sub_type' => $request->sub_type,
                ],
                'collection_method' => 'charge_automatically',
            ];

            if ($trialDays) {
                $subscriptionData['trial_end'] = now()->addDays($trialDays)->timestamp;
            }

            $subscription = \Stripe\Subscription::create($subscriptionData);

            // Flag user trial status
            if ($trialDays) {
                if ($isService) $user->shop_trial_availed = 1;
                else $user->trial_availed = 1;
            }

            // Update User Package Info
            if ($isService) {
                $user->shop_package = $request->plan_id;

                $shop = Shops::where('dealer_id', $user->id)->first();
                if ($shop) {
                    $shop->is_featured = ($meta->feature_allowed ?? '0') === '1' ? 1 : 0;
                    $shop->save();
                }
            } else {
                $user->package = $request->plan_id;
                $user->role = 1;
                $user->free_package_availed = 1;

                if (($meta->type ?? '') === 'private_seller') {
                    $user->userType = 'private_seller';
                    $user->dealershipName = 'Private Seller';
                } else {
                    $user->userType = 'car_dealer';
                    $user->dealershipName = '';
                }
            }

            $user->save();

            // Email & Response
            if ($trialDays) {
                Mail::to($user->email)->send(new TrialStarted($product));
                if ($user->fcm_token) {
                    $fcm_tokens = [$user->fcm_token];
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Trial Started', 'body' => 'Your trial has started for ' . $product->name]);



                        Notifications::create([
                            'user_id' => $user->id,
                            'title' => 'Trial Started',
                            'body' => 'Your trial has started for ' . $product->name,
                            'url' => url('subscription'),
                        ]);
                    }
                }
                return back()->with('paymentresponse', 'Thanks for subscribing! Your trial has started.');
            } else {

                if ($user->fcm_token) {
                    $fcm_tokens = [$user->fcm_token];
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Subscribed Successfully', 'body' => 'You have successfully subscribed ' . $product->name]);



                        Notifications::create([
                            'user_id' => $user->id,
                            'title' => 'Subscribed Successfully',
                            'body' => 'You have successfully subscribed ' . $product->name,
                            'url' => url('subscription'),
                        ]);
                    }
                }
                Mail::to($user->email)->send(new \App\Mail\SubscriptionBuy($product));
                return back()->with('paymentresponse', 'You have successfully subscribed ' . $product->name);
            }
        } catch (\Exception $e) {
            Log::error('Stripe Payment Error: ' . $e->getMessage());

            try {
                Mail::to(Auth::user()->email)->send(new \App\Mail\Billing_failure());
                if (Auth::user()->fcm_token) {
                    $fcm_tokens = [Auth::user()->fcm_token];
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Payment Failed', 'body' => 'Your payment has failed for ' . $product->name]);



                        Notifications::create([
                            'user_id' => Auth::user()->id,
                            'title' => 'Payment Failed',
                            'body' => 'Your payment has failed for ' . $product->name,
                            'url' => url('subscription'),
                        ]);
                    }
                }
            } catch (\Throwable $mailError) {
                Log::error('Billing failure email not sent: ' . $mailError->getMessage());
            }

            return back()->with('paymentresponse', $e->getMessage());
        }
    }

    public function startTrial(Request $request)
    {
        Log::info('Start Trial Request Data: ', $request->all());

        $request->validate([
            'plan_id' => 'required|string',
            'sub_type' => 'required|in:ads,service',
        ]);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $user = Auth::user();
            $product = Product::retrieve($request->plan_id);
            $priceId = $product->default_price;
            $customer = $this->getOrCreateCustomer($user);

            // Verify trial eligibility
            $meta = $product->metadata;
            $trialAllowed = ($meta->trial_allowed ?? '0') === '1';
            $days = $meta->trial_days ?? $meta->{'trial_days '} ?? null;
            $isService = $request->sub_type === 'service';
            $trialEligible = $isService ? $user->shop_trial_availed == 0 : $user->trial_availed == 0;

            if (!$trialAllowed || !is_numeric($days) || !$trialEligible) {
                return back()->with('paymentresponse', 'You are not eligible for a trial or this plan does not offer a trial.');
            }

            $trialDays = (int) $days;

            // Cancel previous same-type subscriptions
            $subscriptions = Subscription::all([
                'customer' => $customer->id,
                'status' => 'all',
                'limit' => 100,
            ]);

            foreach ($subscriptions->data as $sub) {
                $subType = $sub->metadata['sub_type'] ?? null;
                if (
                    in_array($sub->status, ['active', 'trialing', 'past_due']) &&
                    $subType === $request->sub_type
                ) {
                    $sub->cancel();
                }
            }

            // Create Subscription with trial
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [['price' => $priceId]],
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'user_id' => $user->id,
                    'sub_type' => $request->sub_type,
                ],
                'collection_method' => 'charge_automatically',
                'trial_end' => now()->addDays($trialDays)->timestamp,
                'payment_behavior' => 'allow_incomplete',
            ]);

            // Flag user trial status
            if ($isService) {
                $user->shop_trial_availed = 1;
                $user->shop_package = $request->plan_id;
                $shop = Shops::where('dealer_id', $user->id)->first();
                if ($shop) {
                    $shop->is_featured = ($meta->feature_allowed ?? '0') === '1' ? 1 : 0;
                    $shop->save();
                }
            } else {
                $user->trial_availed = 1;
                $user->package = $request->plan_id;
                $user->role = 1;
                if (($meta->type ?? '') === 'private_seller') {
                    $user->userType = 'private_seller';
                    $user->dealershipName = 'Private Seller';
                } else {
                    $user->userType = 'car_dealer';
                    $user->dealershipName = '';
                }
            }

            $user->save();

            // Send notifications
            Mail::to($user->email)->send(new TrialStarted($product));
            if ($user->fcm_token) {
                $fcm_tokens = [$user->fcm_token];
                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, [
                    'title' => 'Trial Started',
                    'body' => 'Your trial has started for ' . $product->name,
                ]);
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Trial Started',
                    'body' => 'Your trial has started for ' . $product->name,
                    'url' => url('subscription'),
                ]);
            }

            return back()->with('paymentresponse', 'Thanks for subscribing! Your trial has started for ' . $product->name);
        } catch (\Exception $e) {
            Log::error('Start Trial Error: ' . $e->getMessage());
            return back()->with('paymentresponse', 'Failed to start trial: ' . $e->getMessage());
        }
    }

    private function getOrCreateCustomer($user)
    {
        $customers = Customer::all(['limit' => 10000]);
        foreach ($customers->data as $cust) {
            if ($cust->email === $user->email) {
                return $cust;
            }
        }

        return Customer::create([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }



    private function updateOrCreateDealerSubscription($dealer, $user, $plan, $stripeProduct)
    {
        $billingStart = Carbon::today();
        $billingEnd = $billingStart->copy()->addMonths($stripeProduct->metadata->month ?? 1);

        $previousSubscription = SubscriptionHistory::where('user_id', $user->id)->get();
        if ($previousSubscription) {
            foreach ($previousSubscription as $sub) {
                $sub->status = 0;
                $sub->update();
            }
        }


        if (!$dealer) {
            $dealer = new DeallerSubscription();
            $dealer->user_id = $user->id;
            $dealer->current_subscription = $plan;
            $dealer->billing_start = $billingStart;
            $dealer->billing_end = $billingEnd;
            $dealer->status = 1;
            $dealer->save();
        } else {
            if ($dealer->current_subscription != 'prod_RTgB3KyZygKo2I') {

                $remainingMonths = 0;

                if (Carbon::parse($dealer->billing_end)->gt(Carbon::today())) {
                    $remainingMonths = Carbon::parse($dealer->billing_end)->diffInMonths(Carbon::today());
                    // dd($remainingMonths);
                    $billingStart = Carbon::today();
                    $billingEnd = $billingStart->copy()->addMonths($remainingMonths + ($stripeProduct->metadata->month ?? 1));
                } else {
                    $billingStart = Carbon::today();
                    $billingEnd = $billingStart->copy()->addMonths($stripeProduct->metadata->month ?? 1);
                }
            }

            $dealer->current_subscription = $plan;
            $dealer->billing_start = $billingStart;
            $dealer->billing_end = $billingEnd;
            $dealer->status = 1;
            $dealer->update();
        }

        $newSubscription = new SubscriptionHistory();
        $newSubscription->user_id = $user->id;
        $newSubscription->current_subscription = $plan;
        $newSubscription->subscription_name = $stripeProduct->name;
        $newSubscription->subscription_description = $stripeProduct->metadata->title;
        $newSubscription->billing_start = $billingStart;
        $newSubscription->billing_end = $billingEnd;
        $newSubscription->regular_price = $stripeProduct->metadata->regular_price;
        $newSubscription->price = $stripeProduct->metadata->price;
        $newSubscription->status = 1;
        $newSubscription->save();

        // Update user's role and package
        $user->role = 1;
        $user->package = $stripeProduct->id;
        $user->update();
    }
}
