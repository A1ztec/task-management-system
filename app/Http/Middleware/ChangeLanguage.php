<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLanguage = ['ar', 'en'];

        $language = $request->header('Accept-Language');

        if ($language) {
            if (in_array($language, $supportedLanguage)) {
                App::setLocale($language);
            } else {
                App::setLocale(config('app.fallback_locale'));
            }
        }
        return $next($request);
    }
}
