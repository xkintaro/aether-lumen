<?php

namespace App\Resolvers;

use Closure;
use App\Models\Blog;
use App\Http\Controllers\BlogController;
use App\Services\CacheManagerService;

class BlogResolver implements ResolverContract
{
    protected $blogController;
    protected $cacheManager;

    public function __construct(
        BlogController $blogController,
        CacheManagerService $cacheManager
    ) {
        $this->blogController = $blogController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $blog = $this->findBlogBySlug($slug, $locale);

        if ($blog) {
            return $this->handleBlogResolution($locale, $slug, $blog);
        }

        return $next($payload);
    }

    private function findBlogBySlug($slug, $locale): ?Blog
    {
        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        return $this->cacheManager->remember(
            'blog_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Blog::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations'])
                    ->first();
            }
        );
    }

    private function handleBlogResolution($locale, $requestedPath, Blog $blog)
    {
        $correctPath = $blog->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->blogController->show($locale, $blog);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->blogController->show($locale, $blog);
        }

        return redirect()->to($targetUrl, 301);
    }
}
