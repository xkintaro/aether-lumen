@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    <div class="aether-container">

        <div class="max-w-2xl mx-auto text-center">

            <div class="rounded-full border border-black/50 p-8 mb-6 w-fit mx-auto animate-pulse">
                <i data-aether-icon="magnifier" class="size-10"></i>
            </div>

            <h1 class="mb-4 text-xl sm:text-2xl font-bold">
                @lang('Birden fazla sonuç bulundu')
            </h1>

            <p class="mb-8 text-sm sm:text-base">

                <span class="font-bold underline">{{ $slug }}</span>

                @lang('adresi için sistemimizde birden fazla kayıt eşleşiyor. Lütfen gitmek istediğiniz sayfayı seçiniz:')

            </p>

            <div class="flex flex-col gap-4">

                @foreach($matches as $data)

                    @php
                        $routeParams = [
                            'locale' => $locale,
                            'slug' => $data['path']
                        ];

                        if ($data['needs_target']) {
                            $routeParams['target'] = $data['type'];
                        }

                        $url = route('resolver', $routeParams);
                    @endphp

                    <a href="{{ $url }}"
                        class="p-5 flex items-center justify-between rounded-xl border border-black/50 hover:translate-x-2 transition-transform duration-300">

                        <div class="flex items-center gap-4">

                            @if($data['type'] === 'page')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>

                            @elseif($data['type'] === 'category')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>

                            @elseif($data['type'] === 'product')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>

                            @elseif($data['type'] === 'blog')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>

                            @elseif($data['type'] === 'news')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>

                            @elseif($data['type'] === 'project')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>

                            @elseif($data['type'] === 'reference')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif

                            <div class="text-left">

                                <h3 class="font-semibold">
                                    {{ $data['title'] }}
                                </h3>

                                <p class="text-sm">

                                    @if($data['type'] === 'page') @lang('Sayfa')
                                    @elseif($data['type'] === 'category') @lang('Kategori')
                                    @elseif($data['type'] === 'product') @lang('Ürün')
                                    @elseif($data['type'] === 'blog') @lang('Blog')
                                    @elseif($data['type'] === 'news') @lang('Haber')
                                    @elseif($data['type'] === 'project') @lang('Proje')
                                    @elseif($data['type'] === 'reference') @lang('Referans')
                                    @endif

                                    <span class="text-xs ml-2 font-mono px-2">/{{ $data['path'] }}</span>
                                </p>

                            </div>

                        </div>

                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

@endsection