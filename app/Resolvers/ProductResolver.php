<?php

namespace App\Resolvers;

use Closure;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Services\CacheManagerService;

class ProductResolver implements ResolverContract
{
    protected $productController;
    protected $cacheManager;

    public function __construct(
        ProductController $productController,
        CacheManagerService $cacheManager
    ) {
        $this->productController = $productController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $product = $this->findProductByLastSegment($slug, $locale);

        if ($product) {
            return $this->handleProductResolution($locale, $slug, $product);
        }

        return $next($payload);
    }

    private function findProductByLastSegment($slug, $locale): ?Product
    {
        $lastSegment = $this->getLastSegment($slug);

        return $this->cacheManager->remember(
            'product_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Product::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations', 'category', 'category.translations', 'category.ancestors', 'category.ancestors.translations'])
                    ->first();
            }
        );
    }

    private function getLastSegment($slug): string
    {
        $segments = explode('/', $slug);
        return end($segments);
    }

    private function handleProductResolution($locale, $requestedPath, Product $product)
    {
        $correctPath = $product->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->productController->show($locale, $product);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->productController->show($locale, $product);
        }

        return redirect()->to($targetUrl, 301);
    }
}
