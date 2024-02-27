<?php

namespace Rapidez\MultipleWishlist\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEntity extends Model
{
    protected $table = 'catalog_product_entity';
    protected $primaryKey = 'entity_id';
}
