<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rapidez\Core\Models\Store;

class RapidezWishlist extends Model
{
    protected $table = 'rapidez_wishlist';

    public function items()
    {
        return $this->hasManyThrough(
            WishlistItem::class,
            RapidezWishlistItem::class,
            'wishlist_id',
            'wishlist_item_id',
            'id',
            'wishlist_item_id'
        );
    }

    public function rapidezItems()
    {
        return $this->hasMany(RapidezWishlistItem::class, 'wishlist_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function scopeIsCustomer(Builder $query, $id)
    {
        return $query->where('customer_id', $id);
    }

    public function scopeIsShared(Builder $query, $token)
    {
        return $query->where('sharing_token', $token)->where('shared', true);
    }
}
