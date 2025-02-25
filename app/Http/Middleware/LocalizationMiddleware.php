<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        // Get the requested language from the 'Accept-Language' header
        $requestedLanguage = $request->header('Accept-Language');

        // Temporarily set the application locale to the requested language if it's supported
        if (in_array($requestedLanguage, ['en', 'ar'])) {
            App::setLocale($requestedLanguage);
        }

        return $next($request);

    }
}
