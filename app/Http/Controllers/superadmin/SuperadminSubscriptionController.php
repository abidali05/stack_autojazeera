<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Mail\SubscriptionEndedadmin;
use App\Models\AdsSubscriptions;
use App\Models\AutoServices\ServiceSubscriptions;
use App\Models\DeallerSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
        $subscriptions = AdsSubscriptions::with(['plan', 'user'])->get();
        return view('superadmin.subscription.ads_subscriptions', compact('subscriptions'));
    }


    public function service_subscriptions()
    {
        $subscriptions = ServiceSubscriptions::with(['plan', 'user'])->paginate(25);
        return view('superadmin.subscription.service_subscriptions', compact('subscriptions'));
    }
}
