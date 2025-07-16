<?php

namespace App\Http\Controllers\User;

use Stripe\Price;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Product;
use App\Models\Card;
use App\Models\Post;
use App\Models\User;
use Stripe\Customer;
use App\Mail\Welcome;
use App\Models\Shops;
use App\Models\State;
use App\Models\Provence;
use App\Models\Province;

use Stripe\Subscription;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Mail\SubscriptionBuy;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Models\AdsSubscriptions;
use App\Jobs\SendFcmNotification;
use App\Models\DeallerSubscription;
use App\Models\SubscriptionHistory;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use App\Models\AutoServices\ServiceSubscriptions;
use App\Models\AutoServices\ServiceSubscriptionPlans;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // $users=User::orderby('id','desc')->where('role',2)->get();


    //     // return view('superadmin.Dealer_user.index',compact('users'));
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     // Retrieve all products
    //     $products = Product::all(['limit' => 4]);
    //     // dd($products);  
    //     $productData = $products->data;

    //     // Sort the product data array by 'id' in ascending order
    //     usort($productData, function ($a, $b) {
    //         $idA = $a->metadata->id ?? null;
    //         $idB = $b->metadata->id ?? null;

    //         // Compare as integers if the IDs exist, otherwise as strings
    //         return intval($idA) <=> intval($idB);
    //     });

    //     foreach ($productData as $product) {
    //         // Fetch associated prices
    //         $product->prices = Price::all(['product' => $product->id]);

    //         // If no prices exist, set it to an empty array (to avoid null)
    //         if (is_null($product->prices)) {
    //             $product->prices = [];
    //         }
    //     }
    //     $products = $productData;
    //     $card = Card::where('user_id', Auth::user()->id)->first();
    //     $subscription = DeallerSubscription::where('user_id', Auth::user()->id)->first();
    //     return view('user.subscription.index', compact('subscription', 'products'));
    // }


    public function index()
    {
        if (Auth::user()->role == '2' || Auth::user()->role == '3' || Auth::user()->dealer_id != null) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        }
        // $ads_plans = AdsSubscriptionPlans::with('features')->where('status', '1')->get();
        // $service_plans = ServiceSubscriptionPlans::with('features')->where('status', '1')->get();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve all products
        $products = Product::all([
            'limit' => 100,
            'active' => true
        ]);

        $carDealers = [];
        $privateSellers = [];
        $services = [];

        foreach ($products->data as $product) {
            $type = $product->metadata['type'] ?? null;

            switch ($type) {
                case 'car_dealer':
                    $carDealers[] = $product;
                    break;
                case 'private_seller':
                    $privateSellers[] = $product;
                    break;
                case 'service':
                    $services[] = $product;
                    break;
            }

            $price = Price::retrieve($product->default_price);
            $amount = $price->unit_amount / 100;

            $product->price = $amount;
            $product->currency = $price->currency;
        }

        // Sort function based on metadata 'order'
        $sortByOrder = function ($a, $b) {
            return ($a->metadata['order'] ?? 999) <=> ($b->metadata['order'] ?? 999);
        };

        usort($carDealers, $sortByOrder);
        usort($privateSellers, $sortByOrder);
        usort($services, $sortByOrder);

        $plans['car_dealer_plans'] = $carDealers;
        $plans['private_seller_plans'] = $privateSellers;
        $plans['service_plans'] = $services;

        // dd($plans);
        $provinces = Province::all();
        return view('user.subscription.index', compact('plans', 'provinces'));
    }
    public function plan()
    {
        if (Auth::user()) {

            return redirect('subscription');
        } else {
            return redirect('subscription-plans');
        }
        $subscription = DeallerSubscription::where('user_id', Auth::user()->id)->first();


        $subscribe = $subscription->subscribe();
        if (!$subscribe) {
            return redirect()->route('subscription');
        }
        $price = Price::retrieve($subscribe->default_price);

        $customers = Customer::all(); // Adjust limit as needed
        $customer = collect($customers->data)->firstWhere('email', Auth::user()->email);
        if (!$customer) {
            return redirect()->to(url('subscription'));
        }
        $customerId = $customer->id; // Replace with retrieved customer ID


        // Fetch subscriptions for the customer
        $activeSubscriptions = Subscription::all(['customer' => $customerId, 'status' => 'active']);
        $canceledSubscriptions = Subscription::all(['customer' => $customerId, 'status' => 'canceled']);

        // Access the `data` property and merge the two arrays
        $subscriptions = array_merge($activeSubscriptions->data, $canceledSubscriptions->data);





        //dd($subscriptions->cancelled_subscriptions);
        // Fetch invoices (transactions) for the customer
        $invoices = Invoice::all(['customer' => $customerId]);

        // Prepare data for rendering
        $subscriptionData = $subscriptions ?? [];
        $invoiceData = $invoices->data ?? [];
        $subscriptionHistory = SubscriptionHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('user.subscription.subindex', compact('subscription', 'price', 'subscriptionData', 'invoiceData', 'customer', 'subscriptionHistory'));
    }

    public function fetchSubscription($subscriptionId)
    {


        // Retrieve the subscription from Stripe
        $subscription = Subscription::retrieve($subscriptionId);

        return view('subscription.show', ['subscription' => $subscription]);
    }
    public function invoice($id)
    {


        Stripe::setApiKey(config('services.stripe.secret'));
        // Fetch the subscription
        $subscriptionId = $id; // Subscription ID passed from the request

        try {
            // Retrieve the subscription
            $subscription = Subscription::retrieve($subscriptionId);

            // Create an invoice for this subscription
            $invoice = Invoice::create([
                'customer' => $subscription->customer,
                'subscription' => $subscriptionId,
            ]);

            // You can optionally finalize the invoice
            $invoice->finalizeInvoice();

            // Return the invoice details
            return response()->json(['invoice' => $invoice]);
        } catch (ApiErrorException $e) {
            // Handle error
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

        $user = new User();
        $user->name = $request->name;
        $user->dealershipName = $request->dealershipName;
        $user->number = $request->PhoneNumber;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->province = $request->province;
        $user->city = $request->city;
        // $user->status=$request->status;
        $user->status = "inactive";
        $user->dealer_id = Auth::user()->id;
        // $user->role=$request->role;
        $user->role = 2;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->allow_company = $request->allow_company == "on" ? 1 : 0;
        $user->bulk_import = $request->bulk_import == "on" ? 1 : 0;
        $user->user_management = $request->user_management == "on" ? 1 : 0;
        $user->save();

        // Assign permissions
        if ($request->has('permissions')) {
            $user->permissions()->attach(Permission::whereIn('name', $request->permissions)->pluck('id'));
        }
        return redirect()->back()->with('success', 'dealer user added successfully');
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->dealershipName = $request->dealershipName;
        $user->number = $request->PhoneNumber;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->province = $request->province;
        $user->city = $request->city;
        $user->status = $request->status;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->allow_company = $request->allow_company == "on" ? 1 : 0;
        $user->bulk_import = $request->bulk_import == "on" ? 1 : 0;
        $user->user_management = $request->user_management == "on" ? 1 : 0;
        $user->update();
        return redirect()->back()->with('warning', 'dealer user updated successfully');
    }
    public function cancel_plan()
    {
        $user = Auth::user();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Get the customer's active subscriptions
        $customer = $this->getOrCreateCustomer($user);

        $subscriptions = \Stripe\Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 10000,
        ]);

        // Cancel only the "ads" subscription (by sub_type metadata)
        foreach ($subscriptions->data as $sub) {
            if (isset($sub->metadata['sub_type']) && $sub->metadata['sub_type'] === 'ads') {
                $sub->cancel();
            }
        }

        // Reset user role and package
        $user->role = 0;
        $user->package = null;
        $user->save();

        // Deactivate child users and posts
        User::where(['dealer_id' => $user->id, 'role' => 2])->update([
            'status' => 'inactive',
            'package' => null
        ]);

        Post::where(['dealer_id' => $user->id])->update(['status' => '0']);
        BikePost::where(['dealer_id' => $user->id])->update(['status' => '0']);

        // Send cancellation email
        $body = view('emails.cancel_subscription');
        sendMail($user->name, $user->email, 'Auto Jazeera', 'Plan Cancelled Successfully', $body);

        $fcm_tokens = [$user->fcm_token];
        if (!empty($fcm_tokens)) {

          //  SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Plan Cancelled', 'body' => 'You have successfully cancelled your plan']);



            Notifications::create([
                'user_id' => $user->id,
                'title' => 'Plan Cancelled',
                'body' => 'You have successfully cancelled your plan',
                'url' => url('subscription'),
            ]);
        }

        return redirect()->route('dashboard')->with('plancancelled', 'Your subscription has been successfully canceled. Want to start posting ads again? <a href="' . url('subscription') . '">Click here</a> to subscribe today!');
    }


    public function cancel_service_plan()
    {
        $user = Auth::user();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Get or create Stripe customer
        $customer = $this->getOrCreateCustomer($user);

        // Fetch active subscriptions
        $subscriptions = \Stripe\Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 10000,
        ]);

        // Cancel only "service" subscription
        foreach ($subscriptions->data as $sub) {
            if (isset($sub->metadata['sub_type']) && $sub->metadata['sub_type'] === 'service') {
                $sub->cancel();
            }
        }

        // Update user record
        $user->shop_package = null;
        $user->save();

        // Deactivate shop
        $shop = Shops::where('dealer_id', $user->id)->first();
        if ($shop) {
            $shop->status = '0';
            $shop->save();
        }
        User::where(['dealer_id' => $user->id, 'role' => 3])->update([
            'status' => 'inactive'
        ]);

        // Send cancellation email
        $body = view('emails.cancel_subscription');
        sendMail($user->name, $user->email, 'Auto Jazeera', 'Plan Cancelled Successfully', $body);

         $fcm_tokens = [$user->fcm_token];
         if (!empty($fcm_tokens)) {

         //   SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Plan Cancelled', 'body' => 'You have successfully cancelled your plan']);



            Notifications::create([
                'user_id' => $user->id,
                'title' => 'Plan Cancelled',
                'body' => 'You have successfully cancelled your plan',
                'url' => url('subscription'),
            ]);
        }

        return redirect()->route('dashboard')->with('plancancelled', 'Your services subscription has been successfully canceled. <a href="' . url('subscription') . '">Click here</a> to subscribe today!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger', 'Data Deleted Successfully');
    }

    public function signupwithfreeplan(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $user = Auth::user();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Get the free plan product
        $product = Product::retrieve('prod_SOPkazJWEipyKp');
        $priceId = $product->default_price;

        // Get or create Stripe customer
        $customer = $this->getOrCreateCustomer($user);

        // Cancel all previous active subscriptions
        $activeSubs = Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 10000,
        ]);

        foreach ($activeSubs->data as $sub) {
            $sub->cancel();
        }

        // Create subscription (assumes price is $0)
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

        // Update local user record
        $user->package = $product->id;
        $user->trial_availed = 1;
        $user->free_package_availed = 1;
        $user->role = 1;
        $user->save();

        Mail::to($user->email)->send(new SubscriptionBuy($product));

        //    return redirect()->route('personal_info')->with('register_success', 'Your account has been successfully upgraded to the free plan. Please fill your profile information to start posting ads.');

        return back()->with('paymentresponse', 'Thanks for subscribing! You have successfully subscribed ' . $product->name);
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


    public function downloadInvoice($id)
    {


        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Retrieve full invoice with expanded price
            $invoice = Invoice::retrieve([
                'id' => $id,
                'expand' => ['lines.data.price']
            ]);

            $subscription = $invoice->subscription ? Subscription::retrieve($invoice->subscription) : null;
            $subType = $subscription->metadata['sub_type'] ?? 'ads';
            $productId = $invoice->lines->data[0]->price->product;
            $product = Product::retrieve($productId);

            $invoiceData = [
                'invoice_number' => $invoice->number ?? $invoice->id,
                'date' => Carbon::createFromTimestamp($invoice->created)->format('d M Y'),
                'invoice_date' => Carbon::createFromTimestamp($invoice->created)->format('d M Y'),
                'customer_name' => $invoice->customer_name ?? $invoice->customer_email,
                'invoice_from' => 'Auto Jazeera',
                'status' => $invoice->paid ? 'Paid' : 'Unpaid',
                'amount' => $invoice->amount_paid == 0 ? 'Free' : number_format($invoice->amount_paid / 100, 2),
                'plan' => $product->name ?? 'Plan'
            ];

            return view('Pdf_views.invoice', compact('invoiceData'));
        } catch (\Exception $e) {
            return redirect()->route('subscription_history')->with('error', 'Unable to generate invoice: ' . $e->getMessage());
        }
    }

    public function downloadServiceInvoice($id)
    {


        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Retrieve full invoice with expanded price
            $invoice = Invoice::retrieve([
                'id' => $id,
                'expand' => ['lines.data.price']
            ]);

            $subscription = $invoice->subscription ? Subscription::retrieve($invoice->subscription) : null;
            $subType = $subscription->metadata['sub_type'] ?? 'ads';
            $productId = $invoice->lines->data[0]->price->product;
            $product = Product::retrieve($productId);

            $invoiceData = [
                'invoice_number' => $invoice->number ?? $invoice->id,
                'date' => Carbon::createFromTimestamp($invoice->created)->format('d M Y'),
                'invoice_date' => Carbon::createFromTimestamp($invoice->created)->format('d M Y'),
                'customer_name' => $invoice->customer_name ?? $invoice->customer_email,
                'invoice_from' => 'Auto Jazeera',
                'status' => $invoice->paid ? 'Paid' : 'Unpaid',
                'amount' => $invoice->amount_paid == 0 ? 'Free' : number_format($invoice->amount_paid / 100, 2),
                'plan' => $product->name ?? 'Plan'
            ];

            return view('Pdf_views.invoice', compact('invoiceData'));
        } catch (\Exception $e) {
            return redirect()->route('subscription_history')->with('error', 'Unable to generate invoice: ' . $e->getMessage());
        }
    }


    public function subscription_history()
    {
        $user = Auth::user();

        if ($user->role == '2') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = \Stripe\Invoice::all([
            'customer' => $customer->id,
            'limit' => 100,
            'expand' => ['data.lines.data.price']
        ])->data;

        $ads_invoices = [];
        $service_invoices = [];
        $ads_product_ids = [];
        $service_product_ids = [];
        $subscriptions = [];

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            if (!isset($subscriptions[$subscriptionId])) {
                try {
                    $subscriptions[$subscriptionId] = \Stripe\Subscription::retrieve($subscriptionId);
                } catch (\Exception $e) {
                    continue;
                }
            }

            $sub = $subscriptions[$subscriptionId];
            $type = $sub->metadata['sub_type'] ?? null;

            foreach ($invoice->lines->data as $line) {
                $productId = $line->price->product ?? null;

                if ($productId) {
                    if ($type === 'ads') $ads_product_ids[] = $productId;
                    if ($type === 'service') $service_product_ids[] = $productId;
                }
            }

            if ($type === 'ads') $ads_invoices[] = $invoice;
            if ($type === 'service') $service_invoices[] = $invoice;
        }

        $all_product_ids = array_unique(array_merge($ads_product_ids, $service_product_ids));
        $products = [];

        foreach ($all_product_ids as $productId) {
            try {
                $products[$productId] = \Stripe\Product::retrieve($productId);
            } catch (\Exception $e) {
                $products[$productId] = (object)['name' => 'Unknown Plan'];
            }
        }

        return view('user.subscription.subscription_history', compact(
            'ads_invoices',
            'service_invoices',
            'products',
            'subscriptions'
        ));
    }


    public function service_subscription_history()
    {
        $user = Auth::user();

        if ($user->role == '2') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = \Stripe\Invoice::all([
            'customer' => $customer->id,
            'limit' => 100,
            'expand' => ['data.lines.data.price']
        ])->data;

        $ads_invoices = [];
        $service_invoices = [];
        $ads_product_ids = [];
        $service_product_ids = [];
        $subscriptions = [];

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            if (!isset($subscriptions[$subscriptionId])) {
                try {
                    $subscriptions[$subscriptionId] = \Stripe\Subscription::retrieve($subscriptionId);
                } catch (\Exception $e) {
                    continue;
                }
            }

            $sub = $subscriptions[$subscriptionId];
            $type = $sub->metadata['sub_type'] ?? null;

            foreach ($invoice->lines->data as $line) {
                $productId = $line->price->product ?? null;

                if ($productId) {
                    if ($type === 'ads') $ads_product_ids[] = $productId;
                    if ($type === 'service') $service_product_ids[] = $productId;
                }
            }

            if ($type === 'ads') $ads_invoices[] = $invoice;
            if ($type === 'service') $service_invoices[] = $invoice;
        }

        $all_product_ids = array_unique(array_merge($ads_product_ids, $service_product_ids));
        $products = [];

        foreach ($all_product_ids as $productId) {
            try {
                $products[$productId] = \Stripe\Product::retrieve($productId);
            } catch (\Exception $e) {
                $products[$productId] = (object)['name' => 'Unknown Plan'];
            }
        }

        return view('user.subscription.service_subscription_history', compact(
            'ads_invoices',
            'service_invoices',
            'products',
            'subscriptions'
        ));
    }






    public function subscription_plans()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve all products
        $products = Product::all([
            'limit' => 100,
            'active' => true
        ]);

        $carDealers = [];
        $privateSellers = [];
        $services = [];

        foreach ($products->data as $product) {
            $type = $product->metadata['type'] ?? null;

            switch ($type) {
                case 'car_dealer':
                    $carDealers[] = $product;
                    break;
                case 'private_seller':
                    $privateSellers[] = $product;
                    break;
                case 'service':
                    $services[] = $product;
                    break;
            }

            $price = Price::retrieve($product->default_price);
            $amount = $price->unit_amount / 100;

            $product->price = $amount;
            $product->currency = $price->currency;
        }

        // Sort function based on metadata 'order'
        $sortByOrder = function ($a, $b) {
            return ($a->metadata['order'] ?? 999) <=> ($b->metadata['order'] ?? 999);
        };

        usort($carDealers, $sortByOrder);
        usort($privateSellers, $sortByOrder);
        usort($services, $sortByOrder);

        $plans['car_dealer_plans'] = $carDealers;
        $plans['private_seller_plans'] = $privateSellers;
        $plans['service_plans'] = $services;

        // dd($plans);



        // $ads_plans = AdsSubscriptionPlans::with('features')->where('status', '1')->get();
        // $service_plans = ServiceSubscriptionPlans::with('features')->where('status', '1')->get();
        $provinces = Province::all();
        return view('user.subscription.web_plans', compact('plans', 'provinces'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $ads_sub = null;
        $service_sub = null;

        if ($user->role == '0' || $user->role == '1') {

            $customer = $this->getOrCreateCustomer($user);

            $invoices = \Stripe\Invoice::all([
                'customer' => $customer->id,
                'limit' => 100,
                'expand' => ['data.lines.data.price']
            ])->data;

            $subscriptions = [];

            if ($user->shop_package) {
                $service_invoices = [];

                foreach ($invoices as $invoice) {
                    $subscriptionId = $invoice->subscription;
                    if (!$subscriptionId) continue;

                    if (!isset($subscriptions[$subscriptionId])) {
                        try {
                            $subscriptions[$subscriptionId] = \Stripe\Subscription::retrieve($subscriptionId);
                        } catch (\Exception $e) {
                            continue;
                        }
                    }

                    $sub = $subscriptions[$subscriptionId];
                    $type = $sub->metadata['sub_type'] ?? null;

                    if ($type === 'service') {
                        $service_invoices[] = $invoice;
                    }
                }

                foreach ($service_invoices as $invoice) {
                    $sub = $subscriptions[$invoice->subscription] ?? null;
                    if ($sub && $sub->status == 'active') {
                        $service_sub = new \stdClass();
                        $service_sub->start_date = Carbon::createFromTimestamp($invoice->created)->format('M d Y');
                        $service_sub->end_date = Carbon::createFromTimestamp($sub->current_period_end)->format('M d Y');
                        break;
                    }
                }
            }

            if ($user->package) {
                $ads_invoices = [];

                foreach ($invoices as $invoice) {
                    $subscriptionId = $invoice->subscription;
                    if (!$subscriptionId) continue;

                    if (!isset($subscriptions[$subscriptionId])) {
                        try {
                            $subscriptions[$subscriptionId] = \Stripe\Subscription::retrieve($subscriptionId);
                        } catch (\Exception $e) {
                            continue;
                        }
                    }

                    $sub = $subscriptions[$subscriptionId];
                    $type = $sub->metadata['sub_type'] ?? null;

                    if ($type === 'ads') {
                        $ads_invoices[] = $invoice;
                    }
                }

                foreach ($ads_invoices as $invoice) {
                    $sub = $subscriptions[$invoice->subscription] ?? null;
                    if ($sub && ($sub->status == 'active' || $sub->status == 'trialing')) {
                        $ads_sub = new \stdClass();
                        $ads_sub->start_date = Carbon::createFromTimestamp($invoice->created)->format('M d Y');
                        $ads_sub->end_date = Carbon::createFromTimestamp($sub->current_period_end)->format('M d Y');
                        break;
                    }
                }
            }

            return view('dashboard', compact('service_sub', 'ads_sub'));
        }

        return view('dashboard');
    }
}
