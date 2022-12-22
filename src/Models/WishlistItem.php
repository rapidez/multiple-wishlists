<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $table = 'wishlist_item';
    protected $primaryKey = 'wishlist_item_id';

    public function magentoWishlist()
    {
        return $this->belongsTo(MagentoWishlist::class);
    }

    public function wishlist()
    {
        return $this->hasOneThrough(Wishlist::class, JbWishlistItem::class);
    }
}