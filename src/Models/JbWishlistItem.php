<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class JbWishlistItem extends Model
{
    protected $table = 'jb_wishlist_item';
    protected $primaryKey = 'id';

    public function magentoItem()
    {
        return $this->hasOne(MagentoWishlistItem::class);
    }
}