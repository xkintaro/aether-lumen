<?php

namespace App\ViewModels;

use App\Models\News;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use Carbon\Carbon;
use App\Traits\ResolvesVoyagerFile;

class NewsViewModel
{
    use ResolvesVoyagerFile;

    protected $news;
    protected $locale;
    protected $translation;

    public function __construct(News $news, $locale)
    {
        $this->news = $news;
        $this->locale = $locale;
        $this->translation = $news->translate($locale);
    }

    public function getModel()
    {
        return $this->news;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->news->slug ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->news->title ?? null;
    }

    public function getSubtitle()
    {
        return $this->translation->subtitle ?? $this->news->subtitle ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->news->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->news->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->news->content ?? null;
    }

    public function getIcon()
    {
        return $this->news->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->news->image_url)) {
            return $this->news->image_url;
        }

        return $this->resolveFileUrl($this->news->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->news->banner_url)) {
            return $this->news->banner_url;
        }

        return $this->resolveFileUrl($this->news->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->news->video_url)) {
            return $this->news->video_url;
        }

        return $this->resolveFileUrl($this->news->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->news->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->news->video_gallery, $index);
    }

    public function getCreatedDate($format = 'd M Y')
    {
        return Carbon::parse($this->news->created_at)->locale($this->locale)->translatedFormat($format);
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->news->meta_title ?: ($this->getTitle() ? $this->getTitle() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->news->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->news->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->news->getPath($this->locale);
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

        $mediaPage = $catalogService->getPageByRouteKey('routes.media');
        $mediaUrl = $mediaPage
            ? $mediaPage->getPath($this->locale)
            : url($this->locale . '/' . __('routes.media', [], $this->locale));

        $breadcrumbs->push([
            'title' => __('ui.search_titles.news', [], $this->locale),
            'url' => $mediaUrl,
            'active' => false
        ]);

        $breadcrumbs->push(['title' => $this->getTitle(), 'url' => $this->getPath(), 'active' => true]);

        return $breadcrumbs;
    }
}
