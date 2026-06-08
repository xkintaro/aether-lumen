<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public array $links = [];
    public string $uniqueId;
    public string $variant;

    private const ALLOWED_VARIANTS = ['offcanvas', 'navbar', 'dropdown'];
    private const DEFAULT_VARIANT = 'offcanvas';

    public function __construct(
        string $locale,
        mixed $viewModel = null,
        ?string $uniqueId = null,
        string $variant = self::DEFAULT_VARIANT
    ) {
        $this->uniqueId = $uniqueId ?? 'ls-' . uniqid();
        $this->variant = in_array($variant, self::ALLOWED_VARIANTS) ? $variant : self::DEFAULT_VARIANT;
        $this->links = $this->generateLinks($locale, $viewModel);
    }

    private function generateLinks(string $currentLocale, mixed $viewModel): array
    {
        $links = [];
        $supportedLocales = config('voyager.multilingual.locales');

        $currentRoute = Route::current();
        if (!$currentRoute) {
            return $links;
        }

        $currentRouteName = $currentRoute->getName();

        $entity = null;
        if (isset($viewModel) && method_exists($viewModel, 'getModel')) {
            $entity = $viewModel->getModel();
        }

        foreach ($supportedLocales as $langLocale) {
            $url = '#';

            if ($entity && method_exists($entity, 'getPath')) {
                $rawPath = $entity->getPath($langLocale);

                if (str_starts_with($rawPath, 'http')) {
                    $url = $rawPath;
                } else {
                    $url = url($langLocale . '/' . ltrim($rawPath, '/'));
                }
            } elseif ($currentRouteName && $currentRouteName !== 'resolver') {
                try {
                    $params = $currentRoute->parameters();
                    $params['locale'] = $langLocale;
                    $url = route($currentRouteName, $params);
                } catch (\Exception $e) {
                    $url = url($langLocale);
                }
            } else {
                $url = url($langLocale);
            }

            $links[] = (object) [
                'code' => $langLocale,
                'url' => $url,
                'isActive' => ($langLocale === $currentLocale),
            ];
        }

        return $links;
    }

    public function render()
    {
        return view('layout.language-switcher.' . $this->variant);
    }
}
