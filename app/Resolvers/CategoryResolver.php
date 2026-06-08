<?php

namespace App\Resolvers;

use Closure;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Services\CacheManagerService;

class CategoryResolver implements ResolverContract
{
    protected $categoryController;
    protected $cacheManager;

    public function __construct(
        CategoryController $categoryController,
        CacheManagerService $cacheManager
    ) {
        $this->categoryController = $categoryController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $category = $this->findCategoryByLastSegment($slug, $locale);

        if ($category) {
            return $this->handleCategoryResolution($locale, $slug, $category);
        }

        return $next($payload);
    }

    private function findCategoryByLastSegment($slug, $locale): ?Category
    {
        $lastSegment = $this->getLastSegment($slug);

        return $this->cacheManager->remember(
            'category_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Category::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations', 'ancestors', 'ancestors.translations'])
                    ->first();
            }
        );
    }

    private function getLastSegment($slug): string
    {
        $segments = explode('/', $slug);
        return end($segments);
    }

    private function handleCategoryResolution($locale, $requestedPath, Category $category)
    {
        $correctPath = $category->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->categoryController->show($locale, $category);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->categoryController->show($locale, $category);
        }

        return redirect()->to($targetUrl, 301);
    }
}
