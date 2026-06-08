<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use App\Services\CacheManagerService;

use App\Models\Page;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;

use App\Resolvers\PageResolver;
use App\Resolvers\ProductResolver;
use App\Resolvers\CategoryResolver;
use App\Resolvers\BlogResolver;
use App\Resolvers\NewsResolver;
use App\Resolvers\ProjectResolver;
use App\Resolvers\ReferenceResolver;

class SlugResolverService
{
    protected $pipeline;
    protected $cacheManager;

    protected $resolverMap = [
        'page' => PageResolver::class,
        'category' => CategoryResolver::class,
        'product' => ProductResolver::class,
        'blog' => BlogResolver::class,
        'news' => NewsResolver::class,
        'project' => ProjectResolver::class,
        'reference' => ReferenceResolver::class,
    ];

    public function __construct(Pipeline $pipeline, CacheManagerService $cacheManager)
    {
        $this->pipeline = $pipeline;
        $this->cacheManager = $cacheManager;
    }

    public function resolve($locale, $slug)
    {
        $slug = urldecode($slug);

        $slug = trim($slug, "/ \t\n\r\0\x0B");

        if (empty($slug)) {
            abort(404);
        }

        $targetType = request()->query('target');
        if ($targetType && isset($this->resolverMap[$targetType])) {
            return $this->runPipeline($locale, $slug, [$this->resolverMap[$targetType]]);
        }

        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        $matches = $this->findMatches($lastSegment, $locale);

        if (empty($matches)) {
            $redirect = $this->checkCrossLanguageRedirect($lastSegment, $locale);

            if ($redirect) {
                $targetUrl = url($redirect->getTargetUrl());
                $currentUrl = request()->url();

                if ($targetUrl === $currentUrl) {
                    abort(404);
                }

                return $redirect;
            }
            abort(404);
        }

        $exactMatches = [];
        foreach ($matches as $data) {
            if ($data['path'] === $slug) {
                $exactMatches[] = $data;
            }
        }

        if (count($exactMatches) === 1) {
            $data = $exactMatches[0];
            return $this->runPipeline($locale, $slug, [$this->resolverMap[$data['type']]]);
        }

        if (count($exactMatches) > 1) {
            return $this->showAmbiguityPage($locale, $slug, $exactMatches);
        }

        if (count($matches) === 1) {
            $candidate = $matches[0];
            if ($candidate['path'] && $candidate['path'] !== $slug) {
                return redirect()->to($locale . '/' . $candidate['path'], 301);
            }
        }

        return $this->showAmbiguityPage($locale, $slug, $matches);
    }

    protected function checkCrossLanguageRedirect($slug, $targetLocale)
    {
        $redirectUrl = $this->cacheManager->remember(
            'resolver_redirect',
            [$targetLocale, $slug],
            function () use ($slug, $targetLocale) {

                $translation = DB::table('translations')
                    ->whereIn('table_name', ['pages', 'categories', 'products', 'blogs', 'news', 'projects', 'references'])
                    ->where('column_name', 'slug')
                    ->where('value', $slug)
                    ->first();

                if (!$translation) {
                    $mainRecord = Page::where('slug', $slug)->first();
                    if ($mainRecord) {
                        $correctPath = $mainRecord->getRecursiveSlug($targetLocale);
                        if ($correctPath && $correctPath !== $slug) {
                            return $targetLocale . '/' . $correctPath;
                        }
                    }
                    return null;
                }

                $model = null;
                $correctPath = null;

                switch ($translation->table_name) {
                    case 'pages':
                        $model = Page::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getRecursiveSlug($targetLocale);
                        break;

                    case 'categories':
                        $model = Category::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;

                    case 'products':
                        $model = Product::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;

                    case 'blogs':
                        $model = Blog::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;

                    case 'news':
                        $model = News::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;

                    case 'projects':
                        $model = Project::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;

                    case 'references':
                        $model = Reference::where('status', 1)->find($translation->foreign_key);
                        if ($model)
                            $correctPath = $model->getPath($targetLocale);
                        break;
                }

                if ($correctPath) {
                    return $targetLocale . '/' . $correctPath;
                }

                return null;
            }
        );

        if ($redirectUrl) {
            return redirect()->to($redirectUrl, 301);
        }

        return null;
    }

    protected function findMatches($slug, $locale)
    {
        return $this->cacheManager->remember('resolver_matches', [$locale, $slug], function () use ($slug, $locale) {

            $matches = [];

            // 1. Page
            $page = Page::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($page) {
                $matches[] = [
                    'type' => 'page',
                    'title' => $page->translate($locale)->title ?? 'Sayfa',
                    'id' => $page->id,
                    'path' => $page->getRecursiveSlug($locale),
                    'model' => $page
                ];
            }

            // 2. Category
            $category = Category::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($category) {
                $matches[] = [
                    'type' => 'category',
                    'title' => $category->translate($locale)->name ?? 'Kategori',
                    'id' => $category->id,
                    'path' => $category->getPath($locale),
                    'model' => $category
                ];
            }

            // 3. Product
            $product = Product::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with(['category', 'translations', 'category.translations'])
                ->first();
            if ($product) {
                $matches[] = [
                    'type' => 'product',
                    'title' => $product->translate($locale)->name ?? 'Ürün',
                    'id' => $product->id,
                    'path' => $product->getPath($locale),
                    'model' => $product
                ];
            }

            // 4. Blog 
            $blog = Blog::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($blog) {
                $matches[] = [
                    'type' => 'blog',
                    'title' => $blog->translate($locale)->title ?? 'Blog',
                    'id' => $blog->id,
                    'path' => $blog->getPath($locale),
                    'model' => $blog
                ];
            }

            // 5. News 
            $news = News::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($news) {
                $matches[] = [
                    'type' => 'news',
                    'title' => $news->translate($locale)->title ?? 'Haber',
                    'id' => $news->id,
                    'path' => $news->getPath($locale),
                    'model' => $news
                ];
            }

            // 6. Project 
            $project = Project::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($project) {
                $matches[] = [
                    'type' => 'project',
                    'title' => $project->translate($locale)->title ?? 'Proje',
                    'id' => $project->id,
                    'path' => $project->getPath($locale),
                    'model' => $project
                ];
            }

            // 7. Reference 
            $reference = Reference::whereTranslation('slug', $slug, $locale)
                ->where('status', 1)
                ->with('translations')
                ->first();
            if ($reference) {
                $matches[] = [
                    'type' => 'reference',
                    'title' => $reference->translate($locale)->title ?? 'Referans',
                    'id' => $reference->id,
                    'path' => $reference->getPath($locale),
                    'model' => $reference
                ];
            }

            return $matches;
        });
    }

    protected function showAmbiguityPage($locale, $currentSlug, $matches)
    {
        $paths = array_column($matches, 'path');
        $pathCounts = array_count_values($paths);

        $viewMatches = [];

        foreach ($matches as $data) {
            $needsTarget = ($pathCounts[$data['path']] ?? 0) > 1;

            $viewMatches[] = [
                'title' => $data['title'],
                'id' => $data['id'],
                'path' => $data['path'],
                'type' => $data['type'],
                'needs_target' => $needsTarget
            ];
        }

        return response()->view('pages.ambiguity', [
            'locale' => $locale,
            'slug' => $currentSlug,
            'matches' => $viewMatches
        ]);
    }

    protected function runPipeline($locale, $slug, $pipes)
    {
        $payload = ['locale' => $locale, 'slug' => $slug];
        return $this->pipeline->send($payload)->through($pipes)->then(function () {
            abort(404);
        });
    }
}
