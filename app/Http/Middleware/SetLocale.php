<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!isset($request->cookie()['locale'])) {
            $locale = $request->getPreferredLanguage(["de", "fr", "it"]);
            app()->setLocale($locale);
            return $next($request)->withCookie(cookie('locale', $locale, 60 * 24 * 365));
        } else {
            app()->setLocale($request->cookie()['locale']);
            return $next($request);
        }
    }
}
