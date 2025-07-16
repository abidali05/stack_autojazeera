<?php

namespace App\Http\Controllers\Autoservices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AutoServices\ShopWishlist;


class ShopWishlistController extends Controller
{
    public function index(){
        $wishlists = ShopWishlist::with('shop')->where('user_id', Auth::id())->paginate(25);
        return view('user.shopwishlist.index', compact('wishlists'));
    }

    public function addRemoveShopWishlist($shop_id, $user_id){
        $wishlist = ShopWishlist::where('shop_id', $shop_id)->where('user_id', $user_id)->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('wishlistresponse', 'Shop removed from wishlist');
        } else {
            ShopWishlist::create([
                'shop_id' => $shop_id,
                'user_id' => $user_id,
            ]);
            return redirect()->back()->with('wishlistresponse', 'Shop added to wishlist');
        }
    }
}
