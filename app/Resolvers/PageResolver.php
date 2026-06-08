<?php

namespace App\Resolvers;

use Closure;
use App\Models\Page;
use App\Http\Controllers\PageController;
use App\Services\CacheManagerService;

class PageResolver implements ResolverContract
{
    protected $pageController;
    protected $cacheManager;

    public function __construct(
        PageController $pageController,
        CacheManagerService $cacheManager
    ) {
        $this->pageController = $pageController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $page = $this->findPageByLastSegment($slug, $locale);

        if ($page) {
            return $this->handlePageResolution($locale, $slug, $page);
        }

        return $next($payload);
    }

    private function findPageByLastSegment($slug, $locale): ?Page
    {
        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        return $this->cacheManager->remember(
            'page_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Page::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['parent', 'translations', 'parent.translations'])
                    ->first();
            }
        );
    }

    private function handlePageResolution($locale, $requestedPath, Page $page)
    {
        if ($page->is_homepage) {
            return redirect()->route('index', ['locale' => $locale], 301);
        }

        $correctPath = $page->getRecursiveSlug($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->pageController->show($locale, $page);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->pageController->show($locale, $page);
        }

        return redirect()->to($targetUrl, 301);
    }
}
