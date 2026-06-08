@extends('voyager::master')

@section('page_title', __('admin.translations'))

@section('page_header')
<h1 class="page-title">
    <i class="voyager-world"></i> {{ __('admin.translations') }}
</h1>
<form action="{{ route('admin.translations.scan') }}" method="POST"
    style="display:inline-block; margin-left: 10px; vertical-align:middle;">
    @csrf
    <button type="submit" class="btn btn-warning">
        <i class="voyager-refresh"></i> {{ __('admin.translations_scan') }}
    </button>
</form>
<a href="javascript:;" id="bulk_delete_btn" class="btn btn-danger" style="display: none; margin: 0;">
    <i class="voyager-trash"></i> Toplu Sil
</a>
@stop

@section('content')
<div class="page-content container-fluid">
    @include('voyager::alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">

                    <div
                        style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px;">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <label
                                style="margin: 0; font-weight: normal; display: flex; align-items: center; gap: 5px;">
                                <select id="per_page_dropdown" class="form-control input-sm" style="width: 70px;">
                                    <option value="10" {{ (isset($perPage) && $perPage == 10) ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ (isset($perPage) && $perPage == 25) ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ (isset($perPage) && $perPage == 50) ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ (isset($perPage) && $perPage == 100) ? 'selected' : '' }}>100
                                    </option>
                                </select>
                                kayıtlarını göster
                            </label>
                        </div>

                        <label
                            style="margin: 0; font-weight: normal; display: inline-flex; align-items:center; gap: 5px;">
                            {{ __('voyager::generic.search') }}:
                            <input type="text" id="search_input" class="form-control input-sm" value="{{ $search }}"
                                autocomplete="off">
                        </label>
                    </div>

                    <div id="ajax-update-container">
                        <form action="{{ route('admin.translations.update') }}" method="POST">
                            @csrf

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover dataTable no-footer" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th class="dt-not-orderable sorting_disabled" style="width: 30px;">
                                                <input type="checkbox" id="select_all">
                                            </th>
                                            <th class="sorting_disabled" style="width: 20%;">Key</th>
                                            @foreach($locales as $locale)
                                                <th class="sorting_disabled">
                                                    {{ strtoupper($locale) }}
                                                </th>
                                            @endforeach
                                            <th class="actions text-right dt-not-orderable sorting_disabled"
                                                style="width: 100px;">
                                                {{ __('voyager::generic.actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($translations as $key => $vals)
                                            <tr role="row">
                                                <td>
                                                    <input type="checkbox" class="row_id" value="{{ base64_encode($key) }}">
                                                </td>
                                                <td>
                                                    <code
                                                        style="display:block; word-break:break-all; width: fit-content; color: #555;">{{ $key }}</code>
                                                </td>

                                                @foreach($locales as $locale)
                                                    <td>
                                                        <textarea name="translations[{{ base64_encode($key) }}][{{ $locale }}]"
                                                            class="form-control" rows="2"
                                                            style="min-width: 150px; min-height: 150px; font-size: 13px; border: 1px solid #eee;">{{ $vals[$locale] ?? '' }}</textarea>
                                                    </td>
                                                @endforeach

                                                <td class="text-right">
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-key="{{ base64_encode($key) }}" title="Delete">
                                                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr role="row" class="odd">
                                                <td colspan="{{ count($locales) + 3 }}" class="dataTables_empty"
                                                    style="text-align: center;">
                                                    Çeviri Bulunamadı.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row" style="display: flex; align-items: center; margin-top: 15px;">
                                <div class="col-sm-4 text-left">
                                    <div role="status" class="show-res" aria-live="polite"
                                        style="color: #777; margin: 0;">
                                        @if($translations->total() > 0)
                                            Toplam {{ $translations->total() }} kayıttan {{ $translations->firstItem() }} -
                                            {{ $translations->lastItem() }} arası gösteriliyor
                                        @else
                                            {{ __('voyager::generic.no_results') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <style>
                                        .pagination {
                                            margin: 0;
                                        }
                                    </style>
                                    {{ $translations->links('pagination::bootstrap-4') }}
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 0;">
                                        {{ __('voyager::generic.save') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete_form" action="{{ route('admin.translations.delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="key" id="delete_key">
</form>

<form id="bulk_delete_form" action="{{ route('admin.translations.bulkDelete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk_delete_input">
</form>

@stop

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        let searchInput = document.getElementById('search_input');
        let perPageDropdown = document.getElementById('per_page_dropdown');
        let timeout = null;

        function fetchResults(url) {
            document.getElementById('ajax-update-container').style.opacity = '0.5';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');

                    document.getElementById('ajax-update-container').innerHTML = doc.getElementById('ajax-update-container').innerHTML;
                    document.getElementById('ajax-update-container').style.opacity = '1';

                    bindCheckboxEvents();

                    document.getElementById('bulk_delete_btn').style.display = 'none';
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function triggerSearch() {
            let searchVal = searchInput.value;
            let perPage = perPageDropdown.value;

            let url = new URL("{{ route('admin.translations.index') }}", window.location.origin);
            if (searchVal) url.searchParams.set('s', searchVal);
            if (perPage) url.searchParams.set('per_page', perPage);

            fetchResults(url.href);
        }

        if (searchInput) {
            let val = searchInput.value;
            searchInput.focus();
            searchInput.value = '';
            searchInput.value = val;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(triggerSearch, 400);
            });
        }

        if (perPageDropdown) {
            perPageDropdown.addEventListener('change', triggerSearch);
        }

        document.body.addEventListener('click', function (e) {

            let paginationLink = e.target.closest('.pagination a');
            if (paginationLink) {
                e.preventDefault();
                fetchResults(paginationLink.href);
                return;
            }

            let deleteBtn = e.target.closest('.btn-delete');
            if (deleteBtn) {
                if (confirm('Bu çeviriyi silmek istediğinize emin misiniz?')) {
                    document.getElementById('delete_key').value = deleteBtn.getAttribute('data-key');
                    document.getElementById('delete_form').submit();
                }
                return;
            }

            let bulkBtnTarget = e.target.closest('#bulk_delete_btn');
            if (bulkBtnTarget) {
                let checked = [];
                document.querySelectorAll('.row_id:checked').forEach(cb => checked.push(cb.value));

                if (checked.length > 0 && confirm('Seçilen ' + checked.length + ' çeviriyi silmek istediğinize emin misiniz?')) {
                    document.getElementById('bulk_delete_input').value = JSON.stringify(checked);
                    document.getElementById('bulk_delete_form').submit();
                }
                return;
            }
        });

        function bindCheckboxEvents() {
            let selectAll = document.getElementById('select_all');
            let rowIds = document.querySelectorAll('.row_id');
            let bulkBtn = document.getElementById('bulk_delete_btn');

            function toggleBulkButton() {
                let checkedCount = document.querySelectorAll('.row_id:checked').length;
                if (bulkBtn) bulkBtn.style.display = checkedCount > 0 ? 'inline-block' : 'none';
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    rowIds.forEach(cb => cb.checked = this.checked);
                    toggleBulkButton();
                });
            }

            rowIds.forEach(cb => {
                cb.addEventListener('change', toggleBulkButton);
            });
        }

        bindCheckboxEvents();
    });
</script>
@stop