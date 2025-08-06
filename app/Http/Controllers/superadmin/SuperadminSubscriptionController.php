<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdsSubscriptions;
use App\Models\DeallerSubscription;
use App\Http\Controllers\Controller;
use App\Mail\SubscriptionEndedadmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ServiceSubscriptions;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Product;

class SuperadminSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user_id) {
            $subscriptions = DeallerSubscription::where('user_id', $request->user_id)->orderBy('id', 'DESC')->paginate(25);
        } else {
            $subscriptions = DeallerSubscription::orderBy('id', 'DESC')->paginate(25);
        }

        return view('superadmin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            // 'dealer' => 'required|max:255',
            'dealershipName' => 'required',
            //'current_subscription' => 'required',
            'billing_start' => 'required',
            'billing_end' => 'required',




        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $subscription = DeallerSubscription::find($id);
        if ($request->current_subscription) {
            $subscription->previous_subscription = $subscription->current_subscription;
        }
        $subscription->user_id = $request->dealershipName;
        //$subscription->current_subscription=$request->current_subscription;
        $subscription->billing_start = $request->billing_start;
        $subscription->billing_end = $request->billing_end;
        $subscription->update();
        return redirect()->back()->with('warning', 'subscription data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = DeallerSubscription::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger', 'Data Deleted Successfully');
    }
    public function updatestatus(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|boolean',
        ]);

        $subscriptions = DeallerSubscription::find($id);
        $subscriptions->status = $request->status;
        $subscriptions->update();

        // If there are subscriptions, update the status of associated users

        $userId = $subscriptions->user_id; // Adjust the field name as necessary

        // Update the status of those users to 'inactive'
        // User::where('id', $userId)->where('status', 'active')->update(['status' => 'inactive']);
        $data = User::find($userId);
        if ($data->status == 'inactive') {
            // $data->status='active';
            $data->role = 1;
            $data->update();
            User::where('dealer_id', $userId)->where('status', 'inactive')->update(['status' => 'active']);
        } else {
            $data->status = 0;
            $data->update();
            User::where('dealer_id', $userId)->where('status', 'active')->update(['status' => 'inactive']);
        }
        // $user = User::find($userId);
        if ($data) {
            Mail::to($data->email)->send(new SubscriptionEndedadmin($data));
        }
    }



    public function ads_subscriptions()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $users = User::where('role', 1)->get();
        $userSubscriptions = [];

        foreach ($users as $user) {
            $customer = $this->getExistingCustomer($user->email);
            if (!$customer) continue;

            $subscriptions = Subscription::all([
                'customer' => $customer->id,
                'status' => 'active',
                'limit' => 100,
                // 'expand' => ['data.items.data.price.product']
            ])->data;

            $adsSubscriptions = [];

            foreach ($subscriptions as $sub) {
                if (($sub->metadata['sub_type'] ?? null) === 'ads') {
                    $item = $sub->items->data[0];
                    $product = Product::retrieve($item->price->product);

                    $adsSubscriptions[] = [
                        'id' => $sub->id,
                        'product_name' => $product->name ?? 'Unknown',
                        'start_date' => date('Y-m-d', $sub->start_date),
                        'end_date' => date('Y-m-d', $sub->current_period_end),
                        'status' => $sub->status,
                    ];
                }
            }

            if (!empty($adsSubscriptions)) {
                $userSubscriptions[] = [
                    'user' => $user,
                    'subscriptions' => $adsSubscriptions
                ];
            }
        }

        return view('superadmin.subscription.ads_subscriptions', compact('userSubscriptions'));
    }


    public function superadminActiveServiceSubscriptions()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $users = User::all();
        $userSubscriptions = [];

        foreach ($users as $user) {
            $customer = $this->getExistingCustomer($user->email);
            if (!$customer) continue;

            $subscriptions = Subscription::all([
                'customer' => $customer->id,
                'status' => 'active',
                'limit' => 100,
                'expand' => ['data.items.data.price.product']
            ])->data;

            $serviceSubscriptions = [];

            foreach ($subscriptions as $sub) {
                if (($sub->metadata['sub_type'] ?? null) === 'service') {
                    $item = $sub->items->data[0];
                    $product = $item->price->product;

                    $serviceSubscriptions[] = [
                        'id' => $sub->id,
                        'product_name' => $product->name ?? 'Unknown',
                        'start_date' => date('Y-m-d', $sub->start_date),
                        'end_date' => date('Y-m-d', $sub->current_period_end),
                        'status' => $sub->status,
                    ];
                }
            }

            if (!empty($serviceSubscriptions)) {
                $userSubscriptions[] = [
                    'user' => $user,
                    'subscriptions' => $serviceSubscriptions
                ];
            }
        }

        return view('superadmin.subscriptions.service', compact('userSubscriptions'));
    }


    private function getExistingCustomer($email)
    {
        try {
            $customers = \Stripe\Customer::all(['limit' => 100]);

            foreach ($customers->autoPagingIterator() as $customer) {
                if ($customer->email === $email) {
                    return $customer;
                }
            }

            return null;
        } catch (\Exception $e) {
            // Optionally log the error
            // \Log::error('Stripe customer fetch failed: ' . $e->getMessage());
            return null;
        }
    }



    // public function ads_subscriptions()
    // {

    //     \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    //     $ads_invoices = [];
    //     $service_invoices = [];
    //     $ads_product_ids = [];
    //     $service_product_ids = [];
    //     $subscriptions = [];

    //     // Get all subscriptions (limit can be increased up to 100, use pagination for more)
    //     $allSubscriptions = \Stripe\Subscription::all([
    //         'limit' => 100,
    //         'expand' => ['data.customer']
    //     ])->data;

    //     foreach ($allSubscriptions as $subscription) {
    //         $subscriptionId = $subscription->id;
    //         $subscriptions[$subscriptionId] = $subscription;
    //         $type = $subscription->metadata['sub_type'] ?? null;

    //         // Get related invoice(s) for this subscription
    //         try {
    //             $invoices = \Stripe\Invoice::all([
    //                 'subscription' => $subscriptionId,
    //                 'limit' => 100,
    //                 'expand' => ['data.lines.data.price']
    //             ])->data;
    //         } catch (\Exception $e) {
    //             continue;
    //         }

    //         foreach ($invoices as $invoice) {
    //             foreach ($invoice->lines->data as $line) {
    //                 $productId = $line->price->product ?? null;

    //                 if ($productId) {
    //                     if ($type === 'ads') {
    //                         $ads_product_ids[] = $productId;
    //                         $ads_invoices[] = $invoice;
    //                     } elseif ($type === 'service') {
    //                         $service_product_ids[] = $productId;
    //                         $service_invoices[] = $invoice;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Get product info
    //     $all_product_ids = array_unique(array_merge($ads_product_ids, $service_product_ids));
    //     $products = [];

    //     foreach ($all_product_ids as $productId) {
    //         try {
    //             $products[$productId] = \Stripe\Product::retrieve($productId);
    //         } catch (\Exception $e) {
    //             $products[$productId] = (object)['name' => 'Unknown Plan'];
    //         }
    //     }

    //     return view('superadmin.subscription.ads_subscriptions', compact(
    //         'ads_invoices',
    //         'service_invoices',
    //         'products',
    //         'subscriptions'
    //     ));
    // }


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


    public function service_subscriptions()
    {
        $subscriptions = ServiceSubscriptions::with(['plan', 'user'])->paginate(25);
        return view('superadmin.subscription.service_subscriptions', compact('subscriptions'));
    }
}
