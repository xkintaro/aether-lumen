<?php

namespace App\ViewModels;

use App\Models\Video;
use App\Traits\ResolvesVoyagerFile;

class VideoViewModel
{
    use ResolvesVoyagerFile;

    protected $video;
    protected $locale;
    protected $translation;

    public function __construct(Video $video, $locale)
    {
        $this->video = $video;
        $this->locale = $locale;
        $this->translation = $video->translate($locale);
    }

    public function getModel()
    {
        return $this->video;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->video->title ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->video->description ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->video->image_url)) {
            return $this->video->image_url;
        }

        return $this->resolveFileUrl($this->video->image) ?? null;
    }

    public function getVideo()
    {
        if (!empty($this->video->embed_code)) {
            preg_match('/src="([^"]+)"/', $this->video->embed_code, $match);

            if (isset($match[1])) {
                return $match[1];
            }

            return $this->video->embed_code;
        }

        if (!empty($this->video->video_url)) {
            return $this->video->video_url;
        }

        return $this->resolveFileUrl($this->video->video);
    }
}
