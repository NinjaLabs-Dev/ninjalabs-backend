<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Domain;

class CustomDomain
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hostname = $request->getHost();
        $domain = Domain::where('domain', $hostname)->firstOrFail();

        $request->merge([
            'domain' => $domain
        ]);

        return $next($domain);
    }
}
