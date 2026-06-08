<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\NavigationService;

class NavigationComposer
{
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    public function compose(View $view)
    {
        $locale = $view->getData()['locale'] ?? app()->getLocale();
        $homeUrl = url($locale);
        $manualSubmenus = $this->getManualSubmenus();

        $rawMenuItems = $this->navigationService->getMenu($locale);
        $menuItems = $this->prepareMenuItems($rawMenuItems, $homeUrl, $manualSubmenus);

        $view->with([
            'menuItems' => $menuItems,
            'homeUrl' => $homeUrl,
        ]);
    }

    protected function prepareMenuItems($items, $homeUrl, $manualSubmenus = [])
    {
        if (!$items)
            return collect();

        return collect($items)->map(function ($item) use ($homeUrl, $manualSubmenus) {
            $item->computedUrl = $item->url ?? '#';
            $item->targetId = 'nav-item-' . ($item->id ?? uniqid());

            $manuals = collect($manualSubmenus[$item->id] ?? [])->map(function ($m) use ($item) {
                return (object) [
                    'title' => $m['title'],
                    'computedUrl' => str_starts_with($m['url'], '#') ? $item->computedUrl . $m['url'] : $m['url'],
                    'hasChildren' => false,
                    'combinedChildren' => collect(),
                ];
            });

            $dbChildren = $item->children ?? collect();
            $item->combinedChildren = $this->prepareMenuItems($dbChildren, $homeUrl, $manualSubmenus)->merge($manuals);
            $item->hasChildren = $item->combinedChildren->isNotEmpty();

            return $item;
        });
    }

    protected function getManualSubmenus(): array
    {
        return [
            9 => [
                ['title' => __('Haberler'), 'url' => '#' . __('Haberler')],
                ['title' => __('Fotoğraflar'), 'url' => '#' . __('Fotoğraflar')],
                ['title' => __('Videolar'), 'url' => '#' . __('Videolar')],
            ]
        ];
    }
}