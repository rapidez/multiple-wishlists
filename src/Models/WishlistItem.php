<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WishlistItem extends Model
{
    protected $table = 'wishlist_item';
    protected $primaryKey = 'wishlist_item_id';

    protected $guarded = [];

    protected $casts = [
        'qty' => 'integer'
    ];

    public const CREATED_AT = 'added_at';
    public const UPDATED_AT = null;

    protected static function booted()
    {
        static::created(function ($item) {
            $item->store_id = config('rapidez.store');
            $item->save();
        });
    }

    public function magentoWishlist()
    {
        return $this->belongsTo(Wishlist::class, 'wishlist_id');
    }

    public function rapidezWishlist()
    {
        return $this->hasOneThrough(
            RapidezWishlist::class,
            RapidezWishlistItem::class,
            'wishlist_item_id', 'id',
            null, 'wishlist_id'
        );
    }

    public function rapidezItem()
    {
        return $this->hasOne(RapidezWishlistItem::class, 'wishlist_item_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductEntity::class, 'product_id');
    }
}
