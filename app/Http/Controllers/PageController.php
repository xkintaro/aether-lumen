<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\ViewModels\PageViewModel;
use Illuminate\Support\Facades\View;
use App\Services\CatalogService;

class PageController extends Controller
{
    protected $catalogService;

    public function __construct(
        CatalogService $catalogService
    ) {
        $this->catalogService = $catalogService;
    }

    public function show($locale, Page $page)
    {
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
