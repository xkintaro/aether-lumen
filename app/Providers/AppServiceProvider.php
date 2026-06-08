<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;

use App\Http\View\Composers\NavigationComposer;
use App\Http\View\Composers\FooterComposer;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Counter;
use App\Models\Brand;
use App\Models\News;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\Popup;
use App\Models\SocialMedia;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Faqs;
use App\Models\Redirect301;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $helperPath = app_path('Helpers/helpers.php');
        if (file_exists($helperPath)) {
            require_once $helperPath;
        }
    }

    public function boot()
    {
        View::composer('layout.navbar', NavigationComposer::class);
        View::composer('layout.footer', FooterComposer::class);

        view()->composer('layout.default', function ($view) {
            $catalogService = app(\App\Services\CatalogService::class);
            $locale = app()->getLocale();
            $view->with('globalPopups', $catalogService->getPopups($locale));
        });

        $modelsToWatch = [
            Page::class,
            Product::class,
            Category::class,
            Slider::class,
            Counter::class,
            Brand::class,
            News::class,
            Blog::class,
            Certificate::class,
            Popup::class,
            SocialMedia::class,
            Testimonial::class,
            Project::class,
            Reference::class,
            Photo::class,
            Video::class,
            Faqs::class,
            Redirect301::class,
        ];

        foreach ($modelsToWatch as $model) {
            $model::saved(function ($model) {
                $this->nukeCache();
            });

            $model::deleted(function ($model) {
                $this->nukeCache();
            });

            if (method_exists($model, 'restore')) {
                $model::restored(function ($model) {
                    $this->nukeCache();
                });
            }
        }
    }

    protected function nukeCache()
    {
        Artisan::call('cache:clear');
    }
}
