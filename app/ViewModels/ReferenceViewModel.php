<?php

namespace App\ViewModels;

use App\Models\Reference;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use App\Traits\ResolvesVoyagerFile;
use Carbon\Carbon;

class ReferenceViewModel
{
    use ResolvesVoyagerFile;

    protected $reference;
    protected $locale;
    protected $translation;

    public function __construct(Reference $reference, $locale)
    {
        $this->reference = $reference;
        $this->locale = $locale;
        $this->translation = $reference->translate($locale);
    }

    public function getModel()
    {
        return $this->reference;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->reference->slug ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->reference->title ?? null;
    }

    public function getClient()
    {
        return $this->translation->client ?? $this->reference->client ?? null;
    }

    public function getLocation(): mixed
    {
        return $this->translation->location ?? $this->reference->location ?? null;
    }

    public function getURL()
    {
        return $this->reference->url ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->reference->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->reference->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->reference->content ?? null;
    }

    public function getCreatedDate($format = 'd M Y')
    {
        return Carbon::parse($this->reference->created_at)->locale($this->locale)->translatedFormat($format);
    }

    public function getCompletionDate($format = 'd M Y')
    {
        if (!$this->reference->completion_date)
            return null;
        return Carbon::parse($this->reference->completion_date)->locale($this->locale)->translatedFormat($format);
    }

    public function getIcon()
    {
        return $this->reference->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->reference->image_url)) {
            return $this->reference->image_url;
        }

        return $this->resolveFileUrl($this->reference->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->reference->banner_url)) {
            return $this->reference->banner_url;
        }

        return $this->resolveFileUrl($this->reference->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->reference->video_url)) {
            return $this->reference->video_url;
        }

        return $this->resolveFileUrl($this->reference->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->reference->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->reference->video_gallery, $index);
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->reference->meta_title ?: ($this->getTitle() ? $this->getTitle() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->reference->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->reference->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->reference->getPath($this->locale);
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

        $listingPage = $catalogService->getPageByRouteKey('routes.references');

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
