<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\WishlistItem;

class WishlistItemController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'wishlistId' => 'required|integer',
            'productId' => 'required|integer',
            'qty' => 'required|integer'
        ]);

        $wl = Wishlist::where('id', $request->wishlistId)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $product = Product::selectAttributes(['sku'])->where((new Product())->getTable().'.entity_id', $request->productId)->first();
        if (!$product) {
            return 'Product not found';
        }

        $item = new WishlistItem();
        $item->wishlist_id = $request->wishlistId;
        $item->product_id = $request->productId;
        $item->qty = $request->qty;
        $item->save();

        return $item;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wishlistId' => 'required|integer',
            'description' => 'required|max:255',
            'qty' => 'required|integer'
        ]);

        $wl = Wishlist::where('id', $request->wishlistId)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $item = WishlistItem::where('id', $id)->where('wishlist_id', $request->wishlistId)->first();
        if (!$item) {
            return 'Item not found';
        }

        $item->description = $request->description;
        $item->qty = $request->qty;
        $item->save();

        return $item;
    }

    public function destroy(Request $request, $id)
    {
        $request->validate([
            'wishlistId' => 'required|integer',
        ]);

        $wl = Wishlist::where('id', $request->wishlistId)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $item = WishlistItem::where('id', $id)->where('wishlist_id', $request->wishlistId)->first();
        if (!$item) {
            return 'Item not found';
        }

        $item->delete();
        return true;
    }
}
