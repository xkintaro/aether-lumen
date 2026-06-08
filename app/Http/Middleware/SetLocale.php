<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        $supportedLocales = config('voyager.multilingual.locales');

        if (!$locale || !in_array($locale, $supportedLocales)) {
            abort(404);
        }

        app()->setLocale($locale);

        session()->put('locale', $locale);

        return $next($request);
    }
}
