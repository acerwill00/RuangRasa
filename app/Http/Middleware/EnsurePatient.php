<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePatient
{
    /**
     * Redirect admin users away from patient-only routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect('/admin/dashboard')
                ->with('error', 'Admin accounts cannot access the booking flow.');
        }

        return $next($request);
    }
}
