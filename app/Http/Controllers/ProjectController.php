<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\ViewModels\ProjectViewModel;

class ProjectController extends Controller
{
    public function show($locale, Project $project)
    {
        $viewModel = new ProjectViewModel($project, $locale);

        return view('pages.project-detail', [
            'locale' => $locale,
            'viewModel' => $viewModel,
        ]);
    }
}
