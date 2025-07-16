<?php

namespace App\Http\Controllers;

use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\User;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\DeallerSubscription;
use App\Models\SubscriptionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Billing_failure;
use App\Mail\SubscriptionBuy;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        try {
            // Validate incoming request
             $request->validate([
                 'price_id' => 'required|string',
                 'plan' => 'required|string',
                 'paymentMethodId' => 'required|string', // PaymentMethod ID from frontend
                 'amount' => 'required|numeric',
             ]);

            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve dealer subscription and Stripe product
            $dealer = DeallerSubscription::where('user_id', Auth::user()->id)->first();
            $price = Price::retrieve($request->price_id);
            $stripeProduct = Product::retrieve($request->plan);
           
            $isMatchingPlan = ($stripeProduct->id == $request->plan);

            // Retrieve or create Stripe customer
            $customer = $this->getOrCreateCustomer(Auth::user(), $stripeProduct, $isMatchingPlan);

            // Attach the PaymentMethod to the customer
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->paymentMethodId);
            $paymentMethod->attach(['customer' => $customer->id]);


            // Set default payment method for the customer
            Customer::update($customer->id, [
                'invoice_settings' => [
                    'default_payment_method' => $request->paymentMethodId,
                ],
            ]);

            // Create a Payment Intent to charge the customer immediately
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Convert amount to cents
                'currency' => 'pkr',
                'customer' => $customer->id,
                'payment_method' => $request->paymentMethodId,
                'off_session' => true, // Indicates that the payment is not initiated by the customer
                'confirm' => true, // Automatically confirm the Payment Intent
                'description' => 'Plan ' . $request->plan,
                'metadata' => [
                    'user_id' => Auth::user()->id,
                    'plan_id' => $request->plan,
                    'price' => $request->amount,
                ],
            ]);

            // $subscriptions = Subscription::all(['customer' => $customer->id]);
            // foreach ($subscriptions->data as $sub) {
            //     $sub->cancel();
            // }
            // // Create the subscription
            // $subscription = Subscription::create([
            //     'customer' => $customer->id,
            //     'items' => [
            //         ['price' => $request->price_id], // Plan/price ID
            //     ],
            //     'metadata' => [
            //         'user_id' => Auth::user()->id,
            //         'plan_id' => $request->plan,
            //         'price' => $request->amount,
            //     ],
            // ]);


            $subscriptions = Subscription::all([
                'customer' => $customer->id,
                'status' => 'active'
            ]);

            if (count($subscriptions->data) > 0) {
                // Update the existing subscription
                $subscription = $subscriptions->data[0];

                $updatedSubscription = Subscription::update(
                    $subscription->id,
                    [
                        'items' => [
                            [
                                'id' => $subscription->items->data[0]->id, // Existing subscription item ID
                                'price' => $request->price_id, // New price/plan ID
                            ],
                        ],
                        'metadata' => [
                            'user_id' => Auth::user()->id,
                            'plan_id' => $request->plan,
                            'price' => $request->amount,
                        ],
                        'proration_behavior' => 'create_prorations', // Adjust billing for the upgrade
                    ]
                );
            } else {
                // Create a new subscription
                $newSubscription = Subscription::create([
                    'customer' => $customer->id,
                    'items' => [
                        ['price' => $request->price_id], // Plan/price ID
                    ],
                    'metadata' => [
                        'user_id' => Auth::user()->id,
                        'plan_id' => $request->plan,
                        'price' => $request->amount,
                    ],
                ]);
            }
            // Update or create dealer subscription in the database
            $user = Auth::user();
            $this->updateOrCreateDealerSubscription($dealer, Auth::user(), $request->plan, $stripeProduct);
            //$body = view('emails.subscription_buy');
            //sendMail($user->name, $user->email, 'Auto Jazeera', 'Your subscription has been changed', $body);
			Mail::to($user->email)->send(new SubscriptionBuy());
            return back()->with('success', 'Thanks for subscribing ! Your payment is confirmed, and you`re now part of our platform.');
        } catch (\Exception $e) {
			$user = Auth::user();
            //$body = view('emails.billing_failure');
            //sendMail($user->name, $user->email, 'Auto Jazeera', 'Payment Failed', $body);
			Mail::to($user->email)->send(new Billing_failure());
            return back()->with('error', $e->getMessage());
        }
    }

    private function getOrCreateCustomer($user, $stripeProduct, $isMatchingPlan)
    {
        $existingCustomer = null;

        // Retrieve existing customers and filter by email
        $customers = Customer::all();
        foreach ($customers->data as $cust) {
            if ($cust->email === $user->email) {
                $existingCustomer = $cust;
                break;
            }
        }

        if ($existingCustomer) {
            // Update existing customer metadata
            return Customer::update($existingCustomer->id, [
                'name' => $user->name,
                'metadata' => [
                    'plan_id' => $stripeProduct->id,
                    'matching_plan' => $isMatchingPlan ? 'yes' : 'no',
                ],
            ]);
        } else {
            // Create a new customer
            return Customer::create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
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
            if($dealer->current_subscription != 'prod_RTgB3KyZygKo2I') {
               
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
