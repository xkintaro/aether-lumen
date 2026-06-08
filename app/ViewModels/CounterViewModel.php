<?php

namespace App\ViewModels;

use App\Models\Counter;

class CounterViewModel
{
    protected $counter;

    protected $locale;

    protected $translation;

    public function __construct(Counter $counter, $locale)
    {
        $this->counter = $counter;
        $this->locale = $locale;
        $this->translation = $counter->translate($locale);
    }

    public function getModel()
    {
        return $this->counter;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->counter->title ?? null;
    }

    public function getValue()
    {
        return $this->counter->value ?? null;
    }

    public function getPercentage()
    {
        return $this->counter->percentage ?? null;
    }

    public function getIcon()
    {
        return $this->counter->icon ?? null;
    }
}
