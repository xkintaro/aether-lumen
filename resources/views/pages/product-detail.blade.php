@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- HEADER --}}

    <section class="aether-container">

        @if($viewModel->getCategoryPath())

            <a href="{{ $viewModel->getCategoryPath() }}" class="flex items-center gap-1 w-fit">
                <i data-aether-icon="left-arrow" class="size-4"></i>
                {{ $viewModel->getCategoryName() }}
            </a>

        @else

            <a href="{{ route('resolver', ['locale' => app()->getLocale(), 'slug' => __('routes.products')]) }}"
                class="flex items-center gap-1 w-fit">
                <i data-aether-icon="left-arrow" class="size-4"></i>
                @lang('Ürünler')
            </a>

        @endif

        <h1>{{ $viewModel->getName() }}</h1>

    </section>

    {{-- HEADER END --}}

    <div class="aether-section-gap"></div>

    {{-- BREADCRUBS --}}

    <div class="aether-container">
        {{ $viewModel->getBreadcrumbs() }}
    </div>

    {{-- BREADCRUBS END --}}

    <div class="aether-section-gap"></div>

    {{-- MEDIA --}}

    <section class="aether-container">

        @if ($viewModel->getImage())

            <a href="{{ $viewModel->getImage() }}" data-fancybox="product-gallery">
                <img src="{{ $viewModel->getImage() }}" alt="{{ $viewModel->getName() }}" loading="eager" fetchpriority="high"
                    class="w-48 h-48 object-cover" />
            </a>

        @endif

        @php
            $gallery = $viewModel->getGallery(); 
        @endphp

        @if($gallery->isNotEmpty())

            <div class="flex gap-2.5 overflow-x-auto mt-5">

                @foreach($gallery as $item)

                    <a href="{{ $item }}" data-fancybox="product-gallery" class="p-1 border border-black">
                        <img src="{{ $item }}" alt="{{ $viewModel->getName() }}" loading="eager" fetchpriority="high"
                            class="w-24 h-24 object-cover" />
                    </a>

                @endforeach

            </div>

        @endif

    </section>

    {{-- MEDIA END --}}

    <div class="aether-section-gap"></div>

    {{-- EXCERPT --}}

    @if ($viewModel->getExcerpt())

        <section class="aether-container">

            <p>
                {{ $viewModel->getExcerpt() }}
            </p>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- EXCERPT END --}}


    {{-- DESCRIPTION --}}

    @if ($viewModel->getDescription())

        <section class="aether-container">

            {!! $viewModel->getDescription() !!}

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- DESCRIPTION END --}}


    {{-- CONTENT --}}

    @if ($viewModel->getContent())

        <section class="aether-container">

            <div class="aether-table-wrapper">
                {!! $viewModel->getContent() !!}
            </div>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- CONTENT END --}}

@endsection