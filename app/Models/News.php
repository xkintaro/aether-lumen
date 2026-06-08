<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class News extends Model
{
    use Translatable;

    protected $table = 'news';

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
        $prefix = __('routes.news', [], $locale);
        $slug = $this->translate($locale)->slug ?? $this->slug;

        return $prefix . '/' . $slug;
    }
}
