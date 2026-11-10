<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PbMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Payagan ang Punong Barangay, Admin, at Staff
        if (auth()->check() && in_array(auth()->user()->role, ['Punong Barangay', 'Admin', 'Staff'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}