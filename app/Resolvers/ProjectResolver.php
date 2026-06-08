<?php

namespace App\Resolvers;

use Closure;
use App\Models\Project;
use App\Http\Controllers\ProjectController;
use App\Services\CacheManagerService;

class ProjectResolver implements ResolverContract
{
    protected $projectController;
    protected $cacheManager;

    public function __construct(
        ProjectController $projectController,
        CacheManagerService $cacheManager
    ) {
        $this->projectController = $projectController;
        $this->cacheManager = $cacheManager;
    }

    public function handle(array $payload, Closure $next)
    {
        $locale = $payload['locale'];
        $slug = $payload['slug'];

        $project = $this->findProjectBySlug($slug, $locale);

        if ($project) {
            return $this->handleProjectResolution($locale, $slug, $project);
        }

        return $next($payload);
    }

    private function findProjectBySlug($slug, $locale): ?Project
    {
        $segments = explode('/', $slug);
        $lastSegment = end($segments);

        return $this->cacheManager->remember(
            'project_resolver',
            [$locale, $lastSegment],
            function () use ($lastSegment, $locale) {
                return Project::whereTranslation('slug', $lastSegment, $locale)
                    ->where('status', 1)
                    ->with(['translations'])
                    ->first();
            }
        );
    }

    private function handleProjectResolution($locale, $requestedPath, Project $project)
    {
        $correctPath = $project->getPath($locale);

        if ($correctPath === $requestedPath || $correctPath === urldecode($requestedPath)) {
            return $this->projectController->show($locale, $project);
        }

        $targetUrl = route('resolver', ['locale' => $locale, 'slug' => $correctPath]);

        if (url()->current() === $targetUrl) {
            return $this->projectController->show($locale, $project);
        }

        return redirect()->to($targetUrl, 301);
    }
}
