<?php

namespace App\Resolvers;

use Closure;
use App\Models\News;
use App\Http\Controllers\NewsController;
use App\Services\CacheManagerService;

class NewsResolver implements ResolverContract
{
    protected $newsController;
    protected $cacheManager;

    public function __construct(
        NewsController $newsController,
        CacheManagerService $cacheManager
    ) {
        $this->newsController = $newsController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $news = $this->findNewsBySlug($slug, $locale);

        if ($news) {
            return $this->handleNewsResolution($locale, $slug, $news);
        }

        return $next($payload);
    }

    private function findNewsBySlug($slug, $locale): ?News
    {
        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        return $this->cacheManager->remember(
            'news_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return News::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations'])
                    ->first();
            }
        );
    }

    private function handleNewsResolution($locale, $requestedPath, News $news)
    {
        $correctPath = $news->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->newsController->show($locale, $news);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->newsController->show($locale, $news);
        }

        return redirect()->to($targetUrl, 301);
    }
}
