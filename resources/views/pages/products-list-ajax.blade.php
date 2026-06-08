<div id="aether-ajax-product-filters-section">

    <form id="aether-ajax-product-filter-form" action="{{ url()->current() }}" method="GET"
        class="border border-black p-6 overflow-x-auto flex flex-col gap-5">

        <input type="text" name="q" id="aether-ajax-search-input" value="{{ $query }}"
            placeholder="@lang('Ürün adı...')" class="w-full border border-black p-4" />

        @foreach($categoryDropdowns as $dropdown)

            <div class="flex flex-col gap-2">

                <label class="text-xs font-bold uppercase tracking-wider">
                    {{ $dropdown->level == 0 ? __('Ana Kategori') : __('Alt Kategori') }}
                </label>

                <div class="relative">

                    <select name="{{ $dropdown->name }}" class="aether-ajax-filter-select w-full border border-black p-4">

                        <option value="">@lang('Tümü')</option>

                        @foreach($dropdown->options as $option)

                            <option value="{{ $option->id }}" {{ $dropdown->selected_id == $option->id ? 'selected' : '' }}>
                                {{ $option->translate($locale)->name ?? $option->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        @endforeach

        <button type="submit" class="p-4 border border-black w-fit">
            @lang('Filtrele')
        </button>

        @if(!empty($query) || !empty($filters['category_ids']))

            <a href="{{ url()->current() }}" title="@lang('Filtreleri Temizle')"
                class="aether-ajax-reset-btn p-4 border border-black w-fit">
                <i data-aether-icon="close" class="size-6"></i>
            </a>

        @endif

    </form>

</div>

<div class="relative mt-5">

    <div id="aether-ajax-products-loading"
        class="hidden flex absolute inset-0 z-10 backdrop-blur-md items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-black border-t-transparent"></div>
    </div>

    @if($productViewModels->total() > 0)

        <p>
            @lang('Toplam')
            <span class="font-bold">
                {{ $productViewModels->total() }}
            </span>
            @lang('ürün listeleniyor.')
        </p>

    @endif

    @if($productViewModels->count() > 0)

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-5">

            @foreach($productViewModels as $product)

                <a href="{{ $product->getPath() }}" class="border border-black p-10">

                    @if($product->getImage())
                        <img src="{{ $product->getImage() }}" loading="lazy" alt="{{ $product->getName() }}"
                            class="w-48 h-48 object-cover" />
                    @endif

                    <h3>
                        {{ $product->getName() }}
                    </h3>

                    <span>
                        {{ $product->getCategoryName() }}
                    </span>

                </a>

            @endforeach

        </div>

        @if($productViewModels->hasPages())
            <div class="aether-ajax-pagination-container py-16 flex justify-center">
                {{ $productViewModels->appends(request()->query())->links('pagination::aether') }}
            </div>
        @endif

    @else
        <x-error-state title="{{ __('Sonuç Bulunamadı') }}"
            description="{{ __('Arama kriterlerinize uygun ürün bulunamadı.') }}">

            <button type="button" class="aether-ajax-reset-btn p-4 border border-black w-fit">
                @lang('Tüm Ürünleri Göster')
            </button>

        </x-error-state>
    @endif

</div>