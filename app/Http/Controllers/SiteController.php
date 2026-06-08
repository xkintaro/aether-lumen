<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\SlugResolverService;
use App\ViewModels\PageViewModel;
use Illuminate\Support\Facades\View;
use App\Services\CacheManagerService;
use App\Services\CatalogService;

class SiteController extends Controller
{
    protected $resolverService;
    protected $cacheManager;
    protected $catalogService;

    public function __construct(
        SlugResolverService $resolverService,
        CacheManagerService $cacheManager,
        CatalogService $catalogService
    ) {
        $this->resolverService = $resolverService;
        $this->cacheManager = $cacheManager;
        $this->catalogService = $catalogService;
    }

    public function resolve($locale, $slug)
    {
        return $this->resolverService->resolve($locale, $slug);
    }

    public function index($locale)
    {
        $page = $this->cacheManager->remember(
            'homepage',
            [$locale],
            function () use ($locale) {
                return Page::where('is_homepage', 1)
                    ->where('status', 1)
                    ->with(['translations', 'parent', 'parent.translations'])
                    ->firstOrFail();
            }
        );

        if (!$page) {
            abort(404);
        }

        $viewModel = new PageViewModel(
            $page,
            $locale,
            $this->catalogService
        );

        $bladeName = $viewModel->getBladeName();

        if (empty($bladeName) || !View::exists('pages.' . $bladeName)) {
            abort(404);
        }

        return view('pages.' . $bladeName, [
            'locale' => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}