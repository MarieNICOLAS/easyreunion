<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPartnerType
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (! in_array($request->user()->rank, ['admin', 'partner']) || $request->user()->selectedPartner()->type !== $type) {
            abort(403);
        }

        return $next($request);
    }
}
