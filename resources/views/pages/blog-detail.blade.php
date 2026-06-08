@extends('layout.default')

@inject('catalogService', 'App\Services\CatalogService')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- CONTENT --}}

    <section class="aether-container">

        <h1>
            {{ $viewModel->getTitle() }}
        </h1>

        @if($viewModel->getExcerpt())
            <p>
                {{ $viewModel->getExcerpt() }}
            </p>
        @endif

        @if($viewModel->getDescription())
            <p>
                {{ $viewModel->getDescription() }}
            </p>
        @endif

        @if($viewModel->getContent())
            <p>
                {{ $viewModel->getContent() }}
            </p>
        @endif

    </section>

    {{-- CONTENT END --}}

    <div class="aether-section-gap"></div>


    {{-- PHOTOS --}}

    @if($viewModel->getGallery() && $viewModel->getGallery()->isNotEmpty())

        <section class="aether-container">

            photos

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($viewModel->getGallery() as $image)

                    <a href="{{ $image }}" data-fancybox="{{ $viewModel->getSlug() }}-gallery">
                        <img src="{{ $image }}" alt="{{ $viewModel->getTitle() }}" class="w-full aspect-video object-cover" />
                    </a>

                @endforeach

            </div>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- PHOTOS END --}}

    {{-- VIDEOS --}}

    @if($viewModel->getVideoGallery() && $viewModel->getVideoGallery()->isNotEmpty())

        <section class="aether-container">

            videos

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($viewModel->getVideoGallery() as $video)

                    <a href="{{ $video }}" data-fancybox="{{ $viewModel->getSlug() }}-gallery">
                        <img src="{{ $viewModel->getImage() }}" alt="{{ $viewModel->getTitle() }}" class="w-full aspect-video" />
                    </a>

                @endforeach

            </div>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- VIDEOS END --}}

    {{-- OTHER --}}

    @php
        /** @var \App\ViewModels\BlogViewModel $viewModel */

        $otherContents = method_exists($catalogService, 'getBlogs')
            ? $catalogService->getBlogs(app()->getLocale(), 10)
                ->reject(fn($item) => $item->getModel()->id == $viewModel->getModel()->id)
                ->values()
                ->take(10)
            : collect([]);

    @endphp

    @if($otherContents->isNotEmpty())

        <section class="aether-container">

            <h3>other contents</h3>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-5">

                @foreach($otherContents as $otherItem)

                    @php /** @var \App\ViewModels\BlogViewModel $otherItem */ @endphp

                    <a href="{{ $otherItem->getPath() }}" class="border border-black p-10">

                        @if ($otherItem->getImage())
                            <img src="{{ $otherItem->getImage() }}" alt="{{ $otherItem->getTitle() }}" class="w-48 h-48 object-cover" />
                        @endif

                        <h4>
                            {{ $otherItem->getTitle() }}
                        </h4>

                    </a>

                @endforeach

            </div>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- OTHER END --}}



@endsection