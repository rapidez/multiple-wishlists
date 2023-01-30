<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;
use Rapidez\MultipleWishlist\Requests\AuthenticatedRequest;
use Rapidez\MultipleWishlist\Scopes\CustomerScope;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(): Collection
    {
        return RapidezWishlist::withCount('items')->get();
    }

    public function show(RapidezWishlist $wishlist): mixed
    {
        return $wishlist->load('items');
    }

    public function shared($token): mixed
    {
        return RapidezWishlist::with('items')->withoutGlobalScope(CustomerScope::class)->isShared($token)->firstOrFail();
    }

    public function store(AuthenticatedRequest $request): mixed
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'title' => 'required|max:255',
            'shared' => 'boolean'
        ]);

        $rapidezWishlist = new RapidezWishlist($validated);
        $rapidezWishlist->save();

        if (!Wishlist::where('customer_id', $request->customer_id)->first()) {
            $magentoWishlist = new Wishlist([
                'customer_id' => $request->customer_id,
            ]);
            $magentoWishlist->save();
        }

        return $rapidezWishlist;
    }

    public function update(Request $request, RapidezWishlist $wishlist): mixed
    {
        $validated = $request->validate([
            'title' => 'max:255',
            'description' => 'max:65535',
            'shared' => 'boolean'
        ]);

        $wishlist->update($validated);

        return $wishlist;
    }

    public function destroy(RapidezWishlist $wishlist)
    {
        $wishlist->delete();
    }

    public function allWithItems(): mixed
    {
        return RapidezWishlist::with('items')->get();
    }
}
