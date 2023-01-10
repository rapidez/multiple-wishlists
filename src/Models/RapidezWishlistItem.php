<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class RapidezWishlistItem extends Model
{
    protected $table = 'rapidez_wishlist_item';

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(WishlistItem::class);
    }
}
