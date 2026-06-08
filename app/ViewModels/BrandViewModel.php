<?php

namespace App\ViewModels;

use App\Models\Brand;
use App\Traits\ResolvesVoyagerFile;

class BrandViewModel
{
    use ResolvesVoyagerFile;

    protected $brand;
    protected $locale;
    protected $translation;

    public function __construct(Brand $brand, $locale)
    {
        $this->brand = $brand;
        $this->locale = $locale;
        $this->translation = $brand->translate($locale);
    }

    public function getModel(): Brand
    {
        return $this->brand;
    }

    public function getName()
    {
        return $this->translation->name ?? $this->brand->name ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->brand->image_url)) {
            return $this->brand->image_url;
        }

        return $this->resolveFileUrl($this->brand->image) ?? null;
    }

    public function getURL()
    {
        return $this->translation->url ?? $this->brand->url ?? null;
    }
}
