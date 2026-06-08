<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Translatable;
    use NodeTrait;

    protected $translatable = [
        'slug',
        'name',
        'excerpt',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'seo_text'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getPath($locale): string
    {
        $prefix = __('routes.products', [], $locale);

        $this->loadMissing('ancestors');

        $slugs = $this->ancestors->map(function ($ancestor) use ($locale) {
            return $ancestor->translate($locale)->slug;
        });

        $slugs->push($this->translate($locale)->slug);

        return $prefix . '/' . $slugs->implode('/');
    }

    public function delete()
    {
        foreach ($this->children()->get() as $child) {
            $child->makeRoot();
            $child->save();
        }

        $this->products()->update(['category_id' => null]);

        return parent::delete();
    }
}
