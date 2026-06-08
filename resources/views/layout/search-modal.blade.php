<div id="global-search" data-aether-scroll-lock data-aether-click-outside data-aether-focus-trap
    class="hidden fixed inset-0 z-popup flex items-start justify-center pt-[12vh] px-4">

    <div class="absolute inset-0 backdrop-blur-xl" data-aether-trigger="ui-control" data-aether-target="global-search">
    </div>

    <div class="w-full relative max-w-xl border border-black bg-white shadow-2xl overflow-hidden z-10">

        <div class="flex items-center px-4 py-4 border-b border-black">
            <i data-aether-icon="magnifier" class="size-5 mr-2.5"></i>

            <input type="text" id="globalSearchInput" placeholder="{{ __('Arama yapın...') }}"
                class="flex-1 bg-transparent border-none outline-none h-7" autocomplete="off" data-aether-autofocus />

            <kbd data-aether-trigger="ui-control" data-aether-target="global-search"
                class="text-xs cursor-pointer font-mono font-bold">
                ESC
            </kbd>
        </div>

        <div class="p-2 max-h-[60vh] overflow-y-auto  relative min-h-[100px]">

            <div id="globalSearchLoading"
                class="hidden absolute inset-0 flex flex-col items-center justify-center z-20">

                <svg class="animate-spin h-6 w-6 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span class="text-xs">{{ __('Aranıyor...') }}</span>
            </div>

            <div id="globalSearchEmpty" class="hidden flex flex-col items-center justify-center py-8">
                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">{{ __('Sonuç bulunamadı.') }}</p>
            </div>

            <div id="globalSearchResults"></div>

            <div id="globalSearchPlaceholder" class="text-center py-8 text-sm">
                {{ __('Aramak istediğiniz kelimeyi yazmaya başlayın.') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('globalSearchInput');
        const resultsContainer = document.getElementById('globalSearchResults');
        const loadingState = document.getElementById('globalSearchLoading');
        const emptyState = document.getElementById('globalSearchEmpty');
        const placeholderState = document.getElementById('globalSearchPlaceholder');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                clearTimeout(searchTimeout);

                resultsContainer.innerHTML = '';
                emptyState.classList.add('hidden');
                placeholderState.classList.add('hidden');

                if (query.length < 2) {
                    loadingState.classList.add('hidden');
                    placeholderState.classList.remove('hidden');
                    return;
                }

                loadingState.classList.remove('hidden');

                searchTimeout = setTimeout(() => {
                    fetchResults(query);
                }, 300);
            });
        }

        async function fetchResults(query) {
            const locale = document.documentElement.lang || 'tr';
            const url = `/${locale}/api/global-search?q=${encodeURIComponent(query)}`;

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                loadingState.classList.add('hidden');

                if (data.total === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    renderResults(data);
                }
            } catch (error) {
                console.error('Search error:', error);
                loadingState.classList.add('hidden');
            }
        }

        function renderResults(data) {
            let html = '';
            for (const [key, items] of Object.entries(data.results)) {
                if (items.length > 0) {
                    const label = data.labels[key] ? data.labels[key] : key;
                    html += `
                        <div class="text-[10px] font-bold px-3 py-2 uppercase tracking-wider mt-2 first:mt-0 border-b border-black">
                            ${label} <span class="opacity-50">(${items.length})</span>
                        </div>
                        <div class="space-y-1 mt-1 mb-3">
                    `;
                    items.forEach(item => {
                        const imgContent = item.image ?
                            `<img src="${item.image}" class="w-8 h-8 object-cover shadow-sm">` :
                            `<div class="w-8 h-8 border border-black/20 flex items-center justify-center">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                               </div>`;

                        html += `
                            <a href="${item.url}" class="flex items-center gap-3 px-3 py-2 group transition-colors cursor-pointer">
                                <div>${imgContent}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium truncate transition-colors">
                                        ${item.title}
                                    </div>
                                </div>
                                <svg class="size-4 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        `;
                    });
                    html += `</div>`;
                }
            }
            resultsContainer.innerHTML = html;
        }
    });
</script>