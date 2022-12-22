<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class MagentoWishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';

    public function items()
    {
        return $this->hasMany(WishlistItem::class);
    }
}