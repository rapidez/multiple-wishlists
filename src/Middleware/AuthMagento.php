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
        if (!$token || $request->userId) {
            abort(403);
        }

        // Query the database to see if the token exists
        $authId = DB::table('oauth_token')
                ->where('token', $token)
                ->where('revoked', 0)
                ->value('customer_id');

        // Abort on no result or otherwise strange invalid output
        if (!$authId) {
            abort(403);
        }

        // Send the user's customer ID through
        $request->userId = $authId;

        return $next($request);
    }
}
