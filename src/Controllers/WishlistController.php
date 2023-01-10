<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(Request $request): Collection
    {
        return RapidezWishlist::withCount('items')->isCustomer($request->customer_id)->get();
    }

    public function show(Request $request, $id): mixed
    {
        return RapidezWishlist::with('items')->isCustomer($request->customer_id)->findOrFail($id);
    }

    public function shared($token): mixed
    {
        return RapidezWishlist::with('items')->isShared($token)->firstOrFail();
    }

    public function store(Request $request): mixed
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'title' => 'required|max:255',
            'shared' => 'boolean'
        ]);

        $rapidezWishlist = new RapidezWishlist($validated);
        $rapidezWishlist->save();

        if (!Wishlist::where('customer_id', $request->customer_id)->first()) {
            $magentoWishlist = new Wishlist($validated);
            $magentoWishlist->save();
        }

        return $rapidezWishlist;
    }

    public function update(Request $request, $id): mixed
    {
        $validated = $request->validate([
            'title' => 'max:255',
            'description' => 'max:65535',
            'shared' => 'boolean'
        ]);

        $rapidezWishlist = RapidezWishlist::isCustomer($request->customer_id)->findOrFail($id);
        $rapidezWishlist->update($validated);

        return $rapidezWishlist;
    }

    public function destroy(Request $request, $id)
    {
        return RapidezWishlist::isCustomer($request->customer_id)->findOrFail($id)->delete();
    }

    public function allWithItems(Request $request): mixed
    {
        return RapidezWishlist::with('items')->isCustomer($request->customer_id)->get();
    }
}
