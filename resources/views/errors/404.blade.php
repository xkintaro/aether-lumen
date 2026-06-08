<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('Sayfa Bulunamadı - 404')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-aether-auto
    class="font-default h-full flex flex-col overflow-hidden relative transition-colors duration-300">

    <main class="grow flex items-center justify-center relative w-full h-full">

        <div class="relative z-10 flex flex-col items-center justify-center text-center">

            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full select-none pointer-events-none -z-10">
                <h1
                    class="text-[12rem] md:text-[18rem] lg:text-[24rem] font-bold leading-none opacity-10 tracking-tighter">
                    404
                </h1>
            </div>

            <div class="space-y-6 md:space-y-8 animate-fade-in-up">

                <p class="font-semibold text-sm md:text-base">
                    @lang('HATA KODU'): 404
                </p>

                <h2 class="text-4xl! md:text-6xl! lg:text-7xl! font-semibold">
                    @lang('Sayfa') <span class="">@lang('Bulunamadı')</span>
                </h2>

                <p class="max-w-2xl mx-auto">
                    @lang("Aradığınız sayfa kaybolmuş veya taşınmış olabilir. Bağlantıyı kontrol edin veya ana sayfaya dönün.")
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">

                    <button onclick="window.history.length > 1 ? window.history.back() : window.location.href='/'"
                        class="aether-btn-1 group">
                        <i data-aether-icon="left-arrow"
                            class="size-5 transition-transform group-hover:-translate-x-1"></i>
                        <span>@lang('Geri Dön')</span>
                    </button>

                    <a href="{{ url('/' . app()->getLocale()) }}">
                        <span>@lang('Ana Sayfaya Dön')</span>
                    </a>

                </div>

            </div>

        </div>

    </main>

    <footer class="absolute bottom-8 w-full text-center">
        <p class="text-xs uppercase tracking-widest opacity-60">
            {{ setting('site.title') }}
        </p>
    </footer>

</body>

</html>