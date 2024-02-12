<?php

namespace Rapidez\MultipleWishlist\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CustomerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('customer_id', auth()->user()->entity_id);
    }
}
