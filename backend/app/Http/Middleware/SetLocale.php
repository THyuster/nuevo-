<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language');

        if (in_array($locale, ['en', 'es'])) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('es');
        }

        return $next($request);
    }
}
