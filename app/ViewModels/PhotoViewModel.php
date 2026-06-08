<?php

namespace App\ViewModels;

use App\Models\Photo;
use App\Traits\ResolvesVoyagerFile;

class PhotoViewModel
{
    use ResolvesVoyagerFile;

    protected $photo;
    protected $locale;
    protected $translation;

    public function __construct(Photo $photo, $locale)
    {
        $this->photo = $photo;
        $this->locale = $locale;
        $this->translation = $photo->translate($locale);
    }

    public function getModel()
    {
        return $this->photo;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->photo->title ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->photo->description ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->photo->image_url)) {
            return $this->photo->image_url;
        }
        return $this->resolveFileUrl($this->photo->image) ?? null;
    }
}
