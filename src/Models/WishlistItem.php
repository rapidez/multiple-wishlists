<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $table = 'wishlist_item';
    protected $primaryKey = 'wishlist_item_id';

    protected $fillable = ['product_id', 'qty', 'description', 'added_at'];

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
        return $this->hasOneThrough(RapidezWishlist::class, RapidezWishlistItem::class);
    }

    public function rapidezItem()
    {
        return $this->hasOne(RapidezWishlistItem::class, 'wishlist_item_id');
    }
}
