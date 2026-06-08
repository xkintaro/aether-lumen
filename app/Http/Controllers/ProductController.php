<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CatalogService;
use Illuminate\Http\Request;
use App\ViewModels\ProductViewModel;
use App\ViewModels\PageViewModel;

class ProductController extends Controller
{
    protected $catalogService;

    public function __construct(CatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function index($locale, Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category_ids' => ['nullable', 'array', 'max:10'],
            'category_ids.*' => ['nullable', 'regex:/^(\d*)$/', 'max:10'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $productViewModels = $this->catalogService->getFilteredProducts($filters, $locale);

        $selectedCategoryIds = array_filter(
            $filters['category_ids'] ?? [],
            fn($id) => is_numeric($id) && $id > 0
        );

        $categoryDropdowns = [];
        $categoryTree = $this->catalogService->getCategoryTree($locale);

        $categoryDropdowns[] = (object) [
            'level' => 0,
            'name' => 'category_ids[0]',
            'options' => $categoryTree,
            'selected_id' => $selectedCategoryIds[0] ?? null
        ];

        $currentChildren = $categoryTree;
        foreach ($selectedCategoryIds as $index => $selectedId) {
            $selectedNode = $currentChildren->firstWhere('id', $selectedId);
            if ($selectedNode && $selectedNode->children->isNotEmpty()) {
                $categoryDropdowns[] = (object) [
                    'level' => $index + 1,
                    'name' => 'category_ids[' . ($index + 1) . ']',
                    'options' => $selectedNode->children,
                    'selected_id' => $selectedCategoryIds[$index + 1] ?? null
                ];
                $currentChildren = $selectedNode->children;
            } else {
                break;
            }
        }

        $viewData = [
            'locale' => $locale,
            'productViewModels' => $productViewModels,
            'categoryDropdowns' => $categoryDropdowns,
            'filters' => $filters,
            'query' => $filters['q'] ?? ''
        ];

        if ($request->header('X-Aether-Ajax')) {
            return view('pages.products-list-ajax', $viewData);
        }

        $page = $this->catalogService->getPageByRouteKey('routes.products');

        if (!$page) {
            abort(404);
        }

        $viewData['viewModel'] = new PageViewModel($page, $locale, $this->catalogService);

        return view('pages.products', $viewData);
    }

    public function show($locale, Product $product)
    {
        $viewModel = new ProductViewModel($product, $locale);

        return view('pages.product-detail', [
            'locale' => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
