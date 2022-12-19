<?php

namespace Rapidez\MultipleWishlist\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rapidez\Core\Models\Product;
use Rapidez\MultipleWishlist\Models\Wishlist;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(Request $request): Collection
    {
        return Wishlist::where('customer_id', $request->userId)->get();
    }

    public function show(Request $request, $id): mixed
    {
        $wl = Wishlist::where('id', $id)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }
        
        return [$wl, $wl->items()->join('catalog_product_entity', 'catalog_product_entity.entity_id', '=', 'jb_wishlist_item.product_id')->get()];
    }

    public function shared($token): mixed
    {
        $wl = Wishlist::where('sharing_token', $token)->where('shared', true)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }
        
        return [$wl, $wl->items()->join('catalog_product_entity', 'catalog_product_entity.entity_id', '=', 'jb_wishlist_item.product_id')->get()];
    }

    public function store(Request $request): mixed
    {
        $request->validate([
            'title' => 'required|max:255'
        ]);

        $wishlist = new Wishlist();
        $wishlist->title = $request->title;
        $wishlist->customer_id = $request->userId;
        $wishlist->store_id = config('rapidez.store');
        $wishlist->shared = false;
        $wishlist->sharing_token = md5(uniqid("wl"));
        $wishlist->save();

        return $wishlist;
    }

    public function update(Request $request, $id): mixed
    {
        if (!$request->userId || !$id) {
            return false;
        }
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:65535',
            'share' => 'required|boolean'
        ]);

        $wl = Wishlist::where('id', $id)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $wl->title = $request->title;
        $wl->description = $request->description;
        $wl->shared = $request->share;
        $wl->save();

        return $wl;
    }

    public function destroy(Request $request, $id): mixed
    {
        $wl = Wishlist::where('id', $id)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $wl->delete();
        return true;
    }
}