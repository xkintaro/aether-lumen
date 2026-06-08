<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\ViewModels\CategoryViewModel;
use App\Services\CatalogService;

class CategoryController extends Controller
{
    protected $catalogService;

    public function __construct(
        CatalogService $catalogService
    ) {
        $this->catalogService = $catalogService;
    }

    public function show($locale, Category $category)
    {
        $viewModel = new CategoryViewModel(
            $category,
            $locale,
            $this->catalogService
        );

        return view('pages.category-detail', [
            'locale' => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
