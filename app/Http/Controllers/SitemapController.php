<?php

namespace App\Http\Controllers;

use App\Services\CacheManagerService;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Str;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;

class SitemapController extends Controller
{
    protected $cacheManager;
    protected $locales;

    public function __construct(CacheManagerService $cacheManager)
    {
        $this->cacheManager = $cacheManager;
        $this->locales = config('voyager.multilingual.locales');
    }

    public function index()
    {
        $content = $this->generate();

        return response($content, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function generate()
    {
        return $this->cacheManager->remember('sitemap', [], function () {

            $sitemap = Sitemap::create();

            foreach ($this->locales as $locale) {

                // --- 1. PAGES ---
                Page::where('status', 1)
                    ->with(['translations', 'parent'])
                    ->chunk(100, function ($pages) use ($sitemap, $locale) {
                        foreach ($pages as $page) {
                            $url = $page->getPath($locale);
                            if ($url && $url !== '#') {
                                $sitemap->add(Url::create($url)
                                    ->setLastModificationDate($page->updated_at)
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                    ->setPriority($page->is_homepage ? 1.0 : 0.8));
                            }
                        }
                    });

                // --- 2. CATEGORIES ---
                Category::where('status', 1)
                    ->with(['translations', 'ancestors'])
                    ->chunk(100, function ($categories) use ($sitemap, $locale) {
                        foreach ($categories as $category) {
                            $fullUrl = $this->formatUrl($locale, $category->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($category->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setPriority(0.9));
                        }
                    });

                // --- 3. PRODUCTS ---
                Product::where('status', 1)
                    ->with(['translations', 'category'])
                    ->chunk(100, function ($products) use ($sitemap, $locale) {
                        foreach ($products as $product) {
                            $fullUrl = $this->formatUrl($locale, $product->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($product->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                                ->setPriority(0.9));
                        }
                    });

                // --- 4. BLOG ---
                Blog::where('status', 1)
                    ->with('translations')
                    ->chunk(100, function ($blogs) use ($sitemap, $locale) {
                        foreach ($blogs as $blog) {
                            $fullUrl = $this->formatUrl($locale, $blog->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($blog->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.7));
                        }
                    });

                // --- 5. NEWS ---
                News::where('status', 1)
                    ->with('translations')
                    ->chunk(100, function ($newsItems) use ($sitemap, $locale) {
                        foreach ($newsItems as $news) {
                            $fullUrl = $this->formatUrl($locale, $news->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($news->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.7));
                        }
                    });

                // --- 6. PROJECTS ---
                Project::where('status', 1)
                    ->with('translations')
                    ->chunk(100, function ($projects) use ($sitemap, $locale) {
                        foreach ($projects as $project) {
                            $fullUrl = $this->formatUrl($locale, $project->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($project->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.7));
                        }
                    });

                // --- 7. REFERENCES ---
                Reference::where('status', 1)
                    ->with('translations')
                    ->chunk(100, function ($references) use ($sitemap, $locale) {
                        foreach ($references as $reference) {
                            $fullUrl = $this->formatUrl($locale, $reference->getPath($locale));

                            $sitemap->add(Url::create($fullUrl)
                                ->setLastModificationDate($reference->updated_at)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.6));
                        }
                    });
            }

            return $sitemap->render();
        });
    }

    private function formatUrl($locale, $path)
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return url($locale . '/' . ltrim($path, '/'));
    }
}
