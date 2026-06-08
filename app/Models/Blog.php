<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Blog extends Model
{
    use Translatable;

    protected $translatable = [
        'slug',
        'title',
        'subtitle',
        'excerpt',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'seo_text'
    ];

    public function getPath($locale): string
    {
        $prefix = __('routes.blog', [], $locale);
        $slug = $this->translate($locale)->slug ?? $this->slug;

        return $prefix . '/' . $slug;
    }
}
