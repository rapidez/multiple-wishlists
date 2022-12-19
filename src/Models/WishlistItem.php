<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;
use Rapidez\Core\Models\Product;
use Rapidez\Core\Models\Store;

class WishlistItem extends Model
{
    protected $table = 'jb_wishlist_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'product_id',
        'qty'
    ];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}