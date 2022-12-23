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
use Rapidez\MultipleWishlist\Models\MagentoWishlist;
use Rapidez\MultipleWishlist\Models\Wishlist;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(Request $request): Collection
    {
        // There has to be a way to do this part more succinctly
        return Wishlist::select(['jb_wishlist.*', DB::raw('COUNT(jb_wishlist_item.id) AS item_count')])
            ->where('customer_id', $request->userId)
            ->leftJoin('jb_wishlist_item', 'jb_wishlist_item.wishlist_id', '=', 'jb_wishlist.id')
            ->groupBy('jb_wishlist.id')
            ->get();
    }

    public function show(Request $request, $id): mixed
    {
        $wl = Wishlist::where('id', $id)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        return [$wl, $wl->items()->get()];
    }

    public function shared($token): mixed
    {
        $wl = Wishlist::where('sharing_token', $token)->where('shared', true)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        return [$wl, $wl->items()->get()];
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

        if (!MagentoWishlist::where('customer_id', $request->userId)->first()) {
            $mwl = new MagentoWishlist();
            $mwl->timestamps = false;
            $mwl->customer_id = $request->userId;
            $mwl->shared = false;
            $mwl->sharing_code = md5(uniqid("mwl"));
            $mwl->updated_at = now();
            $mwl->save();
        }

        return $wishlist;
    }

    public function update(Request $request, $id): mixed
    {
        if (!$request->userId || !$id) {
            return false;
        }
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'max:65535',
            'share' => 'required|boolean'
        ]);

        $wl = Wishlist::where('id', $id)->where('customer_id', $request->userId)->first();
        if (!$wl) {
            return 'Wishlist not found';
        }

        $wl->title = $request->title;
        if ($request->description) {
            $wl->description = $request->description;
        }
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

    public function allWithItems(Request $request): mixed
    {
        return Wishlist::with('items')->where('customer_id', $request->userId)->get();
    }
}
