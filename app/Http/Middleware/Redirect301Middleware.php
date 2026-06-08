<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CacheManagerService;

class Redirect301Middleware
{
    public function __construct(protected CacheManagerService $cacheManager)
    {
        //
    }

    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();

        $redirects = $this->cacheManager->remember('redirect_301', [], function () {
            return \App\Models\Redirect301::where('status', 1)->get();
        });

        $redirect = $redirects->first(function ($item) use ($path) {
            return $item->old_url === $path || ltrim($item->old_url, '/') === ltrim($path, '/');
        });

        if ($redirect) {
            return redirect($redirect->new_url, 301);
        }

        return $next($request);
    }

}
