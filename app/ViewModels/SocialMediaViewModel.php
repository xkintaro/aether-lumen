<?php

namespace App\ViewModels;

use App\Models\SocialMedia;
use TCG\Voyager\Facades\Voyager;
use App\Traits\ResolvesVoyagerFile;

class SocialMediaViewModel
{
    use ResolvesVoyagerFile;

    protected $socialMedia;
    protected $locale;
    protected $translation;

    public function __construct(SocialMedia $socialMedia, $locale)
    {
        $this->socialMedia = $socialMedia;
        $this->locale = $locale;
        $this->translation = $socialMedia->translate($locale);
    }

    public function getModel()
    {
        return $this->socialMedia;
    }

    public function getTitle()
    {
        return $this->socialMedia->title ?? null;
    }

    public function getLink()
    {
        return $this->socialMedia->link;
    }

    public function getUsername()
    {
        return $this->socialMedia->username ?? null;
    }

    public function getIcon()
    {
        return $this->socialMedia->icon ?? null;
    }
}
