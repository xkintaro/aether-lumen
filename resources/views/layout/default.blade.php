<!DOCTYPE html>
<html lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoTitle = setting('site.title');
        $seoDescription = setting('site.description');
        $seoImage = rvfs('site.logo');

        if (isset($viewModel)) {
            if (method_exists($viewModel, 'getSeoTitle') && !empty($viewModel->getSeoTitle())) {
                $seoTitle = $viewModel->getSeoTitle();
            }

            if (method_exists($viewModel, 'getMetaDescription') && !empty($viewModel->getMetaDescription())) {
                $seoDescription = $viewModel->getMetaDescription();
            }

            if (method_exists($viewModel, 'getImage') && !empty($viewModel->getImage())) {
                $seoImage = rvfs($viewModel->getImage());
            }
        }

        $queryParams = request()->query();
        $hasSearch = request()->has('q') && !empty(request()->input('q'));
        $hasCategoryFilter = request()->has('category_ids') && !empty(request()->input('category_ids'));
        $hasPage = request()->has('page') && !empty(request()->input('page'));

        $isFilteredPage = $hasSearch || $hasCategoryFilter || $hasPage;

        $robotsContent = $isFilteredPage ? 'noindex, follow' : 'index, follow';

        if ($isFilteredPage) {
            $canonicalUrl = url()->current();
        } else {
            $canonicalUrl = request()->fullUrl();
        }

        $currentUrl = $canonicalUrl;

        $supportedLocales = config('voyager.multilingual.locales');
        $fallbackLocale = config('voyager.multilingual.default');
        $currentRoute = Route::current();
        $alternateLinks = [];

        if ($currentRoute) {
            $routeName = $currentRoute->getName();
            $routeParams = $currentRoute->parameters();

            foreach ($supportedLocales as $langLocale) {
                $url = null;

                if (isset($viewModel) && method_exists($viewModel, 'getModel')) {
                    $model = $viewModel->getModel();
                    if ($model && method_exists($model, 'getPath')) {
                        $path = $model->getPath($langLocale);
                        if ($path && $path !== '#') {
                            if (!str_starts_with($path, 'http')) {
                                $url = route(
                                    'resolver',
                                    array_merge(['locale' => $langLocale, 'slug' => $path], $queryParams),
                                );
                            } else {
                                $url = $path;
                                if (!empty($queryParams)) {
                                    $separator = parse_url($url, PHP_URL_QUERY) == null ? '?' : '&';
                                    $url .= $separator . http_build_query($queryParams);
                                }
                            }
                        }
                    }
                }

                if (empty($url)) {
                    $tempParams = $routeParams;
                    $tempParams['locale'] = $langLocale;
                    $finalParams = array_merge($queryParams, $tempParams);
                    try {
                        $url = route($routeName, $finalParams);
                    } catch (\Exception $e) {
                        $url = null;
                    }
                }

                if ($url) {
                    $alternateLinks[$langLocale] = $url;
                }
            }
        }
    @endphp

    <title>{{ $seoTitle }}</title>

    <meta name="description" content="{{ $seoDescription }}">

    <meta name="robots" content="{{ $robotsContent }}">

    <link rel="canonical" href="{{ $canonicalUrl }}" />

    @foreach ($alternateLinks as $lang => $link)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ $link }}" />
    @endforeach

    @if (isset($alternateLinks[$fallbackLocale]))
        <link rel="alternate" hreflang="x-default" href="{{ $alternateLinks[$fallbackLocale] }}" />
    @endif

    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $currentUrl }}" />
    <meta property="og:title" content="{{ $seoTitle }}" />
    <meta property="og:description" content="{{ $seoDescription }}" />
    <meta property="og:image" content="{{ $seoImage }}" />
    <meta property="og:locale" content="{{ $locale }}" />
    <meta property="og:site_name" content="{{ setting('site.title') }}" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <link rel="icon" href="{{ rvfs('site.favicon') }}" type="image/png" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if (setting('contact-information.recaptcha-status') == "aktif")
        <script src="https://www.google.com/recaptcha/api.js"></script>
    @endif

    @if (setting('meta-tags.head'))
        {!! setting('meta-tags.head') !!}
    @endif

</head>

<body data-aether-auto>

    @if (setting('meta-tags.body'))
        {!! setting('meta-tags.body') !!}
    @endif

    @include('layout.navbar', ['locale' => $locale, 'viewModel' => $viewModel ?? null])

    @if (isset($viewModel) && method_exists($viewModel, 'getBreadcrumbs'))
        @php
            $breadcrumbs = $viewModel->getBreadcrumbs();
        @endphp

        @if ($breadcrumbs->count() > 1)
            <div id="breadcrumbs-bar"
                class="w-full sticky top-navbar z-[calc(var(--navbar-z)-1)] h-10 backdrop-blur-xl flex items-center border-b border-black transition-all duration-500 transform origin-top">
                <div class="aether-container flex items-center justify-between">
                    <x-breadcrumbs :links="$breadcrumbs" />
                </div>
            </div>
        @endif
    @endif

    <div>
        @yield('content')
    </div>

    @include('layout.footer', ['locale' => $locale, 'viewModel' => $viewModel ?? null])

    @include('layout.search-modal')
    @include('layout.theme-modal')

    @if (isset($globalPopups))
        @include('components.popup', ['popups' => $globalPopups])
    @endif

</body>

</html>