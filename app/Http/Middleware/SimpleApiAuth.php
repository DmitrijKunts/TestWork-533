<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleApiAuth
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
        if ($request->bearerToken() != config('app.api_key')) {
            return response()->json([
                "success" => false,
                "message" => "The token expired."
            ], 409);
        }

        return $next($request);
    }
}
