<?php

namespace App\Http\Controllers\Api\Subscription;

use Stripe\Price;
use Stripe\Stripe;
use Stripe\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use App\Models\AutoServices\ServiceSubscriptionPlans;

class SubscriptionController extends Controller
{
    public function get_subscription_plans()
    {
        // $ads_plans = AdsSubscriptionPlans::with('features')->where('status', '1')->get();
        // $service_plans = ServiceSubscriptionPlans::with('features')->where('status', '1')->get();


        // $ads_plans = AdsSubscriptionPlans::with('features')->where('status', '1')->get();
        // $service_plans = ServiceSubscriptionPlans::with('features')->where('status', '1')->get();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve all products
        $products = Product::all([
            'limit' => 100000,
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




        return response()->json([
            'status' => 200,
            'message' => 'Subscription plans fetched successfully.',
            'data' => $plans,
        ], 200);
    }
}
