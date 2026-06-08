<?php

namespace App\ViewModels;

use App\Models\Slider;
use App\Traits\ResolvesVoyagerFile;

class SliderViewModel
{
    use ResolvesVoyagerFile;

    protected $slider;
    protected $locale;
    protected $translation;

    public function __construct(Slider $slider, $locale)
    {
        $this->slider = $slider;
        $this->locale = $locale;
        $this->translation = $slider->translate($locale);
    }

    public function getModel(): Slider
    {
        return $this->slider;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->slider->title ?? null;
    }

    public function getSubtitle()
    {
        return $this->translation->subtitle ?? $this->slider->subtitle ?? null;
    }

    public function getExcerpt()
    {
        return $this->translation->excerpt ?? $this->slider->excerpt ?? null;
    }

    public function getActionText()
    {
        return $this->translation->action_text ?? $this->slider->action_text ?? null;
    }

    public function getActionLink()
    {
        return $this->translation->action_link ?? $this->slider->action_link ?? null;
    }

    public function getBgImage(): ?string
    {
        if (!empty($this->slider->bg_image_url)) {
            return $this->slider->bg_image_url;
        }

        return $this->resolveFileUrl($this->slider->bg_image) ?? null;
    }

    public function getMascotImage(): ?string
    {
        if (!empty($this->slider->mascot_image_url)) {
            return $this->slider->mascot_image_url;
        }

        return $this->resolveFileUrl($this->slider->mascot_image) ?? null;
    }

    public function getBgVideo(): ?string
    {
        if (!empty($this->slider->bg_video_url)) {
            return $this->slider->bg_video_url;
        }

        return $this->resolveFileUrl($this->slider->bg_video) ?? null;
    }
}
