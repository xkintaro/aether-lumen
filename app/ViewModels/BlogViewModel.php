<?php

namespace App\ViewModels;

use App\Models\Blog;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use Carbon\Carbon;
use App\Traits\ResolvesVoyagerFile;

class BlogViewModel
{
    use ResolvesVoyagerFile;

    protected $blog;
    protected $locale;
    protected $translation;

    public function __construct(Blog $blog, $locale)
    {
        $this->blog = $blog;
        $this->locale = $locale;
        $this->translation = $blog->translate($locale);
    }

    public function getModel()
    {
        return $this->blog;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->blog->slug ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->blog->title ?? null;
    }

    public function getSubtitle()
    {
        return $this->translation->subtitle ?? $this->blog->subtitle ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->blog->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->blog->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->blog->content ?? null;
    }

    public function getIcon()
    {
        return $this->blog->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->blog->image_url)) {
            return $this->blog->image_url;
        }

        return $this->resolveFileUrl($this->blog->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->blog->banner_url)) {
            return $this->blog->banner_url;
        }

        return $this->resolveFileUrl($this->blog->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->blog->video_url)) {
            return $this->blog->video_url;
        }

        return $this->resolveFileUrl($this->blog->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->blog->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->blog->video_gallery, $index);
    }

    public function getCreatedDate($format = 'd M Y')
    {
        return Carbon::parse($this->blog->created_at)->locale($this->locale)->translatedFormat($format);
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->blog->meta_title ?: ($this->getTitle() ? $this->getTitle() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->blog->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->blog->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->blog->getPath($this->locale);
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

        $listingPage = $catalogService->getPageByRouteKey('routes.blog');

        if ($listingPage) {
            $pageTrans = $listingPage->translate($this->locale);
            $breadcrumbs->push([
                'title' => $pageTrans->title ?? $listingPage->title,
                'url' => $listingPage->getPath($this->locale),
                'active' => false
            ]);
        }

        $breadcrumbs->push(['title' => $this->getTitle(), 'url' => $this->getPath(), 'active' => true]);

        return $breadcrumbs;
    }
}
