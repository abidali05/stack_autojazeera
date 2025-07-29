<?php

namespace App\Http\Controllers\Api;


use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Product;
use App\Models\Post;
use App\Models\User;
use Stripe\Customer;
use App\Models\Shops;
use Stripe\Subscription;
use Illuminate\Http\Request;
use App\Mail\SubscriptionBuy;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Models\AdsSubscriptions;
use App\Jobs\SendFcmNotification;
use App\Mail\Cancle_subscription;
use App\Models\DeallerSubscription;
use App\Models\SubscriptionHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ServiceSubscriptions;


class ApiProfileController extends Controller
{
    public function profile(Request $request)
    {
        // Log::info($request->all());
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();
        $input = $request->except('_token');
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('web/profile/'), $filename);
            $input['image'] = $filename;
        }
        $validationRules = [
            'email' => "nullable|unique:users,email,{$user->id}",
        ];


        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->number) {
            $input['number'] = "+92" . $request->number;
        }

        if ($request->userType) {
            $input['userType'] = $request->userType;
        }
        if ($request->name) {
            $input['name'] = $request->name;
        }
        if ($request->dealershipName) {
            $input['dealershipName'] = $request->dealershipName;
        }
        if ($request->gender) {
            $input['gender'] = $request->gender;
        }
        if ($request->address) {
            $input['address'] = $request->address;
        }
        if ($request->city) {
            $input['city'] = $request->city;
        }
        if ($request->province) {
            $input['province'] = $request->province;
        }
        if ($request->area) {
            $input['area'] = $request->area;
        }

        if ($request->email) {
            $input['email'] = $request->email;
        }

        $profile = User::where('id', $user->id)->update($input);

        $profile1 = User::find(auth('sanctum')->user()->id);

        if ($profile) {
            return response()->json([
                "data" => $profile1,
                "status" => 200,
                "message" => "profile found"


            ], 200);
        } else {
            return response()->json([
                "data" => $user,
                "status" => 402,
                "message" => "profile not found"


            ], 402);
        }
    }
    public function getUserprofile()
    {

        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $profile = User::find(auth('sanctum')->user()->id);

        if ($profile) {
            $token = request()->bearerToken();
            return response()->json([
                "data" => $profile,
                "token" => $token,
                "message" => 'profile found',
                // 'access_token' => $userToken
                'status' => 200
            ], 200);
            // return response()->json([
            //     "data" => $profile,
            //     "status" => 200,
            //     "message" => "profile found"


            // ], 200);
        } else {
            return response()->json([
                "data" => [],
                "status" => 402,
                "message" => "profile not found"
            ], 402);
        }
    }
    public function register(Request $request)
    {
        // dd($request);
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $validationRules = [
            'number' => 'required|unique:users,number',
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $user = auth('sanctum')->user();
        // dd($input);
        $email = $request->email;
        $number = $request->number;
        $package = $request->package;

        // dd($email);

        $existingUser  = User::where('email', $email)->first();
        // dd($existingUser);

        if (!$existingUser) {
            return response()->json([
                "status" => 200,
                "message" => "User not found"
            ], 200);
        }

        if ($existingUser->role === "1") {
            return response()->json([
                "data" => $existingUser,
                "status" => 402,
                "message" => "You are already a dealer"
            ], 402);
        }

        if ($existingUser && $existingUser->role === "0") {
            // $input = $request->except('_token');
            $existingUser->role = '1';
            $existingUser->free_package_availed = 1;
            if ($request->file('dealer_logo') && $request->file('dealer_logo')->isValid()) {
                $file = $request->file('dealer_logo');
                $filename = date('His') . $file->getClientOriginalName();
                $file->move(public_path('web/profile/'), $filename);
                // $input['dealer_logo'] = $filename;
                $existingUser->dealer_logo = $filename;
            }

            // $input['role'] = '1';
            $existingUser->address = $request->address;
            $existingUser->province = $request->province;
            $existingUser->city = $request->city;
            $existingUser->package = $request->package;


            if ($request->number) {
                $existingUser->number  = "+92" . $request->number;
            }

            // $input['dealershipName'] = $request->dealershipName;
            $existingUser->dealershipName = $request->dealershipName;

            $existingUser->save();
            //$body = view('emails.subscription_buy');
            Stripe::setApiKey(config('services.stripe.secret'));
            //sendMail($existingUser->name, $existingUser->email, 'Auto Jazeera', 'Plan Purchased Successfully', $body);
            Mail::to($existingUser->email)->send(new SubscriptionBuy());

            $stripeProduct = Product::retrieve($request->package);
            $dealer = DeallerSubscription::where('user_id', $user->id)->first();

            $isMatchingPlan = ($stripeProduct->id == $request->package);

            // Retrieve or create Stripe customer
            $customer = $this->getOrCreateCustomer($user, $stripeProduct, $isMatchingPlan);
            $this->updateOrCreateDealerSubscription($dealer, $user, $request->package, $stripeProduct);

            return response()->json([
                "data" => $existingUser->fresh(),
                "status" => 200,
                "message" => 'Thanks for joining Auto Jazeera as Car Dealer . 
Start Car Ad Posting today!'
            ]);
        }

        return response()->json([
            "status" => 402,
            "message" => "Invalid User or User not found"
        ], 402);
    }

    public function planChange(Request $request)
    {
        log::info('plan change');
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }


        $validationRules = [
            'plan_id' => 'required',

        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user1 = auth('sanctum')->user();
        $id = $user1->id;
        $user1->package = $request->plan_id;
        $user1->role = 1;
        $user1->free_package_availed = 1;
        $user1->save();
        //$body = view('emails.subscription_buy');
        //sendMail($user1->name, $user1->email, 'Auto Jazeera', 'Plan Changed Successfully', $body);
        Mail::to($user1->email)->send(new SubscriptionBuy());
        $token = $user1->createToken('auth:sanctum')->plainTextToken;
        $user = User::where(['dealer_id' => $id, 'role' => 2])->update(['status' => 'active']);
        $user = Post::where(['dealer_id' => $id])->update(['status' => '1']);
        // return response()->json(['status' => 200, 'message' => "Plan changed successfully"]);
        $user1->role = (string)$user1->role;
        $user1->free_package_availed = (int)$user1->free_package_availed;
        return response()->json([
            "data" => $user1,
            "token" => $token,
            "message" => 'Plan changed successfully',
            'status' => 200
        ], 200);
    }

    public function cancelPlan(Request $request)
    {
        log::info($request->all());
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $validationRules = [
            'sub_type' => 'required|in:ads,service',
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = auth('sanctum')->user();
        Stripe::setApiKey(config('services.stripe.secret'));

        // Get the customer's active subscriptions
        $customer = $this->getOrCreateCustomer1($user);

        $subscriptions = \Stripe\Subscription::all([
            'customer' => $customer->id,
            'status' => 'active',
            'limit' => 10000,
        ]);

        // Cancel only the "ads" subscription (by sub_type metadata)
        foreach ($subscriptions->data as $sub) {
            if (isset($sub->metadata['sub_type']) && $sub->metadata['sub_type'] === $request->sub_type) {
                $sub->cancel();
            }
        }

        // Reset user role and package
        if ($request->sub_type == 'ads') {
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
        } else {
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
        }
        // Send cancellation email
        $body = view('emails.cancel_subscription');
        try {
            $body = view('emails.cancel_subscription')->render();
            sendMail($user->name, $user->email, 'Auto Jazeera', 'Plan Cancelled Successfully', $body);
        } catch (\Exception $e) {
            Log::error('Failed to send cancellation email: ' . $e->getMessage());
        }

        $fcm_tokens = [$user->fcm_token];
        if ($fcm_tokens) {
            SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Plan Cancelled', 'body' => 'You have successfully cancelled your plan']);

            Notifications::create([
                'user_id' => $user->id,
                'title' => 'Plan Cancelled',
                'body' => 'You have successfully cancelled your plan',
                'url' => url('subscription'),
            ]);
        }
        $token = $user->createToken('auth:sanctum')->plainTextToken;

        if ($request->sub_type == 'ads') {
            return response()->json([
                "data" => $user,
                "token" => $token,
                "message" => 'Your plan is canceled and now you are user',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                "data" => $user,
                "token" => $token,
                "message" => 'Your plan is canceled',
                'status' => 200
            ], 200);
        }
    }

    private function getOrCreateCustomer1($user)
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

    public function previousSubscriptions(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        if ($user->role == '2') {
            return response()->json([
                'status' => 422,
                'message' => 'You are not authorized to access this route'
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getCreateCustomer($user);

        $invoices = \Stripe\Invoice::all([
            'customer' => $customer->id,
            'limit' => 100,
            'expand' => ['data.lines.data.price']
        ])->data;

        $ads = [];
        $services = [];
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
            $product = $invoice->lines->data[0]->price->product ?? null;

            try {
                $productData = \Stripe\Product::retrieve($product);
            } catch (\Exception $e) {
                $productData = (object)['name' => 'Unknown Plan', 'metadata' => (object)[]];
            }

            $now = now()->timestamp;
            $isExpired = $sub->status !== 'canceled' && $sub->current_period_end < $now;

            $status = match (true) {
                $sub->status === 'trialing' => 'Trial (Ends ' . \Carbon\Carbon::createFromTimestamp($sub->trial_end)->format('d M Y') . ')',
                $sub->status === 'active' && !$sub->cancel_at && !$isExpired => 'Active',
                $sub->status === 'canceled' => 'Cancelled',
                $isExpired => 'Expired',
                default => 'Unknown',
            };

            $row = [
                'plan' => $type == 'ads' ? $productData->name . (($productData->metadata->is_free ?? '1') == '0' && $invoice->amount_paid == 0 ? ' (Trial)' : '') : $productData->name . ($invoice->amount_paid == 0 ? ' (Trial)' : ''),
                'start' => \Carbon\Carbon::createFromTimestamp($invoice->created)->format('d M Y'),
                'end' => $sub->current_period_end ? \Carbon\Carbon::createFromTimestamp($sub->current_period_end)->format('d M Y') : 'N/A',
                'price' => strtoupper($invoice->currency) . ' ' . number_format($invoice->amount_paid / 100, 2),
                'cancelled' => $sub->canceled_at ? \Carbon\Carbon::createFromTimestamp($sub->canceled_at)->format('d M Y') : '',
                'status' => $status,
                'invoice_link' => $sub->status === 'trialing' ? null : route('downloadInvoice', $invoice->id)
            ];

            if ($type === 'ads') {
                $ads[] = $row;
            } elseif ($type === 'service') {
                $services[] = $row;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Previous Subscriptions Found',
            'data' => [
                'ads' => $ads,
                'services' => $services
            ]
        ]);
    }


    private function getCreateCustomer($user)
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
        $billingEnd = $billingStart->copy()->addMonths($stripeProduct->metadata->months ?? 1);

        if (!$dealer) {
            $dealer = new DeallerSubscription();
            $dealer->user_id = $user->id;
            $dealer->current_subscription = $plan;
            $dealer->billing_start = $billingStart;
            $dealer->billing_end = $billingEnd;
            $dealer->status = 1;
            $dealer->save();
        } else {
            $dealer->current_subscription = $plan;
            $dealer->billing_start = $billingStart;
            $dealer->billing_end = $billingEnd;
            $dealer->status = 1;
            $dealer->update();
        }

        // Update user's role and package
        $user->role = 1;
        $user->package = $stripeProduct->id;
        $user->update();
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
}
