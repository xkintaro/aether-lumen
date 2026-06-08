<?php

namespace App\Services;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Counter;
use App\Models\Brand;
use App\Models\Page;
use App\Models\Blog;
use App\Models\News;
use App\Models\Certificate;
use App\Models\Popup;
use App\Models\SocialMedia;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Faqs;

use App\ViewModels\ProductViewModel;
use App\ViewModels\CategoryViewModel;
use App\ViewModels\SliderViewModel;
use App\ViewModels\CounterViewModel;
use App\ViewModels\BrandViewModel;
use App\ViewModels\BlogViewModel;
use App\ViewModels\NewsViewModel;
use App\ViewModels\CertificateViewModel;
use App\ViewModels\PopupViewModel;
use App\ViewModels\SocialMediaViewModel;
use App\ViewModels\TestimonialViewModel;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\ReferenceViewModel;
use App\ViewModels\PhotoViewModel;
use App\ViewModels\VideoViewModel;
use App\ViewModels\FaqsViewModel;

class CatalogService
{
    protected $cacheManager;

    public function __construct(CacheManagerService $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function getHomepage(string $locale): object
    {
        $homePageModel = $this->cacheManager->remember('homepage', [$locale], function () use ($locale) {
            return Page::where('is_homepage', 1)
                ->where('status', 1)
                ->with(['translations', 'parent', 'parent.translations'])
                ->first();
        });

        $title = setting('site.title');
        $url = url($locale);
        $id = null;

        if ($homePageModel) {
            $translation = $homePageModel->translate($locale);
            $title = $translation->title ?? $homePageModel->getOriginal('title');
            $id = $homePageModel->id;
        }

        return (object) [
            'id' => $id,
            'title' => $title,
            'url' => $url,
        ];
    }

    public function getPageBySlugs(array $slugs, string $locale)
    {
        $slugHash = md5(json_encode($slugs));

        return $this->cacheManager->remember('page_by_slugs', [$locale, $slugHash], function () use ($slugs, $locale) {

            return Page::where(function ($query) use ($slugs, $locale) {
                foreach ($slugs as $slug) {
                    $query->orWhereHas('translations', function ($q) use ($slug, $locale) {
                        $q->where('column_name', 'slug')
                            ->where('locale', $locale)
                            ->where('value', $slug);
                    });

                    $query->orWhere('slug', $slug);
                }
            })
                ->where('status', 1)
                ->with(['translations', 'parent', 'parent.translations'])
                ->first();
        });
    }

    public function getPageByRouteKey(string $routeKey)
    {
        $locale = app()->getLocale();
        $locales = config('voyager.multilingual.locales', [config('app.locale')]);

        $uniqueCacheParam = $locale . '_' . str_replace('.', '_', $routeKey);

        return $this->cacheManager->remember(
            'page_route',
            [$uniqueCacheParam],
            function () use ($routeKey, $locales, $locale) {

                $slugs = [];
                foreach ($locales as $lang) {
                    $slug = __($routeKey, [], $lang);
                    if ($slug && $slug !== $routeKey) {
                        $slugs[] = $slug;
                    }
                }
                $slugs = array_unique($slugs);

                if (empty($slugs))
                    return null;

                return Page::where(function ($query) use ($slugs) {
                    $query->whereIn('slug', $slugs)
                        ->orWhereHas('translations', function ($t) use ($slugs) {
                            $t->where('column_name', 'slug')
                                ->whereIn('value', $slugs);
                        });
                })
                    ->where('status', 1)
                    ->with(['translations'])
                    ->first();
            }
        );
    }

    public function getCounters(string $locale, int $limit = null): Collection
    {
        $counters = $this->cacheManager->remember('page_vm_counters', [$locale], function () use ($locale) {
            $rawCounters = Counter::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawCounters->map(fn($counter) => new CounterViewModel($counter, $locale));
        });

        return $limit ? $counters->take($limit) : $counters;
    }

    public function getBrands(string $locale, int $limit = null): Collection
    {
        $brands = $this->cacheManager->remember('page_vm_brands', [$locale], function () use ($locale) {
            $rawBrands = Brand::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawBrands->map(fn($brand) => new BrandViewModel($brand, $locale));
        });

        return $limit ? $brands->take($limit) : $brands;
    }

    public function getSliders(string $locale, int $limit = null): Collection
    {
        $sliders = $this->cacheManager->remember('page_vm_sliders', [$locale], function () use ($locale) {
            $rawSliders = Slider::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawSliders->map(fn($slider) => new SliderViewModel($slider, $locale));
        });

        return $limit ? $sliders->take($limit) : $sliders;
    }

    public function getBlogs(string $locale, int $limit = null): Collection
    {
        $blogs = $this->cacheManager->remember('page_vm_blogs', [$locale], function () use ($locale) {
            $rawBlogs = Blog::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawBlogs->map(fn($blog) => new BlogViewModel($blog, $locale));
        });

        if ($limit) {
            $blogs = $blogs->take($limit);
        }

        return $blogs;
    }

    public function getNews(string $locale, int $limit = null): Collection
    {
        $news = $this->cacheManager->remember('page_vm_news', [$locale], function () use ($locale) {
            $rawNews = News::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawNews->map(fn($item) => new NewsViewModel($item, $locale));
        });

        if ($limit) {
            $news = $news->take($limit);
        }

        return $news;
    }

    public function getProjects(string $locale, int $limit = null): Collection
    {
        $projects = $this->cacheManager->remember('page_vm_projects', [$locale], function () use ($locale) {
            $rawProjects = Project::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawProjects->map(fn($item) => new ProjectViewModel($item, $locale));
        });

        if ($limit) {
            $projects = $projects->take($limit);
        }

        return $projects;
    }

    public function getReferences(string $locale, int $limit = null): Collection
    {
        $references = $this->cacheManager->remember('page_vm_references', [$locale], function () use ($locale) {
            $raw = Reference::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new ReferenceViewModel($item, $locale));
        });

        if ($limit) {
            $references = $references->take($limit);
        }

        return $references;
    }

    public function getCertificates(string $locale, int $limit = null): Collection
    {
        $certificates = $this->cacheManager->remember('page_vm_certificates', [$locale], function () use ($locale) {
            $raw = Certificate::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new CertificateViewModel($item, $locale));
        });

        return $limit ? $certificates->take($limit) : $certificates;
    }

    public function getPopups(string $locale, int $limit = null): Collection
    {
        $popups = $this->cacheManager->remember('page_vm_popups', [$locale], function () use ($locale) {
            $raw = Popup::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new PopupViewModel($item, $locale));
        });

        return $limit ? $popups->take($limit) : $popups;
    }

    public function getSocialMedias(string $locale, int $limit = null): Collection
    {
        $medias = $this->cacheManager->remember('page_vm_social_medias', [$locale], function () use ($locale) {
            $raw = SocialMedia::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new SocialMediaViewModel($item, $locale));
        });

        return $limit ? $medias->take($limit) : $medias;
    }

    public function getTestimonials(string $locale, int $limit = null): Collection
    {
        $testimonials = $this->cacheManager->remember('page_vm_testimonials', [$locale], function () use ($locale) {
            $raw = Testimonial::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new TestimonialViewModel($item, $locale));
        });

        return $limit ? $testimonials->take($limit) : $testimonials;
    }

    public function getPhotos(string $locale, int $limit = null): Collection
    {
        $photos = $this->cacheManager->remember('page_vm_photos', [$locale], function () use ($locale) {
            $raw = Photo::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new PhotoViewModel($item, $locale));
        });

        return $limit ? $photos->take($limit) : $photos;
    }

    public function getVideos(string $locale, int $limit = null): Collection
    {
        $videos = $this->cacheManager->remember('page_vm_videos', [$locale], function () use ($locale) {
            $raw = Video::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new VideoViewModel($item, $locale));
        });

        return $limit ? $videos->take($limit) : $videos;
    }

    public function getFaqs(string $locale, int $limit = null): Collection
    {
        $faqs = $this->cacheManager->remember('page_vm_faqs', [$locale], function () use ($locale) {
            $raw = Faqs::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $raw->map(fn($item) => new FaqsViewModel($item, $locale));
        });

        return $limit ? $faqs->take($limit) : $faqs;
    }

    public function getProducts(string $locale, int $limit = null): Collection
    {
        $products = $this->cacheManager->remember('page_vm_products', [$locale], function () use ($locale) {
            $rawProducts = Product::where('status', 1)
                ->with(['category', 'category.ancestors'])
                ->orderBy('order', 'asc')
                ->with('translations')
                ->get();
            return $rawProducts->map(fn($product) => new ProductViewModel($product, $locale));
        });

        if ($limit) {
            $products = $products->take($limit);
        }

        return $products;
    }

    public function getCategories(string $locale, int $limit = null): Collection
    {
        $self = $this;
        $categories = $this->cacheManager->remember('page_vm_categories', [$locale], function () use ($locale, $self) {
            $rawCategories = Category::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
            return $rawCategories->map(fn($category) => new CategoryViewModel($category, $locale, $self));
        });

        if ($limit) {
            $categories = $categories->take($limit);
        }

        return $categories;
    }

    public function getPageChildrenContent(Page $page, string $locale): Collection
    {
        $children = $this->cacheManager->remember(
            'page_vm_children_content',
            [$page->id, $locale],
            function () use ($page, $locale) {
                $childrenPages = $page->children()
                    ->where('status', 1)
                    ->orderBy('order', 'asc')
                    ->with('translations')
                    ->get();

                return $childrenPages->map(function ($child) use ($locale) {
                    $translation = $child->translate($locale);
                    $title = $translation->title ?: $child->getOriginal('title');

                    return (object) [
                        'id' => $child->id,
                        'title' => $title,
                        'subtitle' => $translation->subtitle ?: $child->getOriginal('subtitle'),
                        'excerpt' => $translation->excerpt ?: $child->getOriginal('excerpt'),
                        'content' => $translation->content ?: $child->getOriginal('content'),
                        'image' => \TCG\Voyager\Facades\Voyager::image($child->image),
                        'icon' => $child->icon,
                        'url' => $child->getPath($locale),
                        'anchor_slug' => Str::slug($title),
                    ];
                });
            }
        );

        return $children;
    }

    public function getCategoryTree(string $locale): Collection
    {
        return $this->cacheManager->remember('page_vm_category_tree', [$locale], function () {
            $allCategories = Category::where('status', 1)
                ->with('translations')
                ->orderBy('order', 'asc')
                ->get();

            return $allCategories->toTree();
        });
    }

    public function getFilteredProducts(array $filters, string $locale): LengthAwarePaginator
    {
        $cacheParam = md5(http_build_query($filters) . '.' . $locale);

        $paginator = $this->cacheManager->remember('filter_results', [$cacheParam], function () use ($filters, $locale) {
            $queryBuilder = Product::where('status', 1)
                ->with(['category', 'category.ancestors', 'translations'])
                ->select('products.*');

            if (!empty($filters['q'])) {
                $queryBuilder->searchByName($filters['q'], $locale);
            }

            $categoryIds = $filters['category_ids'] ?? [];
            $mostSpecificCategoryId = null;

            foreach ($categoryIds as $id) {
                if (is_numeric($id) && $id > 0) {
                    $mostSpecificCategoryId = (int) $id;
                } else {
                    break;
                }
            }

            if ($mostSpecificCategoryId !== null) {
                $queryBuilder->forCategory($mostSpecificCategoryId);
            }

            $paginatedProducts = $queryBuilder
                ->orderBy('products.order', 'asc')
                ->paginate(perPage: 12);
            $paginatedProducts->onEachSide(0);

            return $paginatedProducts->through(fn($product) => new ProductViewModel($product, $locale));
        });

        return $paginator;
    }

    public function getProductsForCategory(Category $category, string $locale, int $limit = null): Collection
    {
        $products = $this->cacheManager->remember(
            'category_vm_products',
            [$category->id, $locale],
            function () use ($category, $locale) {
                return $category->products()
                    ->where('status', 1)
                    ->with(['category', 'category.ancestors', 'translations'])
                    ->orderBy('order', 'asc')
                    ->get()
                    ->map(fn($product) => new ProductViewModel($product, $locale));
            }
        );

        if ($limit) {
            $products = $products->take($limit);
        }

        return $products;
    }
}
