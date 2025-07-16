<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Models\AutoServices\ShopWishlist;
use Illuminate\Http\Request;

class ShopWishlistController extends Controller
{
    public function get_wishlist()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        $wishlist = ShopWishlist::where('user_id', $user->id)->with('shop')->get();

        return response()->json([
            'status' => 200,
            'message' => "Wishlist fetched successfully",
            'data' => $wishlist
        ]);
    }

    public function add_remove_shop_wishlist($shop_id)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        $wishlist = ShopWishlist::where('shop_id', $shop_id)->where('user_id', $user->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'status' => 200,
                'message' => "Shop removed from wishlist successfully",
                'is_wishlisted' => 0
            ]);
        } else {
            ShopWishlist::create([
                'shop_id' => $shop_id,
                'user_id' => $user->id
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Shop added to wishlist successfully",
                'is_wishlisted' => 1
            ]);
        }
    }
	
	
	public function clear_wishlist(){
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();

        ShopWishlist::where('user_id', $user->id)->delete();

        return response()->json([
            'status' => 200,
            'message' => "Wishlist cleared successfully"
        ]);
    }
}
