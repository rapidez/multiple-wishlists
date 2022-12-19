<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;
use Rapidez\Core\Models\Store;

class Wishlist extends Model
{
    protected $table = 'jb_wishlist';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description'
    ];

    public function items()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}