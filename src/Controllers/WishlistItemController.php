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
        // Check before validating to allow SKUs to be transformed
        $this->checkProduct($request);

        $validated = $request->validate([
            'wishlist_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255'
        ]);

        $rapidezWishlist = RapidezWishlist::with('rapidezItems')->isCustomer($request->customer_id)->findOrFail($request->wishlist_id);
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

    private function checkProduct(Request $request)
    {
        // Accept either a SKU or a product ID
        if (is_int($request->product_id)) {
            $product = Product::selectAttributes(['id'])->findOrFail($request->product_id);
        } else {
            $builder = Product::selectAttributes(['id']);
            $product = $builder->where($builder->getQuery()->from.'.sku', $request->product_id)->firstOrFail();
            $request->request->add(['product_id' => $product->id]);
        }
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
