<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\JbWishlistItem;
use Rapidez\MultipleWishlist\Models\MagentoWishlist;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\WishlistItem;
use Rapidez\MultipleWishlist\Models\MagentoWishlistItem;

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
            'qty' => 'required|integer|min:1'
        ]);

        $wl = Wishlist::with('items')->where('id', $request->wishlistId)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $product = Product::selectAttributes(['sku'])->where((new Product())->getTable().'.entity_id', $request->productId)->first();
        if (!$product) {
            return 'Product not found';
        }

        $mwl = MagentoWishlist::where('customer_id', $request->userId)->first();
        if (!$mwl) {
            return 'Magento wishlist not found';
        }

        $existing = $wl->items()->join('wishlist_item', 'wishlist_item.wishlist_item_id', '=', 'jb_wishlist_item.wishlist_item_id')->firstWhere('wishlist_item.product_id', $request->productId);
        if ($existing) {
            $existing->qty += $request->qty;
            $existing->save();
            return $existing;
        }

        $item = new WishlistItem();
        $item->timestamps = false;
        $item->wishlist_id = $mwl->wishlist_id;
        $item->product_id = $request->productId;
        $item->qty = $request->qty;
        $item->added_at = now();
        $item->save();

        $jitem = new JbWishlistItem();
        $jitem->wishlist_id = $request->wishlistId;
        $jitem->wishlist_item_id = $item->wishlist_item_id;
        $jitem->save();

        return $item;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wishlistId' => 'required|integer',
            'description' => 'max:255',
            'qty' => 'required|integer|min:1'
        ]);

        $wl = Wishlist::where('id', $request->wishlistId)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $item = WishlistItem::where('wishlist_item.wishlist_item_id', $id)->join('jb_wishlist_item', 'jb_wishlist_item.wishlist_item_id', '=', 'wishlist_item.wishlist_item_id')->where('jb_wishlist_item.wishlist_id', $request->wishlistId)->first();
        if (!$item) {
            return 'Item not found';
        }

        $item->timestamps = false;
        if ($request->description) {
            $item->description = $request->description;
        }
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

        $item = WishlistItem::where('wishlist_item.wishlist_item_id', $id)->join('jb_wishlist_item', 'jb_wishlist_item.wishlist_item_id', '=', 'wishlist_item.wishlist_item_id')->where('jb_wishlist_item.wishlist_id', $request->wishlistId)->first();
        if (!$item) {
            return 'Item not found';
        }

        $item->delete();

        return true;
    }
}
