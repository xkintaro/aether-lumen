<?php

namespace App\ViewModels;

use App\Models\Popup;
use TCG\Voyager\Facades\Voyager;
use App\Traits\ResolvesVoyagerFile;

class PopupViewModel
{
    use ResolvesVoyagerFile;

    protected $popup;
    protected $locale;
    protected $translation;

    public function __construct(Popup $popup, $locale)
    {
        $this->popup = $popup;
        $this->locale = $locale;
        $this->translation = $popup->translate($locale);
    }

    public function getModel()
    {
        return $this->popup;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->popup->title ?? null;
    }

    public function getContent()
    {
        return $this->translation->content ?? $this->popup->content ?? null;
    }

    public function getActionText()
    {
        return $this->translation->action_text ?? $this->popup->action_text ?? null;
    }

    public function getActionLink()
    {
        return $this->translation->action_link ?? $this->popup->action_link ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->popup->image_url)) {
            return $this->popup->image_url;
        }

        return $this->resolveFileUrl($this->popup->image) ?? null;
    }

    public function getVideo(): ?string
    {
        if (!empty($this->popup->video_url)) {
            return $this->popup->video_url;
        }

        return $this->resolveFileUrl($this->popup->video) ?? null;
    }
}
