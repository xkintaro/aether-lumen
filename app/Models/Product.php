<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use Translatable;

    protected $translatable = [
        'slug',
        'name',
        'excerpt',
        'description',
        'content',
        'table_html',
        'meta_title',
        'meta_description',
        'seo_text'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getPath($locale): string
    {
        $productSlug = $this->translate($locale)->slug;
        $category = $this->category;

        if (!$category) {
            return __('routes.products', [], $locale) . '/' . $productSlug;
        }

        $categoryPath = $category->getPath($locale);

        return $categoryPath . '/' . $productSlug;
    }

    public function scopeSearchByName(Builder $query, string $searchText, string $locale): Builder
    {
        $defaultLocale = config('voyager.multilingual.default', config('voyager.multilingual.default'));

        if ($locale === $defaultLocale) {
            return $query->where('name', 'LIKE', '%' . $searchText . '%');
        }

        return $query->where(function ($q) use ($searchText, $locale) {

            $q->whereHas('translations', function ($translationQuery) use ($searchText, $locale) {
                $translationQuery->where('column_name', 'name')
                    ->where('locale', $locale)
                    ->where('value', 'LIKE', '%' . $searchText . '%');
            })

                ->orWhere(function ($subQ) use ($searchText, $locale) {
                    $subQ->where('name', 'LIKE', '%' . $searchText . '%')
                        ->whereDoesntHave('translations', function ($t) use ($locale) {
                            $t->where('column_name', 'name')
                                ->where('locale', $locale);
                        });
                });
        });
    }

    public function scopeForCategory(Builder $query, int $categoryId): Builder
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return $query->where('id', -1);
        }

        $categoryIds = $category->descendants()->pluck('id')->push($category->id);

        return $query->whereIn('category_id', $categoryIds);
    }
}
