<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use App\Models\AutoServices\ServiceSubscriptionPlans;
use Illuminate\Http\Request;

class AdsPlansController extends Controller
{
    public function index()
    {
        $plans = AdsSubscriptionPlans::with('features')->get();
        $serviceplans = ServiceSubscriptionPlans::with('features')->get();
        return view('superadmin.ads_plans.index', compact('plans','serviceplans'));
    }

    public function change_status($id){
        $plan = AdsSubscriptionPlans::find($id);
        if ($plan) {
            $plan->status = !$plan->status;
            $plan->save();
            return redirect()->back()->with('plansresponse', 'Status updated successfully');
        } else {
            return redirect()->back()->with('plansresponse', 'Plan not found');
        }
    }
}
