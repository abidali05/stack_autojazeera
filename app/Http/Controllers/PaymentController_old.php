<?php

namespace App\Http\Controllers;

use App\Models\DeallerSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Product;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Subscription;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {

        return view('payment');
    }

    public function processPayment(Request $request)
    {
        // dd($request);
        // Set Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));
        // switch ($request->plan) {
        //     case 1:
        //         $amount = 0;
        //         break;
        //     case 2:
        //         $amount = 9000;
        //         break;
        //     case 3:
        //         $amount = 21000;
        //         break;
        //     case 4:
        //         $amount = 99000;
        //         break;
        //     default:
        //         $amount = 0; // Optional: Handle cases where $request->plan doesn't match any condition
        //         break;
        // }

        // Process the payment
        try {
            $dealer = DeallerSubscription::where('user_id', Auth::user()->id)->first();
            $price = \Stripe\Price::retrieve($request->price_id);
            // dd($price);
            $stripeProduct = Product::retrieve($request->plan); // Ensure $request->product_id is passed
            // dd($stripeProduct->metadata->months);
            // Validate that the product matches the plan
            $isMatchingPlan = ($stripeProduct->id == $request->plan);

            // Create a Stripe Customer
            // $customer = Customer::create([
            //     'name' => Auth::user()->name,
            //     'email' => Auth::user()->email,
            //     'source' => $request->stripeToken,
            //     'metadata' => [
            //         'plan_id' =>  $request->plan,
            //         'product_id' => $stripeProduct->id,
            //         'matching_plan' => $isMatchingPlan ? 'yes' : 'no', // Metadata to indicate plan-product match
            //     ],
            // ]);


            $existingCustomer = null;

            // Retrieve existing customers and filter by email
            $customers = Customer::all(['limit' => 100]);
            foreach ($customers->data as $cust) {
                if ($cust->email === Auth::user()->email) {
                    $existingCustomer = $cust;
                    break;
                }
            }

            if ($existingCustomer) {
                // Update existing customer metadata
                $customer = Customer::update(
                    $existingCustomer->id,
                    [
                        'name' => Auth::user()->name,
                        'metadata' => [
                            'plan_id' => $request->plan,
                            'product_id' => $stripeProduct->id,
                            'matching_plan' => $isMatchingPlan ? 'yes' : 'no',
                        ],
                    ]
                );
            } else {
                // Create a new customer if not found
                $customer = Customer::create([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'source' => $request->stripeToken,
                    'metadata' => [
                        'plan_id' => $request->plan,
                        'product_id' => $stripeProduct->id,
                        'matching_plan' => $isMatchingPlan ? 'yes' : 'no',
                    ],
                ]);
            }

            $subscription = Subscription::create([
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
            // Create a charge for the customer
            $charge = Charge::create([
                'amount' => $request->amount, // Amount in cents
                'currency' => 'pkr',
                'customer' => $customer->id, // Use the customer ID from the above step
                'description' => 'Plan ' . $request->plan,

            ]);
            // dd($charge);
            if (!$dealer) {
                $dealer = new DeallerSubscription();
                $dealer->user_id = Auth::user()->id;
                $dealer->current_subscription = $request->plan;
                $dealer->billing_start = Carbon::today();
                   $dealer->billing_end=Carbon::today()->addMonths($stripeProduct->metadata->months);
                // $dealer->billing_end = Carbon::tomorrow();
                $dealer->status = 1;
                $dealer->save();
                $u = User::find(Auth::user()->id);
                $u->role = 1;
                $u->package = $stripeProduct->id;
                $u->update();

                return back()->with('success', 'Payment Successful! and Subscribed');
            } else {
                $dealer->current_subscription = $request->plan;
                $dealer->billing_start = Carbon::today();
                $dealer->billing_end=Carbon::today()->addMonths($stripeProduct->metadata->months);
                // $dealer->billing_end = Carbon::tomorrow();
                $dealer->status = 1;
                $dealer->update();
                $u = User::find(Auth::user()->id);
                $u->package = $stripeProduct->id;
                $u->role = 1;
                $u->update();
                return back()->with('success', 'Payment Successful! and Subscription updated');
            }
            $body = view('emails.subscription_buy');
             sendMail($u->name, $u->email, 'Auto Jazera', 'Plan Subscribed Successfully', $body);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
