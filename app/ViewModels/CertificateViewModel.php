<?php

namespace App\ViewModels;

use App\Models\Certificate;
use TCG\Voyager\Facades\Voyager;
use Carbon\Carbon;
use App\Traits\ResolvesVoyagerFile;

class CertificateViewModel
{
    use ResolvesVoyagerFile;

    protected $certificate;
    protected $locale;
    protected $translation;

    public function __construct(Certificate $certificate, $locale)
    {
        $this->certificate = $certificate;
        $this->locale = $locale;
        $this->translation = $certificate->translate($locale);
    }

    public function getModel()
    {
        return $this->certificate;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->certificate->title ?? null;
    }

    public function getOrganization()
    {
        return $this->translation->organization ?? $this->certificate->organization ?? null;
    }

    public function getDescription()
    {
        return $this->translation->description ?? $this->certificate->description ?? null;
    }

    public function getReceivedDate($format = 'd M Y')
    {
        if (!$this->certificate->received_at)
            return null;
        return Carbon::parse($this->certificate->received_at)->locale($this->locale)->translatedFormat($format);
    }

    public function getImage(): ?string
    {
        if (!empty($this->certificate->image_url)) {
            return $this->certificate->image_url;
        }

        return $this->resolveFileUrl($this->certificate->image) ?? null;
    }

    public function getFile()
    {
        return $this->resolveFileUrl($this->certificate->file) ?? null;
    }
}
