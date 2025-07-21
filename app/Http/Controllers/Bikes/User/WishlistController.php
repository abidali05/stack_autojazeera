<?php

namespace App\Http\Controllers\Bikes\User;

use Illuminate\Http\Request;
use App\Models\Bike\BikeWishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    
    public function add_to_wishlist($postid)
    {
        $wishlist = BikeWishlist::where('post_id', $postid)->where('user_id', Auth::id())->first();
        if (!$wishlist) {
            $wishlist = new BikeWishlist();
            $wishlist->post_id = $postid;
            $wishlist->user_id = Auth::id();
            $wishlist->status = 1;
            $wishlist->save();
            return redirect()->back()->with('wishlistresponse', 'Added to wishlist');
        } else {
            $wishlist->delete();
            return redirect()->back()->with('wishlistresponse', 'Removed from wishlist');
        }
    }

    public function index(){

        $wishlists = BikeWishlist::where('user_id', Auth::id())->where('status', 1)->get();

        return view('bikes.user.wishlist.index', compact('wishlists'));
    }
}
