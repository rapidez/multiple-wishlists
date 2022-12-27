<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $table = 'wishlist_item';
    protected $primaryKey = 'wishlist_item_id';

    protected $fillable = ['product_id', 'qty', 'added_at'];

    const CREATED_AT = 'added_at';
    const UPDATED_AT = null;

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