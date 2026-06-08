@extends('voyager::master')

@section('page_title', 'İkon Paketi')

@section('page_header')
<h1 class="page-title">
    <i class="voyager-heart"></i> İkon Paketi
</h1>
@stop

@section('css')
<style>
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .icon-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .icon-card:hover {
        border-color: var(--primary-custom);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .icon-card:active {
        transform: scale(0.95);
    }

    .icon-preview {
        width: 28px;
        height: 28px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .icon-preview svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    .icon-name {
        font-size: 12px;
        color: #666;
        word-break: break-all;
        font-family: monospace;
    }

    .search-container {
        margin-bottom: 30px;
    }

    .copy-success {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: #2ecc71;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 10px;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    .icon-card.copied .copy-success {
        opacity: 1;
    }
</style>
@stop

@section('content')
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="search-container">
                        <div class="row">
                            <div class="col-md-12" style="display: flex; justify-content: space-between;">
                                <label
                                    style="margin: 0; font-weight: normal; display: inline-flex; align-items:center; gap: 5px;">
                                    {{ __('voyager::generic.search') }}:
                                    <input type="text" id="icon-search" class="form-control input-sm"
                                        autocomplete="off">
                                </label>
                                <div id="icon-count"
                                    style="color: #666; font-size: 15px; font-family: monospace; font-weight: 500;">
                                    Toplam: 0 ikon
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="icon-list" class="icon-grid">
                        <div class="loading-state">İkonlar yükleniyor...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
@php
    $iconsFile = resource_path('js/aether-icons.js');
    $content = file_get_contents($iconsFile);

    $jsContent = str_replace('export default AetherIcons;', '', $content);
    $jsContent = preg_replace('/document\.addEventListener\("DOMContentLoaded".*?\}\);/s', '', $jsContent);
@endphp

<script>
    {!! $jsContent !!}

    document.addEventListener('DOMContentLoaded', function () {
        const iconList = document.getElementById('icon-list');
        const searchInput = document.getElementById('icon-search');
        const iconsLibrary = AetherIcons.library;

        function renderIcons(filter = '') {
            iconList.innerHTML = '';

            const filteredKeys = Object.keys(iconsLibrary).filter(key =>
                key.toLowerCase().includes(filter.toLowerCase())
            );

            const iconCountEl = document.getElementById('icon-count');
            if (filter) {
                iconCountEl.textContent = `${filteredKeys.length} / ${Object.keys(iconsLibrary).length} ikon gösteriliyor`;
            } else {
                iconCountEl.textContent = `Toplam: ${filteredKeys.length} ikon`;
            }

            if (filteredKeys.length === 0) {
                iconList.innerHTML = '<div style="padding: 20px;">ikon bulunamadı.</div>';
                return;
            }

            filteredKeys.forEach(key => {
                const card = document.createElement('div');
                card.className = 'icon-card';
                card.title = 'İsmi kopyalamak için tıkla';
                card.innerHTML = `
                    <div class="icon-preview">${iconsLibrary[key]}</div>
                    <div class="icon-name">${key}</div>
                    <div class="copy-success">Kopyalandı!</div>
                `;

                card.addEventListener('click', () => {
                    copyToClipboard(key, card);
                });

                iconList.appendChild(card);
            });
        }

        function copyToClipboard(text, card) {
            if (!navigator.clipboard) {
                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                showCopied(card);
                return;
            }

            navigator.clipboard.writeText(text).then(() => {
                showCopied(card);
            });
        }

        function showCopied(card) {
            card.classList.add('copied');
            setTimeout(() => {
                card.classList.remove('copied');
            }, 2000);
        }

        searchInput.addEventListener('input', (e) => {
            renderIcons(e.target.value);
        });

        renderIcons();
    });
</script>
@stop