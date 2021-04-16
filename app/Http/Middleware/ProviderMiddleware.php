<?php

namespace App\Http\Middleware;

use App\Models\ServiceProvider;
use Closure;
use Illuminate\Http\Request;

class ProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */



    public function handle(Request $request, Closure $next)
    {
        if ($request->user() instanceof ServiceProvider) {
            return $next($request);
        }

        return response()->json('Not Authorized', 401);

    }
}
