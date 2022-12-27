<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class RapidezWishlistItem extends Model
{
    protected $table = 'rapidez_wishlist_item';

    protected $fillable = ['wishlist_item_id', 'wishlist_id'];

    public function item()
    {
        return $this->belongsTo(WishlistItem::class);
    }
}