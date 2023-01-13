<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rapidez\MultipleWishlist\Scopes\CustomerScope;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';

    protected $guarded = [];

    public const CREATED_AT = null;

    protected static function booted()
    {
        static::created(function ($wishlist) {
            $wishlist->sharing_code = md5(uniqid('mwl'));
            $wishlist->save();
        });

        static::addGlobalScope(new CustomerScope);
    }

    public function items()
    {
        return $this->hasMany(WishlistItem::class, 'wishlist_id');
    }

    public function scopeIsCustomer(Builder $query, $id)
    {
        return $query->where('customer_id', $id);
    }
}
