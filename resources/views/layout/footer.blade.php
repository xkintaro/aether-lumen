<footer class="aether-container relative overflow-hidden">

    <div class="flex flex-col lg:flex-row gap-3 justify-between items-center w-full">

        <a href="{{ $homeUrl }}" class="flex items-center">
            @if(setting('site.logo'))
                <img src="{{ rvf('site.logo') }}" loading="lazy" alt="{{ setting('site.title') }}"
                    class="h-full max-h-[calc(var(--navbar-h)-35px)]" />
            @endif
        </a>

        <div class="flex items-center w-fit gap-3">

            @foreach($footerSocialMedias as $social)

                <a href="{{ $social->getLink() }}" target="_blank" rel="noopener noreferrer"
                    title="{{ $social->getTitle() }}" class="size-8">

                    <i data-aether-icon="{{ $social->getIcon() }}" class="size-full"></i>

                </a>

            @endforeach

        </div>

    </div>

    <div class="flex w-full flex-wrap gap-10 items-start justify-between border-t border-black py-16 my-8">

        <div
            class="w-fit xl:max-w-[400px] flex flex-col gap-5 max-xl:mb-5 max-xl:mx-auto max-xl:text-center max-xl:justify-center max-xl:items-center">

            <p>
                @lang('Yenilikçi çözümler ve kaliteli hizmet anlayışımızla, sektördeki liderliğimizi sürdürüyor ve geleceği şekillendiriyoruz.')
            </p>

            <a href="{{ route('resolver', ['locale' => app()->getLocale(), 'slug' => __('routes.corporate')]) }}"
                class="max-xl:hidden flex items-center p-4 border border-black gap-1 w-fit">
                @lang('Kurumsal')
                <i data-aether-icon="right-arrow" class="size-4 "></i>
            </a>

            <x-language-switcher :locale="$locale" :viewModel="$viewModel ?? null" uniqueId="footer"
                variant="dropdown" />


        </div>

        <div class="w-fit flex flex-col gap-4">

            <h4 class="font-semibold sm:text-lg">@lang('Harita')</h4>

            <div class="flex flex-col gap-2 xl:gap-3.5">

                @foreach($footerPages as $page)
                    <a href="{{ $page->getPath() }}" class="max-sm:text-sm hover:underline">
                        {{ $page->getTitle() }}
                    </a>
                @endforeach

            </div>

        </div>

        <div class="w-fit flex flex-col gap-4">

            <h4 class="font-semibold sm:text-lg">@lang('Ürünler')</h4>

            <div class="flex flex-col gap-2 xl:gap-3.5">

                @foreach($footerCategories as $category)
                    <a href="{{ $category->getPath() }}" class="max-sm:text-sm hover:underline">
                        {{ $category->getName() }}
                    </a>
                @endforeach

            </div>

        </div>

        <div class="w-fit flex flex-col gap-4">

            <h4 class="font-semibold sm:text-lg">@lang('Haberler')</h4>

            <div class="flex flex-col gap-2 xl:gap-3.5">

                @foreach($footerNews as $news)
                    <a href="{{ $news->getPath() }}" class="max-sm:text-sm hover:underline">
                        {{ $news->getTitle() }}
                    </a>
                @endforeach

            </div>
        </div>

        <div class="w-fit flex flex-col gap-4">

            <h4 class="font-semibold sm:text-lg">@lang('İletişim')</h4>

            <div class="flex flex-col gap-2 xl:gap-3.5 max-w-[250px]">

                <a href="{{ setting('contact-information.google-maps-link') }}" target="_blank" class="max-sm:text-sm">
                    {!! nl2br(setting('contact-information.address')) !!}
                </a>

                @if(setting('contact-information.phone'))
                    <a href="tel:{{ str_replace(' ', '', setting('contact-information.phone')) }}" class="max-sm:text-sm">
                        {{ setting('contact-information.phone') }}
                    </a>
                @endif

                @if(setting('contact-information.email'))
                    <a href="mailto:{{ setting('contact-information.email') }}" class="max-sm:text-sm">
                        {{ setting('contact-information.email') }}
                    </a>
                @endif

            </div>

        </div>

    </div>

    <div class="flex flex-wrap w-full items-center justify-between mb-8 border-t border-black pt-8">
        <p class="text-sm">
            © {{ date('Y') }} {{ setting('site.title') }}. @lang('Tüm hakları saklıdır.')
        </p>
    </div>

</footer>

<button id="back-to-top" title="@lang('Yukarı Çık')"
    class="fixed bottom-5 right-5 z-50 size-10 p-2 xl:size-14 xl:p-4 cursor-pointer rounded-full bg-white border border-black translate-y-20 opacity-0 invisible transition-all duration-300 hover:-translate-y-1 focus:outline-none active:scale-95"
    aria-label="@lang('Yukarı Çık')">
    <i data-aether-icon="up-arrow" class="size-full"></i>
</button>