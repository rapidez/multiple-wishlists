<?php

namespace Rapidez\MultipleWishlist\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class CustomerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Filter out bad requests immediately
        $token = request()->bearerToken();
        abort_if(!$token, 403);

        // Query the database to see if the token exists
        $authId = DB::table('oauth_token')
                ->where('token', $token)
                ->where('revoked', 0)
                ->value('customer_id');

        // Abort on no result or otherwise strange invalid output
        abort_if(!$authId, 403);

        $builder->where('customer_id', $authId);
    }
}
