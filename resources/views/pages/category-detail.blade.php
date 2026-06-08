@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- HEADER --}}

    <section class="aether-container">

        {{-- BACK BUTTON --}}

        @if($parent = $viewModel->getParent())

            <a href="{{  $parent->getPath() }}" class="flex items-center gap-1 w-fit">
                <i data-aether-icon="left-arrow" class="size-4"></i>
                {{ $parent->getName() }}
            </a>

        @else

            <a href="{{ route('resolver', ['locale' => app()->getLocale(), 'slug' => __('routes.products')]) }}"
                class="flex items-center gap-1 w-fit">
                <i data-aether-icon="left-arrow" class="size-4"></i>
                @lang('Ürünler')
            </a>

        @endif

        {{-- BACK BUTTON END --}}

        <h1>
            {{ $viewModel->getName() }}
        </h1>

        @if($desc = $viewModel->getDescription())

            <div>
                {!! $desc !!}
            </div>

        @endif

    </section>

    {{-- HEADER END --}}

    <div class="aether-section-gap"></div>

    {{-- BREADCRUBS --}}

    <div class="aether-container">
        {{ $viewModel->getBreadcrumbs() }}
    </div>

    {{-- BREADCRUBS END --}}

    <div class="aether-section-gap"></div>

    {{-- SUB CATEGORIES --}}

    @php
        $children = $viewModel->getChildren();
        $hasChildren = $children && $children->isNotEmpty();
    @endphp

    @if($hasChildren)

        <section class="aether-container">


            <h2>@lang('Alt Kategoriler')</h2>

            <span>
                {{ $children->count() }} @lang('Parça')
            </span>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-5">

                @foreach ($children as $child)

                    <a href="{{ $child->getPath() }}" class="p-10 border border-black">

                        @if($child->getImage())
                            <img src="{{ $child->getImage() }}" loading="lazy" alt="{{ $child->getName() }}"
                                class="w-48 h-48 object-cover" />
                        @endif

                        <h3>
                            {{ $child->getName() }}
                        </h3>

                        <span>
                            {{ $child->getChildren()->count() + $child->getProducts()->count() }} @lang("Koleksiyon")
                        </span>

                    </a>

                @endforeach

            </div>

        </section>

        <div class="aether-section-gap"></div>

    @endif

    {{-- SUB CATEGORIES END --}}


    {{-- PRODUCTS --}}

    @php

        $products = $viewModel->getProducts();

    @endphp

    <section class="aether-container">

        @if($products && $products->isNotEmpty())

            <h2>@lang('Ürünler')</h2>

            <span>
                {{ $products->count() }} @lang('Parça')
            </span>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-5">

                @foreach ($products as $product)

                    <a href="{{ $product->getPath() }}" class="p-10 border border-black">

                        @if ($product->getImage())
                            <img src="{{ $product->getImage() }}" loading="lazy" alt="{{ $product->getName() }}"
                                class="w-48 h-48 object-cover" />
                        @endif

                        <h3>
                            {{ $product->getName() }}
                        </h3>

                        <span>
                            {{ $viewModel->getName() }}
                        </span>

                    </a>

                @endforeach

            </div>

        @else

            @if(!$hasChildren)
                <x-error-state :title="__('Henüz Ürün Yok')" :description="__('Bu kategoriye ait ürünler yakında eklenecektir.')" />
            @endif

        @endif

    </section>

    {{-- PRODUCTS END --}}

    <div class="aether-section-gap"></div>

@endsection