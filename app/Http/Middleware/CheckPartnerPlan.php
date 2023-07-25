<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPartnerPlan
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->user()->selectedPartner()->plan, ['annuaire-plus', 'gestion', 'gestion-commerciale']) && $request->user()->rank !== 'admin') {
            return redirect()->route('partner.settings.plan.index');
        }

        return $next($request);
    }
}
