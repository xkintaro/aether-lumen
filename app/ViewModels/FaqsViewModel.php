<?php

namespace App\ViewModels;

use App\Models\Faqs;

class FaqsViewModel
{
    protected $faqs;
    protected $locale;
    protected $translation;

    public function __construct(Faqs $faqs, $locale)
    {
        $this->faqs = $faqs;
        $this->locale = $locale;
        $this->translation = $faqs->translate($locale);
    }

    public function getQuestion()
    {
        return $this->translation->question ?? $this->faqs->question ?? null;
    }

    public function getAnswer()
    {
        return $this->translation->answer ?? $this->faqs->answer ?? null;
    }
}
