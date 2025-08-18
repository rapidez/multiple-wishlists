<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Rapidez\MultipleWishlist\Models\Wishlist;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;
use Rapidez\MultipleWishlist\Scopes\CustomerScope;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(): Collection
    {
        return RapidezWishlist::with('items.product')->get();
    }

    public function shared($token): mixed
    {
        abort_unless(config('rapidez.multiple-wishlists.allow-sharing'), 404);
        
        return RapidezWishlist::with('items.product')->withoutGlobalScope(CustomerScope::class)->isShared($token)->firstOrFail();
    }

    public function store(Request $request): mixed
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'shared' => 'boolean'
        ]);

        $rapidezWishlist = new RapidezWishlist([
            'customer_id' => auth()->user()->entity_id,
            ...$validated
        ]);
        $rapidezWishlist->save();

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
}
