<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\ViewModels\NewsViewModel;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($locale, News $news)
    {
        $viewModel = new NewsViewModel($news, $locale);

        return view('pages.news-detail', [
            'locale'    => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
