<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\ViewModels\BlogViewModel;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show($locale, Blog $blog)
    {
        $viewModel = new BlogViewModel($blog, $locale);

        return view('pages.blog-detail', [
            'locale'    => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
