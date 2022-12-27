<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\RapidezWishlistItem;
use Rapidez\MultipleWishlist\Models\WishlistItem;

class WishlistItemController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wishlistId' => 'required|integer',
            'productId' => 'required|integer',
            'qty' => 'required|integer|min:1'
        ]);
        
        $wishlist = RapidezWishlist::with('rapidezItems')->isCustomer($request->customerId)->findOrFail($request->wishlistId);
        $product = Product::selectAttributes(['id'])->findOrFail($request->productId);
        $m_wishlist = Wishlist::with('items')->isCustomer($request->customerId)->firstOrFail();

        $existing = $wishlist->items()->firstWhere('wishlist_item.product_id', $request->productId);
        if ($existing) {
            $existing->qty += $request->qty;
            $existing->save();
            return $existing;
        }

        $item = $m_wishlist->items()->create($validated);
        $wishlist->rapidezItems()->create([
            'wishlist_item_id' => $item->wishlist_item_id,
            'wishlist_id' => $request->wishlist_id
        ]);

        return $item;
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'max:255',
            'qty' => 'required|integer|min:1'
        ]);

        $item = WishlistItem::with('magentoWishlist')->findOrFail($id);
        if($item->magentoWishlist->customer_id != $request->customerId) {
            abort(404);
        }
        // why doesn't `$item->update($validated)` change the description field here? very strange behavior
        return WishlistItem::where('wishlist_item_id', $id)->update($validated);
    }

    public function destroy(Request $request, $id)
    {
        $item = WishlistItem::with('magentoWishlist')->findOrFail($id);
        if($item->magentoWishlist->customer_id != $request->customerId) {
            abort(404);
        }
        $item->delete();
    }
}
