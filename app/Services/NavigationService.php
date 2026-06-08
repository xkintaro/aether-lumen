<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Category;
use App\Models\News;
use App\Models\SocialMedia;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\ViewModels\PageViewModel;
use App\ViewModels\CategoryViewModel;
use App\ViewModels\NewsViewModel;
use App\ViewModels\SocialMediaViewModel;

class NavigationService
{
    protected $cacheManager;
    protected $catalogService;

    public function __construct(CacheManagerService $cacheManager, CatalogService $catalogService)
    {
        $this->cacheManager = $cacheManager;
        $this->catalogService = $catalogService;
    }

    public function getMenu(string $locale): Collection
    {
        return $this->cacheManager->remember('menu', [$locale], function () use ($locale) {

            $rootCategories = Category::where('status', 1)
                ->whereIsRoot()
                ->orderBy('order', 'asc')
                ->with('translations')
                ->get();

            $pages = Page::whereNull('parent_id')
                ->where('menu_show', 1)
                ->where('status', 1)
                ->orderBy('order', 'asc')
                ->with('translations')
                ->with(['children' => function ($q) {
                    $q->where('menu_show', 1)->where('status', 1)->orderBy('order', 'asc')->with('translations');
                }])
                ->get();

            return $this->mapRecursive($pages, $locale, $rootCategories);
        });
    }

    public function getFooterData(string $locale): array
    {
        return $this->cacheManager->remember('footer_data', [$locale], function () use ($locale) {

            $pages = Page::where('status', 1)
                ->whereNull('parent_id')
                ->where('footer_show', 1)
                ->where('status', 1)
                ->orderBy('order', 'asc')
                ->with('translations')
                ->get()
                ->map(fn($item) => new PageViewModel($item, $locale, $this->catalogService));

            $categories = Category::where('status', 1)
                ->whereIsRoot()
                ->orderBy('order', 'asc')
                ->with('translations')
                ->get()
                ->map(fn($item) => new CategoryViewModel($item, $locale, $this->catalogService));

            $news = News::where('status', 1)
                ->orderBy('order', 'asc')
                ->take(5)
                ->with('translations')
                ->get()
                ->map(fn($item) => new NewsViewModel($item, $locale));

            $socialMedias = SocialMedia::where('status', 1)
                ->orderBy('order', 'asc')
                ->with('translations')
                ->get()
                ->map(fn($item) => new SocialMediaViewModel($item, $locale));

            return [
                'pages' => $pages,
                'categories' => $categories,
                'news' => $news,
                'social_medias' => $socialMedias
            ];
        });
    }

    private function mapRecursive($items, $locale, $rootCategories = null)
    {
        return $items->map(function ($item) use ($locale, $rootCategories) {

            $translation = $item->translate($locale);
            $title = $translation->title ?? ($translation->name ?? ($item->title ?? $item->name ?? ''));

            $path = method_exists($item, 'getPath') ? $item->getPath($locale) : '';

            if (empty($path) || $path === '#') {
                $url = '#';
            } elseif (Str::startsWith($path, ['http://', 'https://'])) {
                $url = $path;
            } else {
                $url = route('resolver', ['locale' => $locale, 'slug' => $path]);
            }

            $children = collect();

            if ($item instanceof Page && $item->menu_data_source === 'categories' && $rootCategories) {
                $children = $this->mapRecursive($rootCategories, $locale);
            } elseif (isset($item->children) && $item->children->isNotEmpty()) {
                $filteredChildren = $item->children->filter(function ($child) {
                    return $child->status == 1 && ($child->menu_show ?? true);
                })->sortBy('order');

                $children = $this->mapRecursive($filteredChildren, $locale);
            }

            return (object) [
                'id'       => $item->id,
                'title'    => $title,
                'url'      => $url,
                'children' => $children
            ];
        });
    }
}
