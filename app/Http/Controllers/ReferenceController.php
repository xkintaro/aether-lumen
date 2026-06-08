<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use App\ViewModels\ReferenceViewModel;

class ReferenceController extends Controller
{
    public function show($locale, Reference $reference)
    {
        $viewModel = new ReferenceViewModel($reference, $locale);

        return view('pages.reference-detail', [
            'locale'    => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
