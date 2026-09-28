<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminEmail = config('portfolio.admin_email');
        $user = $request->user();

        // Fail closed: if ADMIN_EMAIL is not set, nobody gets in.
        if (! $adminEmail || ! $user || strcasecmp($user->email, $adminEmail) !== 0) {
            abort(403, 'You are not allowed to access this area.');
        }

        return $next($request);
    }
}
