<?php

namespace App\ViewModels;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Services\CatalogService;
use App\Traits\ResolvesVoyagerFile;

class ProductViewModel
{
    use ResolvesVoyagerFile;

    protected $product;
    protected $locale;
    protected $translation;

    public function __construct(Product $product, $locale)
    {
        $this->product = $product;
        $this->locale = $locale;
        $this->translation = $product->translate($locale);
    }

    public function getModel()
    {
        return $this->product;
    }

    public function getSlug()
    {
        return $this->translation->slug ?? $this->product->slug ?? null;
    }

    public function getName()
    {
        return $this->translation->name ?? $this->product->name ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->product->excerpt ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->product->description ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->product->content ?? null;
    }

    public function getTable()
    {
        return $this->translation->table_html ?? $this->product->table_html ?? null;
    }

    public function getSku()
    {
        return $this->product->sku;
    }

    public function getProductCode()
    {
        return $this->product->product_code;
    }

    public function getOemNo()
    {
        return $this->product->oem_no;
    }

    public function getBarcode()
    {
        return $this->product->barcode;
    }

    public function getIcon()
    {
        return $this->product->icon ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->product->image_url)) {
            return $this->product->image_url;
        }

        return $this->resolveFileUrl($this->product->image) ?? null;
    }

    public function getBanner(): ?string
    {
        if (!empty($this->product->banner_url)) {
            return $this->product->banner_url;
        }

        return $this->resolveFileUrl($this->product->banner) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->product->video_url)) {
            return $this->product->video_url;
        }

        return $this->resolveFileUrl($this->product->video) ?? null;
    }

    public function getGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->product->image_gallery, $index);
    }

    public function getVideoGallery(?int $index = null)
    {
        return $this->resolveGalleryUrls($this->product->video_gallery, $index);
    }

    public function getCategoryName()
    {
        if ($this->product->category) {
            return $this->product->category->translate($this->locale)->name ?? $this->product->category->name;
        }
        return null;
    }

    public function getCategoryPath()
    {
        if ($this->product->category) {
            $path = $this->product->category->getPath($this->locale);
            return url($this->locale . '/' . ltrim($path, '/'));
        }
        return null;
    }

    public function getSeoTitle()
    {
        return $this->translation->meta_title ?: $this->product->meta_title ?: ($this->getName() ? $this->getName() . ' | ' . setting('site.title') : setting('site.title'));
    }

    public function getMetaDescription()
    {
        $description = $this->translation->meta_description ?: $this->product->meta_description ?: $this->getExcerpt() ?: setting('site.description');
        return \Illuminate\Support\Str::limit(strip_tags($description ?? null), 160);
    }

    public function getSeoText()
    {
        return $this->translation->seo_text ?? $this->product->seo_text ?? null;
    }

    public function getPath()
    {
        $path = $this->product->getPath($this->locale);

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

        if ($this->product->category) {
            $category = $this->product->category;

            if ($category->ancestors && $category->ancestors->isNotEmpty()) {
                foreach ($category->ancestors as $ancestor) {
                    $ancTrans = $ancestor->translate($this->locale);
                    $breadcrumbs->push([
                        'title' => $ancTrans->name ?? $ancestor->name,
                        'url' => url($this->locale . '/' . ltrim($ancestor->getPath($this->locale), '/')),
                        'active' => false
                    ]);
                }
            } else {
                $catChain = collect();
                $tempCat = $category->parent;
                while ($tempCat) {
                    $catTrans = $tempCat->translate($this->locale);
                    $catChain->prepend([
                        'title' => $catTrans->name ?? $tempCat->name,
                        'url' => url($this->locale . '/' . ltrim($tempCat->getPath($this->locale), '/')),
                        'active' => false
                    ]);
                    $tempCat = $tempCat->parent;
                }
                $breadcrumbs = $breadcrumbs->merge($catChain);
            }

            $catTrans = $category->translate($this->locale);
            $breadcrumbs->push([
                'title' => $catTrans->name ?? $category->name,
                'url' => url($this->locale . '/' . ltrim($category->getPath($this->locale), '/')),
                'active' => false
            ]);
        }

        $breadcrumbs->push(['title' => $this->getName(), 'url' => $this->getPath(), 'active' => true]);

        return $breadcrumbs;
    }
}
