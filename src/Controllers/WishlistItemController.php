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
            'wishlist_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1'
        ]);

        $rapidezWishlist = RapidezWishlist::with('rapidezItems')->isCustomer($request->customer_id)->findOrFail($request->wishlist_id);
        $product = Product::selectAttributes(['id'])->findOrFail($request->product_id);
        $magentoWishlist = Wishlist::with('items')->isCustomer($request->customer_id)->firstOrFail();

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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'max:255',
            'qty' => 'required|integer|min:1'
        ]);

        $item = WishlistItem::with(['magentoWishlist' => function ($query) use ($request) {
            $query->isCustomer($request->customer_id);
        }])->findOrFail($id);

        $item->update($validated);
        
        return $item;
    }

    public function destroy(Request $request, $id)
    {
        $item = WishlistItem::with('magentoWishlist')->findOrFail($id);
        if ($item->magentoWishlist->customer_id != $request->customer_id) {
            abort(404);
        }
        $item->delete();

        return $item;
    }
}
