<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;
use Rapidez\Core\Models\Store;

class Wishlist extends Model
{
    protected $table = 'jb_wishlist';
    protected $primaryKey = 'id';

    public function items()
    {
        return $this->hasManyThrough(WishlistItem::class, JbWishlistItem::class, 'wishlist_id', 'wishlist_item_id', 'id', 'wishlist_item_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}