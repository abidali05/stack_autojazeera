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

        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $user = Auth::user();

        Stripe::setApiKey(config('services.stripe.secret'));

        $product = Product::retrieve($request->plan_id);
        $priceId = $product->default_price;
        $meta = $product->metadata ?? [];

        // Extract trial days from metadata
        // $trialDays = isset($meta->trial_days) ? (int) trim($meta->trial_days) : 0;
        // $trialAllowed = $trialDays > 0;

        // $trialAllowed = ($meta->trial_allowed ?? '0') === '1';
        // $trialDays = null;

        // $days = $meta->trial_days ?? $meta->{'trial_days '} ?? null;

        $isService = $request->sub_type === 'service';
        $trialEligible = $isService ? $user->shop_trial_availed == 0 : $user->trial_availed == 0;

        if (!$trialEligible) {
            return back()->with('paymenterror', 'You are not eligible for this subscription.');
        }

        // Get or create Stripe customer
        $customer = $this->getOrCreateCustomer($user);

        // Cancel all previous active subscriptions
        $activeSubs = Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 100,
        ]);

        if ($activeSubs) {
            foreach ($activeSubs->data as $sub) {
                if (isset($sub->metadata['sub_type']) && $sub->metadata['sub_type'] === $request->sub_type) {
                    $sub->cancel();
                }
            }
            
        }

        $subscription = null;
        // CASE 1: Ads Subscription Trial
        // if ($request->sub_type === 'ads' && $trialAllowed && $user->trial_availed == 0) {
        if ($request->sub_type === 'ads' && $user->trial_availed == 0) {

            // $subscription = Subscription::create([
            //     'customer' => $customer->id,
            //     'items' => [['price' => $priceId]],
            //     'trial_end' => now()->addDays($trialDays)->timestamp,
            //     'metadata' => [
            //         'user_id' => $user->id,
            //         'sub_type' => 'ads',
            //         'is_trial' => true,
            //     ],
            // ]);

            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [['price' => $priceId],],
                'metadata' => [
                    'user_id' => $user->id,
                    'sub_type' => 'ads',
                    'is_free_plan' => true,
                ]
            ]);

            $user->package = $product->id;
            $user->trial_availed = 1;
            $user->role = 1;

            if (($meta->type ?? '') === 'private_seller') {
                $user->userType = 'private_seller';
                $user->dealershipName = 'Private Seller';
            } else {
                $user->userType = 'car_dealer';
                $user->dealershipName = '';
            }
        }

        // CASE 2: Service Subscription Trial
        elseif ($request->sub_type === 'service' && $user->shop_trial_availed == 0) {

            // $subscription = Subscription::create([
            //     'customer' => $customer->id,
            //     'items' => [['price' => $priceId]],
            //     'trial_end' => now()->addDays($trialDays)->timestamp,
            //     'metadata' => [
            //         'user_id' => $user->id,
            //         'sub_type' => 'service',
            //         'is_trial' => true,
            //     ],
            // ]);

            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => $priceId],
                ],
                'metadata' => [
                    'user_id' => $user->id,
                    'sub_type' => 'service',
                    'is_free_plan' => true,
                ]
            ]);


            $user->shop_package = $product->id;
            $user->shop_trial_availed = 1;
        }

        // Save updated user info
        $user->save();

        // Send email confirmation
        Mail::to($user->email)->send(new SubscriptionBuy($product));

        if ($subscription) {
            return back()->with('paymentresponse', 'You have successfully subscribed to ' . $product->name);
        } else {
            return back()->with('paymenterror', 'There was a problem subscribing to ' . $product->name . '. Please try again or contact support.');
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
}
