<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';

    const CREATED_AT = null;

    public function items()
    {
        return $this->hasMany(WishlistItem::class, 'wishlist_id');
    }

    public function scopeIsCustomer(Builder $query, $id)
    {
        return $query->where('customer_id', $id);
    }
}