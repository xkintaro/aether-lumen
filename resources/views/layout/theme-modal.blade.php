<div id="theme-settings" data-aether-scroll-lock data-aether-click-outside data-aether-focus-trap
    class="hidden fixed inset-0 z-popup flex items-start justify-center pt-[12vh] px-4">

    <div class="absolute inset-0 backdrop-blur-xl transition-opacity" data-aether-trigger="ui-control"
        data-aether-target="theme-settings"></div>

    <div
        class="w-full relative max-w-lg border border-black bg-white/80 overflow-hidden z-10 flex flex-col max-h-[70vh]">

        <div class="flex items-center justify-between px-5 py-4 border-b border-black shrink-0">

            <h3 class="flex items-center gap-1.5">
                <i data-aether-icon="palette" class="size-6"></i>
                @lang("Tema Ayarları")
            </h3>

            <kbd data-aether-trigger="ui-control" data-aether-target="theme-settings"
                class="text-xs cursor-pointer font-mono font-bold">
                ESC
            </kbd>

        </div>

        <div class="p-5 overflow-y-auto ">

            <div class="mb-6">

                <span class="text-xs font-bold uppercase tracking-wider mb-3 px-1">
                    @lang("Temalar")
                </span>

                <div class="grid grid-cols-3 gap-3">

                    <button
                        class="theme-btn flex flex-col items-center justify-center gap-2 border border-black p-3"
                        data-aether-theme="system">
                        <i data-aether-icon="desktop" class="size-6"></i>
                        <span class="text-xs font-medium">@lang("Sistem")</span>
                    </button>

                    <button
                        class="theme-btn flex flex-col items-center justify-center gap-2 border border-black p-3"
                        data-aether-theme="light">
                        <i data-aether-icon="sun" class="size-6"></i>
                        <span class="text-xs font-medium">@lang("Aydınlık")</span>
                    </button>

                    <button
                        class="theme-btn flex flex-col items-center justify-center gap-2 border border-black p-3"
                        data-aether-theme="dark">
                        <i data-aether-icon="moon" class="size-6"></i>
                        <span class="text-xs font-medium">@lang("Karanlık")</span>
                    </button>

                </div>

            </div>

            <span class="text-xs font-bold uppercase tracking-wider mb-3 block px-1">
                @lang("Özel Temalar")
            </span>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="slate">
                    <span class="size-4 rounded-full" style="background-color: #64748b;"></span>
                    <span class="text-sm font-medium">Slate</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="blue">
                    <span class="size-4 rounded-full" style="background-color: #3b82f6;"></span>
                    <span class="text-sm font-medium">Blue</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="indigo">
                    <span class="size-4 rounded-full" style="background-color: #6366f1;"></span>
                    <span class="text-sm font-medium">Indigo</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="purple">
                    <span class="size-4 rounded-full" style="background-color: #9333ea;"></span>
                    <span class="text-sm font-medium">Purple</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="pink">
                    <span class="size-4 rounded-full" style="background-color: #db2777;"></span>
                    <span class="text-sm font-medium">Pink</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="rose">
                    <span class="size-4 rounded-full" style="background-color: #e11d48;"></span>
                    <span class="text-sm font-medium">Rose</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="red">
                    <span class="size-4 rounded-full" style="background-color: #dc2626;"></span>
                    <span class="text-sm font-medium">Red</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="orange">
                    <span class="size-4 rounded-full" style="background-color: #f97316;"></span>
                    <span class="text-sm font-medium">Orange</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="yellow">
                    <span class="size-4 rounded-full" style="background-color: #eab308;"></span>
                    <span class="text-sm font-medium">Yellow</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="lime">
                    <span class="size-4 rounded-full" style="background-color: #84cc16;"></span>
                    <span class="text-sm font-medium">Lime</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="green">
                    <span class="size-4 rounded-full" style="background-color: #16a34a;"></span>
                    <span class="text-sm font-medium">Green</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="teal">
                    <span class="size-4 rounded-full" style="background-color: #14b8a6;"></span>
                    <span class="text-sm font-medium">Teal</span>
                </button>

                <button class="theme-btn flex items-center gap-3 border border-black p-2"
                    data-aether-theme="cyan">
                    <span class="size-4 rounded-full" style="background-color: #06b6d4;"></span>
                    <span class="text-sm font-medium">Cyan</span>
                </button>

            </div>

        </div>

    </div>

</div>