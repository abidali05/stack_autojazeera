<?php

namespace App\Http\Controllers\Api;

use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\User;
use Stripe\Customer;
use App\Mail\Welcome;
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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ServiceSubscriptions;
use App\Models\AutoServices\ServiceSubscriptionPlans;


class PaymentController extends Controller
{
    // public function processPayment(Request $request)
    // {


    //     if (!auth('sanctum')->check()) {
    //         return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
    //     }

    //     $user = auth('sanctum')->user();
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     try {
    //         // Validate request inputs
    //         $request->validate([
    //             'price_id' => 'required|string',
    //             'plan' => 'required|string',
    //             'stripeToken' => 'required|string',
    //             'amount' => 'required|numeric',
    //         ]);

    //         $dealer = DeallerSubscription::where('user_id', $user->id)->first();
    //         $price = Price::retrieve($request->price_id);
    //         $stripeProduct = Product::retrieve($request->plan);
    //         $isMatchingPlan = ($stripeProduct->id == $request->plan);

    //         $customer = $this->getOrCreateCustomer($user, $stripeProduct, $isMatchingPlan);

    //         // Create a Payment Intent for the charge
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $request->amount * 100, // Amount in cents
    //             'currency' => 'pkr',
    //             'customer' => $customer->id,
    //             'payment_method' => $request->stripeToken, // Use the PaymentMethod ID
    //             'off_session' => true, // Indicates that the payment is not initiated by the customer
    //             'confirm' => true, // Automatically confirm the Payment Intent
    //             'description' => 'Plan ' . $request->plan,
    //             'metadata' => [
    //                 'user_id' => $user->id,
    //                 'plan_id' => $request->plan,
    //                 'price' => $request->amount,
    //             ],
    //         ]);
    //         // Log::info($paymentIntent);

    //         $this->updateOrCreateDealerSubscription($dealer, $user, $request->plan, $stripeProduct);
    //         // $subscriptions = Subscription::all(['customer' => $customer->id]);

    //         // $subscription = Subscription::create([
    //         //     'customer' => $customer->id,
    //         //     'items' => [
    //         //         ['price' => $request->price_id], // Plan/price ID
    //         //     ],
    //         //     'metadata' => [
    //         //         'user_id' => $user->id,
    //         //         'plan_id' => $request->plan,
    //         //         'price' => $request->amount,
    //         //     ],
    //         // ]);

    //         $subscriptions = Subscription::all([
    //             'customer' => $customer->id,
    //             'status' => 'active'
    //         ]);

    //         if (count($subscriptions->data) > 0) {
    //             // Update the existing subscription
    //             $subscription = $subscriptions->data[0];

    //             $updatedSubscription = Subscription::update(
    //                 $subscription->id,
    //                 [
    //                     'items' => [
    //                         [
    //                             'id' => $subscription->items->data[0]->id, // Existing subscription item ID
    //                             'price' => $request->price_id, // New price/plan ID
    //                         ],
    //                     ],
    //                     'metadata' => [
    //                         'user_id' => $user->id,
    //                         'plan_id' => $request->plan,
    //                         'price' => $request->amount,
    //                     ],
    //                     'proration_behavior' => 'create_prorations', // Adjust billing for the upgrade
    //                 ]
    //             );


    //         } else {
    //             // Create a new subscription
    //             $newSubscription = Subscription::create([
    //                 'customer' => $customer->id,
    //                 'items' => [
    //                     ['price' => $request->price_id], // Plan/price ID
    //                 ],
    //                 'metadata' => [
    //                     'user_id' => $user->id,
    //                     'plan_id' => $request->plan,
    //                     'price' => $request->amount,
    //                 ],
    //             ]);


    //         }
    //         $user = auth('sanctum')->user();
    //         $user->package = $request->plan;
    //         if($user->dealershipName !=null) 
    //         {
    //             $user->role = 1;
    //         }
    //         $user->save();
    //         //$body = view('emails.subscription_buy');
    //    // sendMail($user->name, $user->email, 'Auto Jazeera', 'Your subscription has been changed', $body);
    // 		Mail::to($user->email)->send(new SubscriptionBuy());
    //         return response()->json(['status' => 200, 'message' => "Thanks for subscribing ! Your payment is confirmed, and you`re now part of our platform."], 200);
    //     } catch (\Exception $e) {
    // 		$user = auth('sanctum')->user();
    //         //$body = view('emails.billing_failure');
    //         //sendMail($user->name, $user->email, 'Auto Jazeera', 'Payment Failed', $body);
    // 		Mail::to($user->email)->send(new Billing_failure());
    //         Log::info($e->getMessage());
    //         return response()->json(['status' => 402, 'message' => $e->getMessage()], 402);
    //     }
    // }

    public function processPayment(Request $request)
    {
        Log::info('API Payment Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'cardName' => 'required|string',
            'plan_id' => 'required|string',
            'stripe_token' => 'required|string',
            'sub_type' => 'required|in:ads,service',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 422,
                'message' => "You are not authorized to access this route"
            ]);
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $user = auth('sanctum')->user();
            $product = \Stripe\Product::retrieve($request->plan_id);
            $priceId = $product->default_price;
            $customer = $this->getOrCreateCustomer($user);

            // Cancel existing subscriptions of same type
            $subscriptions = \Stripe\Subscription::all([
                'customer' => $customer->id,
                'status' => 'all',
                'limit' => 100,
            ]);

            foreach ($subscriptions->data as $sub) {
                if (
                    in_array($sub->status, ['active', 'trialing', 'past_due']) &&
                    ($sub->metadata['sub_type'] ?? null) === $request->sub_type
                ) {
                    $sub->cancel();
                }
            }

            // Attach and set default payment method
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->stripe_token);
            $paymentMethod->attach(['customer' => $customer->id]);

            \Stripe\Customer::update($customer->id, [
                'invoice_settings' => [
                    'default_payment_method' => $request->stripe_token,
                ],
            ]);

            // Trial logic
            $meta = $product->metadata;
            $trialAllowed = ($meta->trial_allowed ?? '0') === '1';
            $trialDaysKey = 'trial_days';
            $trialDaysValue = $meta->{$trialDaysKey} ?? $meta->{'trial_days '} ?? null;

            $isService = $request->sub_type === 'service';
            $userTrialEligible = $isService
                ? $user->shop_trial_availed == 0
                : $user->trial_availed == 0;

            $trialDays = $userTrialEligible && $trialAllowed && is_numeric($trialDaysValue)
                ? (int) $trialDaysValue
                : null;

            // Subscription creation
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

            // User model updates
            if ($isService) {
                if ($trialDays) $user->shop_trial_availed = 1;

                $user->shop_package = $request->plan_id;
                $shop = Shops::where('dealer_id', $user->id)->first();
                if ($shop) {
                    $shop->is_featured = ($meta->feature_allowed ?? '0') === '1' ? 1 : 0;
                    $shop->save();
                }
            } else {
                if ($trialDays) $user->trial_availed = 1;

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

            // Send response
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
                return response()->json([
                    'status' => 200,
                    'message' => "Thanks for subscribing! Your trial has started.",
                    'data' => $user
                ]);
            } else {
                Mail::to($user->email)->send(new SubscriptionBuy($product));
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

                return response()->json([
                    'status' => 200,
                    'message' => "You have successfully subscribed " . $product->name,
                    'data' => $user
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Stripe Payment Error: ' . $e->getMessage());

            if (isset($user)) {
                Mail::to($user->email)->send(new Billing_failure());

                if ($user->fcm_token) {
                    $fcm_tokens = [$user->fcm_token];
                    if ($fcm_tokens) {

                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Payment Failed', 'body' => 'Your payment has failed for ' . $product->name]);



                        Notifications::create([
                            'user_id' => $user->id,
                            'title' => 'Payment Failed',
                            'body' => 'Your payment has failed for ' . $product->name,
                            'url' => url('subscription'),
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 402,
                'message' => 'Payment failed',
                'error' => $e->getMessage()
            ], 402);
        }
    }

    public function signupwithfreeplan(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        if ($user->free_package_availed == '1') {
            return response()->json(['status' => 401, 'message' => "You have already availed free plan"]);
        }
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the free plan product and get default price
        $product = Product::retrieve(config('services.stripe.free_forever'));
        $priceId = $product->default_price;

        // Get or create Stripe customer
        $customer = $this->getOrCreateCustomer($user);

        // Cancel any previous active subscriptions
        $activeSubs = Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 10,
        ]);

        foreach ($activeSubs->data as $sub) {
            $sub->cancel();
        }

        // Create free subscription (Stripe allows $0/month plans)
        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items' => [
                ['price' => $priceId],
            ],
            'metadata' => [
                'user_id' => $user->id,
                'sub_type' => 'ads',
                'is_free_plan' => true,
            ]
        ]);

        // Update local user info
        $user->package = $product->id;
        $user->userType = $product->metadata['type'] ?? 'private_seller';
        $user->dealershipName = $product->metadata['type'] == 'private_seller' ? 'Private Seller' : '';
        $user->trial_availed = 1;
        $user->free_package_availed = 1;
        $user->role = 1;
        $user->save();

        Mail::to($user->email)->send(new SubscriptionBuy($product));


        $user = User::find($user->id);
        $user->free_package_availed = (int)$user->free_package_availed;

        return response()->json([
            "data" => $user,
            "token" => null,
            "message" => 'You have successfully subscribed to the free plan.',
            'status' => 200
        ], 200);
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
