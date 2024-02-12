<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\WishlistItem;

class WishlistItemController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wishlist_id' => 'required|integer|exclude',
            'product_id' => 'required|integer'
        ]);

        // Make sure the wishlists exist
        $wishlist = Wishlist::with('items')->first();
        $rapidezWishlist = RapidezWishlist::with('rapidezItems')->findOrFail($request->wishlist_id);

        // Make sure the product exists
        $product = Product::withoutGlobalScopes()->findOrFail($request->product_id);

        // Add item to wishlist item table, and add reference entry to rapidez wishlist item table
        $item = $wishlist->items()->create([
            'product_id' => $request->product_id,
            'description' => null,
            'qty' => 1,
        ]);
        $rapidezWishlist->rapidezItems()->create([
            'wishlist_item_id' => $item->wishlist_item_id
        ]);

        return $item;
    }

    public function update(Request $request, WishlistItem $item)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'qty' => 'integer|min:1'
        ]);

        $item->rapidezWishlist()->firstOrFail();
        $item->update($validated);
        return $item;
    }

    public function destroy(Request $request, WishlistItem $item)
    {
        $item->rapidezWishlist()->firstOrFail();
        $item->delete();
        return $item;
    }
}
