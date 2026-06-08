<?php

namespace App\ViewModels;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use App\Traits\ResolvesVoyagerFile;

class CategoryViewModel
{
    use ResolvesVoyagerFile;

    protected $category;
    protected $locale;
    protected $translation;
    protected $catalogService;

    public function __construct(Category $category, $locale, CatalogService $catalogService)
    {
        $this->category = $category;
        $this->locale = $locale;
        $this->translation = $category->translate($locale);
        $this->catalogService = $catalogService;
    }

    public function getModel()
    {
        return $this->category;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->category->slug ?? null;
    }

    public function getName()
    {
        return $this->translation->name ?? $this->category->name ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->category->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->category->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->category->content ?? null;
    }

    public function getIcon()
    {
        return $this->category->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->category->image_url)) {
            return $this->category->image_url;
        }

        return $this->resolveFileUrl($this->category->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->category->banner_url)) {
            return $this->category->banner_url;
        }

        return $this->resolveFileUrl($this->category->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->category->video_url)) {
            return $this->category->video_url;
        }

        return $this->resolveFileUrl($this->category->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->category->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->category->video_gallery, $index);
    }

    public function getProducts($limit = null)
    {
        return $this->catalogService->getProductsForCategory($this->category, $this->locale, $limit);
    }

    public function getChildren(): Collection
    {
        $catalogService = $this->catalogService;
        return $this->category->children()->where('status', 1)->orderBy('order', 'asc')->get()
            ->map(fn($child) => new CategoryViewModel($child, $this->locale, $catalogService));
    }

    public function getParent()
    {
        $parent = $this->category->parent;
        return $parent ? new CategoryViewModel($parent, $this->locale, $this->catalogService) : null;
    }
    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->category->meta_title ?: ($this->getName() ? $this->getName() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->category->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->category->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->category->getPath($this->locale);
        if (empty($path) || $path === '#')
            return '#';
        if (str_starts_with($path, 'http'))
            return $path;

        return url($this->locale . '/' . ltrim($path, '/'));
    }

    public function getBreadcrumbs(): Collection
    {
        $breadcrumbs = collect();
        $catalogService = app(CatalogService::class);
        $home = $catalogService->getHomepage($this->locale);

        $breadcrumbs->push(['title' => $home->title, 'url' => $home->url, 'active' => false]);

        $listingPage = $catalogService->getPageByRouteKey('routes.products');

        if ($listingPage) {
            $pTrans = $listingPage->translate($this->locale);
            $breadcrumbs->push([
                'title' => $pTrans->title ?? $listingPage->title,
                'url' => $listingPage->getPath($this->locale),
                'active' => false
            ]);
        }

        if ($this->category->ancestors && $this->category->ancestors->isNotEmpty()) {
            foreach ($this->category->ancestors as $ancestor) {
                $ancTrans = $ancestor->translate($this->locale);
                $breadcrumbs->push([
                    'title' => $ancTrans->name ?? $ancestor->name,
                    'url' => url($this->locale . '/' . ltrim($ancestor->getPath($this->locale), '/')),
                    'active' => false
                ]);
            }
        }

        $breadcrumbs->push(['title' => $this->getName(), 'url' => $this->getPath(), 'active' => true]);

        return $breadcrumbs;
    }
}
