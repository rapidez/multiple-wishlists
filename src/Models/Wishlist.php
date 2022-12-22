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
        return $this->hasMany(JbWishlistItem::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}