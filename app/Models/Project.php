<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Project extends Model
{
    use HasFactory, Translatable;

    protected $guarded = [];

    protected $translatable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'seo_text',
        'client',
        'location',
    ];

    protected $casts = [
        'completion_date' => 'datetime',
    ];

    public function getPath($locale): string
    {
        $prefix = __('routes.projects', [], $locale);
        $slug = $this->translate($locale)->slug ?? $this->slug;

        return $prefix . '/' . $slug;
    }
}
