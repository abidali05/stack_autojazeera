<?php

namespace App\Http\Controllers\Autoservices\superadmin;

use App\Models\Shops;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ShopController extends Controller
{
    public function index()
    {
        $shops = Shops::with(['shop_amenities', 'shop_timings', 'shop_services', 'shop_images', 'dealer'])->paginate(25);
        return view('superadmin.autoservices.shops.index', compact('shops'));
    }

    public function update_status(Request $request)
    {

        $shop = Shops::findOrFail($request->id);
        if (!$shop) {
            return redirect()->route('superadmin.shops.index')->with('shopresponse', 'Shop not found.');
        }
        $shop->status = $request->status;
        $shop->rejection_reason = $request->rejection_reason ?? null;
        $shop->save();

        $body = view('emails.shop_status_update', compact('shop'));
        $user = User::where('id', $shop->dealer_id)->first();
        sendMail($user->name, $user->email, 'Auto Jazeera', 'Shop Status Update', $body);
        return redirect()->back()->with('shopresponse', 'Shop updated successfully.');
    }


    public function shop_reviews()
    {
        $reviews = ShopReview::with(['shop', 'review_images'])->paginate(25);
        return view('superadmin.autoservices.shops.all_reviews', compact('reviews'));
    }

    public function delete_shop_review(Request $request, $id)
    {

        $review = ShopReview::where('id', $id)->first();

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found.');
        }

        try {
            DB::beginTransaction();

            // Delete associated images from storage and DB
            foreach ($review->review_images as $image) {
                $imagePath = str_replace('storage/', '', $image->path);
                Storage::disk('public')->delete($imagePath);
                $image->delete();
            }

            $review->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review Delete Failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to delete review. Please try again later.');
        }
    }
}
