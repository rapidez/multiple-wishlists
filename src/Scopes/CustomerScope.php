<?php

namespace Rapidez\MultipleWishlist\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Rapidez\MultipleWishlist\Requests\AuthenticatedRequest;

class CustomerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Use AuthenticatedRequest's authentication
        $request = AuthenticatedRequest::capture();
        $request->prepareForValidation();

        $builder->where('customer_id', $request->customer_id);
    }
}
