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
        return RapidezWishlist::withCount('items')->isCustomer($request->customerId)->get();
    }

    public function show(Request $request, $id): mixed
    {
        return RapidezWishlist::with('items')->isCustomer($request->customerId)->findOrFail($id);
    }

    public function shared($token): mixed
    {
        return RapidezWishlist::with('items')->isShared($token)->firstOrFail();
    }

    public function store(Request $request): mixed
    {
        $request->validate([
            'title' => 'required|max:255'
        ]);

        $wishlist = new RapidezWishlist();
        $wishlist->title = $request->title;
        $wishlist->customer_id = $request->customerId;
        $wishlist->store_id = config('rapidez.store');
        $wishlist->shared = false;
        $wishlist->sharing_token = md5(uniqid("wl"));
        $wishlist->save();

        if (!Wishlist::where('customer_id', $request->customerId)->first()) {
            $m_wishlist = new Wishlist();
            $m_wishlist->timestamps = false;
            $m_wishlist->customer_id = $request->customerId;
            $m_wishlist->shared = false;
            $m_wishlist->sharing_code = md5(uniqid("mwl"));
            $m_wishlist->updated_at = now();
            $m_wishlist->save();
        }

        return $wishlist;
    }

    public function update(Request $request, $id): mixed
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'max:65535',
            'share' => 'required|boolean'
        ]);

        $wishlist = RapidezWishlist::where('id', $id)->isCustomer($request->customerId)->firstOrFail();

        $wishlist->title = $request->title;
        if ($request->description) {
            $wishlist->description = $request->description;
        }
        $wishlist->shared = $request->share;
        $wishlist->save();

        return $wishlist;
    }

    public function destroy(Request $request, $id): mixed
    {
        $wishlist = RapidezWishlist::where('id', $id)->isCustomer($request->customerId)->firstOrFail();
        $wishlist->delete();
        return true;
    }

    public function allWithItems(Request $request): mixed
    {
        return RapidezWishlist::with('items')->isCustomer($request->customerId)->get();
    }
}
