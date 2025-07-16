<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Shops;
use App\Models\ShopReview;
use Illuminate\Http\Request;

use App\Models\Notifications;
use App\Models\ShopReviewImage;
use App\Jobs\SendFcmNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopReviewController extends Controller
{
    public function store(Request $request)
    {


        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'comment' => 'required|string|min:20',
            'rating' => 'required|integer|between:1,5',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        try {
            DB::beginTransaction();
            // own shop check 
            $user = Auth::user();
            if ($user->role == '2') {
                $userid = $user->dealer_id;
            } else {
                $userid = $user->id;
            }

            $check = Shops::where('dealer_id', $userid)->where('id', $request->shop_id)->first();
            if ($check) {
                return redirect()->back()->with('reviewresponse', 'You cannot review your own shop.');
            }


            // duplicate check 
            // $check = ShopReview::where('shop_id', $request->shop_id)->where('user_id', auth()->user()->id)->first();
            // if ($check) {
            //     return redirect()->back()->with('reviewresponse', 'You have already reviewed this shop.');
            // }

            $shopReview = ShopReview::create([
                'shop_id' => $request->shop_id,
                'comment' => $request->comment,
                'rating' => $request->rating,
                'user_id' => auth()->user()->id,
            ]);

            if ($request->hasFile('review_images')) {
                foreach ($request->file('review_images') as $image) {
                    $imageName = 'review-' . microtime(true) . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('shop_reviews', $imageName, 'public');

                    ShopReviewImage::create([
                        'review_id' => $shopReview->id,
                        'path' => 'storage/shop_reviews/' . $imageName,
                    ]);
                }
            }

            $body = view('emails.new_review', compact('shopReview'));
            $user = User::find($shopReview->shop->dealer_id);
            sendMail($user->name, $user->email, 'Auto Jazeera', 'New Review Submitted', $body);

            $user = User::find($shopReview->shop->dealer_id);
            sendMail($user->name, $user->email, 'Auto Jazeera', 'New Review Submitted', $body);
			if($user->fcm_token && $user->fcm_token!='' || $user->fcm_token!=null){
            $fcm_tokens = [$user->fcm_token];
            if ($fcm_tokens !=null) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Review Submitted', 'body' => 'You have a new review on your shop']);



                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Plan Cancelled',
                    'body' => 'You have a new review on your shop',
                    'url' => url('shop'),
                ]);
            }
			}

            
            DB::commit();
            return redirect()->to(route('shopdetail', $shopReview->shop_id))->with('reviewresponse', 'Review added successfully');
            // return redirect()->back()->with('reviewresponse', 'Review added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review Save Failed: ' . $e->getMessage());
            return redirect()->to(route('shopdetail', $shopReview->shop_id))->with('reviewresponse', 'Review added successfully');

            // return redirect()->back()->with('reviewresponse', 'Something went wrong while saving your review.');
        }
    }
}
