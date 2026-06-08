<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\NavigationService;

class FooterComposer
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

        $footerData = $this->navigationService->getFooterData($locale);

        $view->with('footerPages', $footerData['pages'])
            ->with('footerCategories', $footerData['categories'])
            ->with('footerNews', $footerData['news'])
            ->with('footerSocialMedias', $footerData['social_medias'])
            ->with('homeUrl', $homeUrl);
    }
}
