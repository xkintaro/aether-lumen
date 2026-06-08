<?php

namespace App\ViewModels;

use App\Models\Testimonial;
use App\Traits\ResolvesVoyagerFile;

class TestimonialViewModel
{
    use ResolvesVoyagerFile;

    protected $testimonial;
    protected $locale;
    protected $translation;

    public function __construct(Testimonial $testimonial, $locale)
    {
        $this->testimonial = $testimonial;
        $this->locale = $locale;
        $this->translation = $testimonial->translate($locale);
    }

    public function getModel()
    {
        return $this->testimonial;
    }

    public function getName()
    {
        return $this->testimonial->name ?? null;
    }

    public function getCompany()
    {
        return $this->testimonial->company ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->testimonial->title ?? null;
    }

    public function getComment()
    {
        return $this->translation->comment ?? $this->testimonial->comment ?? null;
    }

    public function getRating()
    {
        return $this->testimonial->rating ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->testimonial->image_url)) {
            return $this->testimonial->image_url;
        }

        return $this->resolveFileUrl($this->testimonial->image) ?? null;
    }
}
