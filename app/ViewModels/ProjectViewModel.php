<?php

namespace App\ViewModels;

use App\Models\Project;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use Carbon\Carbon;
use App\Traits\ResolvesVoyagerFile;

class ProjectViewModel
{
    use ResolvesVoyagerFile;

    protected $project;
    protected $locale;
    protected $translation;

    public function __construct(Project $project, $locale)
    {
        $this->project = $project;
        $this->locale = $locale;
        $this->translation = $project->translate($locale);
    }

    public function getModel()
    {
        return $this->project;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->project->slug ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->project->title ?? null;
    }

    public function getClient()
    {
        return $this->translation->client ?? $this->project->client ?? null;
    }

    public function getLocation(): mixed
    {
        return $this->translation->location ?? $this->project->location ?? null;
    }

    public function getURL()
    {
        return $this->project->url ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->project->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->project->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->project->content ?? null;
    }

    public function getCreatedDate($format = 'd M Y')
    {
        return Carbon::parse($this->project->created_at)->locale($this->locale)->translatedFormat($format);
    }

    public function getCompletionDate($format = 'd M Y')
    {
        if (!$this->project->completion_date)
            return null;
        return Carbon::parse($this->project->completion_date)->locale($this->locale)->translatedFormat($format);
    }

    public function getIcon()
    {
        return $this->project->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->project->image_url)) {
            return $this->project->image_url;
        }

        return $this->resolveFileUrl($this->project->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->project->banner_url)) {
            return $this->project->banner_url;
        }

        return $this->resolveFileUrl($this->project->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->project->video_url)) {
            return $this->project->video_url;
        }

        return $this->resolveFileUrl($this->project->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->project->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->project->video_gallery, $index);
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->project->meta_title ?: ($this->getTitle() ? $this->getTitle() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->project->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->project->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->project->getPath($this->locale);
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

        $listingPage = $catalogService->getPageByRouteKey('routes.projects');

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
