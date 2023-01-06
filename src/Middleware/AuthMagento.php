<?php

namespace Rapidez\MultipleWishlist\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthMagento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Filter out bad requests immediately
        $token = $request->bearerToken();
        abort_if(!$token || $request->customer_id, 403);

        // Query the database to see if the token exists
        $authId = DB::table('oauth_token')
                ->where('token', $token)
                ->where('revoked', 0)
                ->value('customer_id');

        // Abort on no result or otherwise strange invalid output
        abort_if(!$authId, 403);

        // Send the user's customer ID through
        $request->customer_id = $authId;
        $request->request->add(['customer_id' => $authId]);

        return $next($request);
    }
}
