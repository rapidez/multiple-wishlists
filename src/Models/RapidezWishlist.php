<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rapidez\Core\Models\Store;
use Rapidez\MultipleWishlist\Scopes\CustomerScope;

class RapidezWishlist extends Model
{
    protected $table = 'rapidez_wishlist';

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($wishlist) {
            $wishlist->sharing_token = md5(uniqid('wl'));
            $wishlist->store_id = config('rapidez.store');
            $wishlist->save();

            // Create Magento wishlist in case it doesn't already exist
            if (!Wishlist::where('customer_id', $wishlist->customer_id)->first()) {
                $magentoWishlist = new Wishlist(['customer_id' => $wishlist->customer_id]);
                $magentoWishlist->save();
            }
        });

        static::addGlobalScope(new CustomerScope);
    }

    public function items()
    {
        return $this->hasManyThrough(
            WishlistItem::class,
            RapidezWishlistItem::class,
            'wishlist_id', 'wishlist_item_id',
            'id', 'wishlist_item_id',
        );
    }

    public function rapidezItems()
    {
        return $this->hasMany(RapidezWishlistItem::class, 'wishlist_id');
    }

    public function scopeIsShared(Builder $query, $token)
    {
        return $query->where('sharing_token', $token)->where('shared', true);
    }
}
