<?php

namespace App\ViewModels;

use App\Models\Page;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use App\Traits\ResolvesVoyagerFile;

class PageViewModel
{
    use ResolvesVoyagerFile;

    protected $page;
    protected $locale;
    protected $translation;
    protected $catalogService;

    public function __construct(Page $page, $locale, CatalogService $catalogService)
    {
        $this->page = $page;
        $this->locale = $locale;
        $this->translation = $page->translate($locale);
        $this->catalogService = $catalogService;
    }

    public function getModel()
    {
        return $this->page;
    }

    public function getPath()
    {
        return $this->page->getPath($this->locale);
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->page->slug ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->page->title ?? null;
    }

    public function getSubtitle()
    {
        return $this->translation->subtitle ?? $this->page->subtitle ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->page->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->page->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->page->content ?? null;
    }

    public function getIcon()
    {
        return $this->page->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->page->image_url)) {
            return $this->page->image_url;
        }

        return $this->resolveFileUrl($this->page->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->page->banner_url)) {
            return $this->page->banner_url;
        }

        return $this->resolveFileUrl($this->page->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->page->video_url)) {
            return $this->page->video_url;
        }

        return $this->resolveFileUrl($this->page->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->page->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->page->video_gallery, $index);
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->page->meta_title ?: ($this->getTitle() ? $this->getTitle() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->page->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->page->seo_text ?? null;
    }

    public function getBladeName()
    {
        return $this->translation->blade_name ?? $this->page->blade_name ?? null;
    }

    public function getCounters($limit = null): Collection
    {
        return $this->catalogService->getCounters($this->locale, $limit);
    }

    public function getBrands($limit = null): Collection
    {
        return $this->catalogService->getBrands($this->locale, $limit);
    }

    public function getSliders($limit = null): Collection
    {
        return $this->catalogService->getSliders($this->locale, $limit);
    }

    public function getBlogs($limit = null): Collection
    {
        return $this->catalogService->getBlogs($this->locale, $limit);
    }

    public function getNews($limit = null): Collection
    {
        return $this->catalogService->getNews($this->locale, $limit);
    }

    public function getProducts($limit = null): Collection
    {
        return $this->catalogService->getProducts($this->locale, $limit);
    }

    public function getCategories($limit = null): Collection
    {
        return $this->catalogService->getCategories($this->locale, $limit);
    }

    public function getCertificates($limit = null): Collection
    {
        return $this->catalogService->getCertificates($this->locale, $limit);
    }

    public function getPopups($limit = null): Collection
    {
        return $this->catalogService->getPopups($this->locale, $limit);
    }

    public function getSocialMedias($limit = null): Collection
    {
        return $this->catalogService->getSocialMedias($this->locale, $limit);
    }

    public function getTestimonials($limit = null): Collection
    {
        return $this->catalogService->getTestimonials($this->locale, $limit);
    }

    public function getProjects($limit = null): Collection
    {
        return $this->catalogService->getProjects($this->locale, $limit);
    }

    public function getReferences($limit = null): Collection
    {
        return $this->catalogService->getReferences($this->locale, $limit);
    }

    public function getPhotos($limit = null): Collection
    {
        return $this->catalogService->getPhotos($this->locale, $limit);
    }

    public function getVideos($limit = null): Collection
    {
        return $this->catalogService->getVideos($this->locale, $limit);
    }

    public function getFaqs($limit = null): Collection
    {
        return $this->catalogService->getFaqs($this->locale, $limit);
    }

    public function getRootCategories($limit = null): Collection
    {
        $rootCategories = $this->getCategories()->filter(fn($vm) => $vm->getModel()->parent_id === null);
        return $limit ? $rootCategories->take($limit) : $rootCategories;
    }

    public function getBreadcrumbs(): Collection
    {
        $breadcrumbs = collect();

        $home = $this->catalogService->getHomepage($this->locale);
        $isHomePage = ($this->page->id === $home->id);

        if (!$isHomePage) {
            $breadcrumbs->push(['title' => $home->title, 'url' => $home->url, 'active' => false]);
        }

        $parent = $this->page->parent;
        $parentsChain = collect();

        while ($parent) {
            $parentTrans = $parent->translate($this->locale);
            $parentsChain->prepend([
                'title' => $parentTrans->title ?? $parent->title,
                'url' => $parent->getPath($this->locale),
                'active' => false
            ]);
            $parent = $parent->parent;
        }
        $breadcrumbs = $breadcrumbs->merge($parentsChain);

        $breadcrumbs->push([
            'title' => $this->getTitle(),
            'url' => $isHomePage ? $home->url : $this->page->getPath($this->locale),
            'active' => true
        ]);

        return $breadcrumbs;
    }
}
