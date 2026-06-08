<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CacheManagerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

use App\Models\Page;
use App\Models\Product;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Blog;
use App\Models\Category;

class GlobalSearchController extends Controller
{
    protected const LIMIT = 5;

    protected $cacheManager;

    public function __construct(CacheManagerService $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function search(Request $request, $locale)
    {
        $term = $request->input('q', '');

        $results = $this->performSearch($term, $locale);

        $totalCount = collect($results)->flatten(1)->count();

        return response()->json([
            'status' => 'success',
            'results' => $results,
            'total' => $totalCount,
            'labels' => [
                'pages' => __('ui.search_titles.pages'),
                'products' => __('ui.search_titles.products'),
                'categories' => __('ui.search_titles.categories'),
                'news' => __('ui.search_titles.news'),
                'projects' => __('ui.search_titles.projects'),
                'references' => __('ui.search_titles.references'),
                'blog' => __('ui.search_titles.blog'),
            ]
        ]);
    }

    private function performSearch(string $term, string $locale): array
    {
        if (mb_strlen($term) < 2) {
            return [];
        }

        $slugTerm = Str::slug($term);

        if (empty($slugTerm)) {
            $slugTerm = md5($term);
        }

        return $this->cacheManager->remember(
            'global_search',
            [$locale, $slugTerm],
            function () use ($term, $locale) {
                return [
                    'pages' => $this->searchModel(Page::class, $term, $locale, 'title'),
                    'products' => $this->searchModel(Product::class, $term, $locale, 'name'),
                    'categories' => $this->searchModel(Category::class, $term, $locale, 'name'),
                    'news' => $this->searchModel(News::class, $term, $locale, 'title'),
                    'projects' => $this->searchModel(Project::class, $term, $locale, 'title'),
                    'references' => $this->searchModel(Reference::class, $term, $locale, 'title'),
                    'blog' => $this->searchModel(Blog::class, $term, $locale, 'title'),
                ];
            }
        );
    }

    private function searchModel($modelClass, $term, $locale, $field)
    {
        try {
            $query = $modelClass::where('status', 1);

            $defaultLocale = config('voyager.multilingual.default');

            if ($locale === $defaultLocale) {
                $query->where($field, 'LIKE', "%{$term}%");
            } else {
                $query->where(function ($q) use ($term, $locale, $field) {

                    $q->whereHas('translations', function ($t) use ($term, $locale, $field) {
                        $t->where('column_name', $field)
                            ->where('locale', $locale)
                            ->where('value', 'LIKE', "%{$term}%");
                    })

                        ->orWhere(function ($q2) use ($term, $locale, $field) {
                            $q2->where($field, 'LIKE', "%{$term}%")
                                ->whereDoesntHave('translations', function ($t) use ($locale, $field) {
                                    $t->where('column_name', $field)
                                        ->where('locale', $locale);
                                });
                        });
                });
            }

            if ($modelClass === Product::class) {
                $query->with(['category', 'translations']);
            } elseif ($modelClass === Category::class) {
                $query->with(['translations']);
            } else {
                $query->with(['translations']);
            }

            $results = $query->take(self::LIMIT)->get();

            return $results->flatMap(function ($item) use ($locale, $field, $defaultLocale) {
                try {
                    $title = $item->getTranslatedAttribute($field, $locale, $defaultLocale);

                    if (empty($title)) {
                        $title = $item->{$field};
                    }

                    if (empty($title))
                        return [];

                    $path = $item->getPath($locale);
                    $url = '#';

                    if (!empty($path)) {
                        if (str_starts_with($path, 'http')) {
                            $url = $path;
                        } else {
                            $url = url($locale . '/' . ltrim($path, '/'));
                        }
                    }

                    $image = null;
                    if (!empty($item->image)) {
                        $image = Voyager::image($item->image);
                    }

                    return [
                        [
                            'title' => $title,
                            'url' => $url,
                            'image' => $image,
                        ]
                    ];
                } catch (\Exception $e) {
                    Log::error("Search row error ID {$item->id}: " . $e->getMessage());
                    return [];
                }
            });
        } catch (\Exception $e) {
            Log::error("Search model error [{$modelClass}]: " . $e->getMessage());
            return collect([]);
        }
    }
}
