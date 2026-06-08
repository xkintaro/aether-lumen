@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- HEADER --}}

    <section class="aether-container">
        <h1>
            {{ $viewModel->getTitle() }}
        </h1>
    </section>

    {{-- HEADER END --}}

    <div class="aether-section-gap"></div>

    {{-- BREADCRUBS --}}

    <div class="aether-container">
        {{ $viewModel->getBreadcrumbs() }}
    </div>

    {{-- BREADCRUBS END --}}

    <div class="aether-section-gap"></div>

    {{-- ROOT CATEGORIES --}}

    <section class="aether-container">

        @if($viewModel->getRootCategories()->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($viewModel->getRootCategories() as $category)

                    <a href="{{ $category->getPath() }}" class="border border-black p-10">

                        @if($category->getImage())
                            <img src="{{ $category->getImage() }}" loading="lazy" alt="{{ $category->getName() }}"
                                class="w-48 h-48 object-cover" />
                        @endif

                        <h2>
                            {{ $category->getName() }}
                        </h2>

                        <span>
                            {{ $category->getChildren()->count() + $category->getProducts()->count() }}
                            @lang("Koleksiyon")
                        </span>

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Kategori Bulunamadı')" :description="__('Henüz görüntülenecek kategori bulunmamaktadır.')" />
        @endif

    </section>

    {{-- ROOT CATEGORIES END --}}

    <div class="aether-section-gap"></div>

    {{-- PRODUCTS FILTERS --}}

    <section id="aether-ajax-products-wrapper" class="aether-container">
        @include('pages.products-list-ajax')
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('aether-ajax-products-wrapper');
            let searchTimeout;

            let lastCursorPosition = 0;
            let isSearchFocused = false;

            function refreshIcons() {
                if (window.AetherUI && window.AetherUI.Icons) {
                    window.AetherUI.Icons.render(wrapper);
                }
            }

            wrapper.addEventListener('click', function (e) {
                const link = e.target.closest('.aether-ajax-pagination-container a');
                if (link) {
                    e.preventDefault();
                    fetchProducts(link.href);
                    return;
                }

                const resetBtn = e.target.closest('.aether-ajax-reset-btn');
                if (resetBtn) {
                    e.preventDefault();
                    const baseUrl = window.location.href.split('?')[0];
                    fetchProducts(baseUrl);
                }
            });

            wrapper.addEventListener('change', function (e) {
                if (e.target.classList.contains('aether-ajax-filter-select')) {
                    submitFilter();
                }
            });

            wrapper.addEventListener('submit', function (e) {
                if (e.target.id === 'aether-ajax-product-filter-form') {
                    e.preventDefault();
                    submitFilter();
                }
            });

            wrapper.addEventListener('input', function (e) {
                if (e.target.id === 'aether-ajax-search-input') {
                    lastCursorPosition = e.target.selectionStart;
                    isSearchFocused = true;

                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        submitFilter();
                    }, 600);
                }
            });

            wrapper.addEventListener('focusout', function (e) {
                if (e.target.id === 'aether-ajax-search-input') { }
            });

            function submitFilter() {
                const form = document.getElementById('aether-ajax-product-filter-form');
                if (!form) return;

                const formData = new FormData(form);
                const params = new URLSearchParams();

                for (const [key, value] of formData.entries()) {
                    const cleanValue = typeof value === 'string' ? value.trim() : value;

                    if (cleanValue !== "") {
                        params.append(key, cleanValue);
                    }
                }

                const baseUrl = window.location.href.split('?')[0];
                const queryString = params.toString();

                const url = queryString ? `${baseUrl}?${queryString}` : baseUrl;

                fetchProducts(url);
            }

            async function fetchProducts(url) {
                const loading = document.getElementById('aether-ajax-products-loading');

                if (!isSearchFocused && loading) {
                    loading.classList.remove('hidden');
                }

                window.history.pushState({}, '', url);

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-Aether-Ajax': 'true'
                        }
                    });

                    if (!response.ok) throw new Error('Network error');

                    const html = await response.text();

                    wrapper.innerHTML = html;

                    if (isSearchFocused) {
                        const searchInput = document.getElementById('aether-ajax-search-input');
                        if (searchInput) {
                            searchInput.focus();

                            searchInput.setSelectionRange(lastCursorPosition, lastCursorPosition);
                        }
                    }

                    refreshIcons();

                    if (!isSearchFocused) {
                        const filterSection = document.getElementById('aether-ajax-product-filters-section');
                        if (filterSection) {
                            filterSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }

                } catch (error) {
                    console.error('Error fetching products:', error);
                } finally {
                    if (loading) loading.classList.add('hidden');
                }
            }

            window.addEventListener('popstate', function () {
                isSearchFocused = false;
                fetchProducts(window.location.href);
            });
        });
    </script>

    {{-- PRODUCTS FILTERS END --}}

    <div class="aether-section-gap"></div>


@endsection