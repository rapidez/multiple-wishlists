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
use Rapidez\MultipleWishlist\Requests\ProductRequest;

class WishlistItemController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function store(ProductRequest $request)
    {
        $request->validate([
            'wishlist_id' => 'required|integer'
        ]);
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255'
        ]);
        $validated['product_id'] = $request->product_id;

        $rapidezWishlist = RapidezWishlist::with('rapidezItems')->findOrFail($request->wishlist_id);
        $magentoWishlist = Wishlist::with('items')->firstOrFail();

        $existing = $rapidezWishlist->items()->firstWhere('wishlist_item.product_id', $request->product_id);
        if ($existing) {
            $existing->update($validated);
            return $existing;
        }

        $item = $magentoWishlist->items()->create($validated);
        $rapidezWishlist->rapidezItems()->create([
            'wishlist_item_id' => $item->wishlist_item_id,
            'wishlist_id' => $request->wishlist_id
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
