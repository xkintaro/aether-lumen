<?php

namespace App\Resolvers;

use Closure;
use App\Models\Reference;
use App\Http\Controllers\ReferenceController;
use App\Services\CacheManagerService;

class ReferenceResolver implements ResolverContract
{
    protected $referenceController;
    protected $cacheManager;

    public function __construct(
        ReferenceController $referenceController,
        CacheManagerService $cacheManager
    ) {
        $this->referenceController = $referenceController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $reference = $this->findReferenceBySlug($slug, $locale);

        if ($reference) {
            return $this->handleReferenceResolution($locale, $slug, $reference);
        }

        return $next($payload);
    }

    private function findReferenceBySlug($slug, $locale): ?Reference
    {
        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        return $this->cacheManager->remember(
            'reference_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Reference::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations'])
                    ->first();
            }
        );
    }

    private function handleReferenceResolution($locale, $requestedPath, Reference $reference)
    {
        $correctPath = $reference->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->referenceController->show($locale, $reference);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->referenceController->show($locale, $reference);
        }

        return redirect()->to($targetUrl, 301);
    }
}
