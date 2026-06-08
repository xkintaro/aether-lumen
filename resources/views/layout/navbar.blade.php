<header class="fixed top-0 w-full z-navbar border-b border-black backdrop-blur-xl h-navbar flex items-center">

    <div class="aether-container flex items-center justify-between h-full">

        <a href="{{ $homeUrl }}" class="flex items-center h-full relative">
            @if(rvf('site.logo'))
                <img src="{{ rvf('site.logo') }}" loading="eager" fetchpriority="high" alt="{{ setting('site.title') }}"
                    class="h-full max-h-[calc(var(--navbar-h)-35px)]" />
            @endif
        </a>

        <nav class="flex items-center gap-5">

            <div class="hidden xl:flex items-center gap-5">

                @foreach ($menuItems as $item)

                    <div class="relative group">

                        <a href="{{ $item->computedUrl }}" @if($item->hasChildren) data-aether-trigger="ui-control"
                        data-aether-target="desktop-{{ $item->targetId }}" @endif
                            class="px-3 py-2 inline-flex items-center text-sm font-medium hover:underline uppercase group">

                            {{ $item->title }}

                            @if ($item->hasChildren)
                                <i data-aether-icon="down-chevron" class="size-4 ml-1"></i>
                            @endif

                        </a>

                        @if ($item->hasChildren)

                            <div id="desktop-{{ $item->targetId }}" data-aether-click-outside
                                class="hidden absolute top-full right-0 mt-2 w-72 bg-white border border-black shadow-xl origin-top-right z-[calc(var(--navbar-z)+1)] overflow-hidden">

                                <a href="{{ $item->computedUrl }}"
                                    class="flex items-center justify-between p-5 border-b border-black">

                                    <div class="flex w-full items-center justify-between group">

                                        <span class="text-sm font-bold uppercase tracking-wider">{{ $item->title }}</span>
                                        <i data-aether-icon="right-arrow" class="size-4"></i>

                                    </div>

                                </a>

                                <div class="flex flex-col p-3 space-y-1">

                                    @foreach ($item->combinedChildren as $child)
                                        @include('layout.navbar-item', ['item' => $child])
                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

            <x-language-switcher :locale="$locale" :viewModel="$viewModel ?? null" uniqueId="navbar" variant="navbar" />

            <button data-aether-trigger="ui-control" data-aether-target="global-search" data-aether-sync-url
                class="size-8 p-2 cursor-pointer">
                <i data-aether-icon="magnifier" class="size-full"></i>
            </button>

            <button id="theme-toggle-btn" class="size-8 p-2 cursor-pointer">
                <i data-aether-icon="sun" id="icon-sun" class="size-full"></i>
                <i data-aether-icon="moon" id="icon-moon" class="size-full"></i>
            </button>

            <button data-aether-trigger="ui-control" data-aether-target="offcanvas" data-aether-sync-url
                class="size-8 p-2 cursor-pointer">
                <i data-aether-icon="menu" class="size-full"></i>
            </button>

        </nav>

    </div>

</header>

<div id="offcanvas" data-aether-scroll-lock data-aether-click-outside data-aether-focus-trap
    class="hidden fixed inset-0 z-popup">

    <div class="absolute inset-0 backdrop-blur-xl" data-aether-trigger="ui-control" data-aether-target="offcanvas">
    </div>

    <div class="aether-container max-sm:p-0 flex justify-end h-full">

        <div class="relative w-full sm:max-w-[450px] h-full xl:border-x border-black bg-white/80 flex flex-col">

            <div
                class="px-aether-container-gap sm:px-3 h-navbar border-b border-black flex items-center justify-between">

                <a href="{{ $homeUrl }}" class="flex items-center h-full relative">

                    @if(rvf('site.logo'))
                        <img src="{{ rvf('site.logo') }}" loading="lazy" fetchpriority="low"
                            alt="{{ setting('site.title') }}" class="h-full max-h-[calc(var(--navbar-h)-35px)]" />
                    @endif

                </a>

                <button data-aether-trigger="ui-control" data-aether-target="offcanvas"
                    class="size-10 p-2 cursor-pointer">
                    <i data-aether-icon="close" class="size-full"></i>
                </button>

            </div>

            <div class="flex-1 overflow-y-auto p-aether-container-gap sm:px-3 sm:py-6 space-y-6 no-scrollbar">

                <button data-aether-trigger="ui-control" data-aether-target="theme-settings" data-aether-sync-url
                    class="relative w-full flex items-center justify-between p-3 border border-black text-left overflow-hidden cursor-pointer">

                    <div class="relative flex items-center gap-3">

                        <i data-aether-icon="palette" class="size-8"></i>

                        <div class="flex flex-col">

                            <span class="text-sm font-bold">
                                @lang("Görünüm")
                            </span>

                            <span class="text-[10px] font-medium">
                                @lang("Tema ve renkleri düzenle")
                            </span>

                        </div>

                    </div>

                    <div class="relative">
                        <i data-aether-icon="right-chevron" class="size-4"></i>
                    </div>

                </button>

                <div class="space-y-1">

                    <div class="text-[10px] font-bold uppercase tracking-wider px-2 mb-2">
                        @lang("Navigasyon")
                    </div>

                    @foreach ($menuItems as $item)
                        @include('layout.offcanvas-item', ['item' => $item])
                    @endforeach

                </div>

            </div>

            <div class="p-5 border-t border-black space-y-4">
                <x-language-switcher :locale="$locale" :viewModel="$viewModel ?? null" uniqueId="offcanvas"
                    variant="offcanvas" />
            </div>

        </div>

    </div>

</div>