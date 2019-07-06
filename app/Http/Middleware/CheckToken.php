<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Returns header value with default as fallback
        $_TOKEN  = $request->get('token', null);

        if ( $_TOKEN == null ) {
            return response()->json([
                'status'     => false,
                'statusCode' => 'TOKEN_KEY_NOT_PROVIDER',
                'data'       => [],
                'messages'   => 'Not valid Token provider.',
                'errors'     => []
            ], 401);
        }

        if ( $_TOKEN != config('token.LEAD_TOKEN')) {
            return response()->json([
                'status'     => false,
                'statusCode' => 'TOKEN_KEY_INVAID',
                'data'       => [],
                'messages'   => 'Token not match.',
                'errors'     => []
            ], 401);
        }

        return $next($request);
    }
}
