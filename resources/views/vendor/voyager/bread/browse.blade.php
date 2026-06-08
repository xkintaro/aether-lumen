@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing') . ' ' . $dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.' . $dataType->slug . '.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if (!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.' . $dataType->slug . '.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if ($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes"
                    data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}"
                    data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach ($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        <div class="btn-group export-unified-dropdown pull-right" style="margin-right: 5px;">
            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="voyager-download"></i> <span class="hidden-xs hidden-sm">{{ __('admin.export') }}</span> <span
                    class="caret"></span>
            </button>
            <ul class="dropdown-menu export-menu-glass">
                <li class="dropdown-header">{{ __('admin.settings') }}</li>
                <li class="export-setting-item" style="padding: 5px 20px;">
                    <label onclick="event.stopPropagation();"
                        style="font-weight: normal; cursor: pointer; display: flex; align-items: center;">
                        <input type="checkbox" id="include-media-toggle-unified" style="margin-right: 8px;">
                        <span>{{ __('admin.media_and_visuals') }} (ZIP)</span>
                    </label>
                </li>

                <li role="separator" class="divider"></li>

                <li class="dropdown-header">{{ __('admin.all_records') }}</li>
                <li><a href="#" class="export-link-unified" data-type="all" data-format="csv"><i
                            class="voyager-file-text"></i> CSV (Excel)</a></li>
                <li><a href="#" class="export-link-unified" data-type="all" data-format="json"><i
                            class="voyager-code"></i> JSON</a></li>


                <li role="separator" class="divider"></li>

                <li class="dropdown-header export-selected-header">{{ __('admin.selected_rows') }} (<span
                        id="selected-count-unified">0</span>)</li>
                <li class="selected-item disabled"><a href="#" class="export-link-unified" data-type="selected"
                        data-format="csv"><i class="voyager-file-text"></i> CSV (Excel)</a></li>
                <li class="selected-item disabled"><a href="#" class="export-link-unified" data-type="selected"
                        data-format="json"><i class="voyager-code"></i> JSON</a></li>

            </ul>
        </div>

        @can('add', app($dataType->model_name))
            <button type="button" class="btn btn-dark pull-right" id="btn-import-unified" style="margin-right: 5px;">
                <i class="voyager-upload"></i> <span class="hidden-xs hidden-sm">{{ __('admin.import') }}</span>
            </button>
        @endcan

        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach ($searchNames as $key => $name)
                                                <option value="{{ $key }}"
                                                    @if ($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if ($search->filter == 'contains') selected @endif>
                                                {{ __('voyager::generic.contains') }}</option>
                                            <option value="equals" @if ($search->filter == 'equals') selected @endif>=
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('voyager::generic.search') }}" name="s"
                                            value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        @if ($showCheckboxColumn)
                                            <th class="dt-not-orderable">
                                                <input type="checkbox" class="select_all">
                                            </th>
                                        @endif
                                        @foreach ($dataType->browseRows as $row)
                                            <th>
                                                @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                    <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                @endif
                                                {{ $row->getTranslatedAttribute('display_name') }}
                                                @if ($isServerSide)
                                                    @if ($row->isCurrentSortField($orderBy))
                                                        @if ($sortOrder == 'asc')
                                                            <i class="voyager-angle-up pull-right"></i>
                                                        @else
                                                            <i class="voyager-angle-down pull-right"></i>
                                                        @endif
                                                    @endif
                                                    </a>
                                                @endif
                                            </th>
                                        @endforeach
                                        <th class="actions text-right dt-not-orderable">
                                            {{ __('voyager::generic.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTypeContent as $data)
                                        <tr>
                                            @if ($showCheckboxColumn)
                                                <td>
                                                    <input type="checkbox" name="row_id"
                                                        id="checkbox_{{ $data->getKey() }}"
                                                        value="{{ $data->getKey() }}">
                                                </td>
                                            @endif
                                            @foreach ($dataType->browseRows as $row)
                                                @php
                                                    if ($data->{$row->field . '_browse'}) {
                                                        $data->{$row->field} = $data->{$row->field . '_browse'};
                                                    }
                                                @endphp
                                                <td>
                                                    <div class="voyager-entry-clamp">
                                                    @if (isset($row->details->view_browse))
                                                        @include($row->details->view_browse, [
                                                            'row' => $row,
                                                            'dataType' => $dataType,
                                                            'dataTypeContent' => $dataTypeContent,
                                                            'content' => $data->{$row->field},
                                                            'view' => 'browse',
                                                            'options' => $row->details,
                                                        ])
                                                    @elseif (isset($row->details->view))
                                                        @include($row->details->view, [
                                                            'row' => $row,
                                                            'dataType' => $dataType,
                                                            'dataTypeContent' => $dataTypeContent,
                                                            'content' => $data->{$row->field},
                                                            'action' => 'browse',
                                                            'view' => 'browse',
                                                            'options' => $row->details,
                                                        ])
                                                    @elseif($row->type == 'image')
                                                        <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)) {{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }} @endif"
                                                            style="width:100px">
                                                    @elseif($row->type == 'relationship')
                                                        @include('voyager::formfields.relationship', [
                                                            'view' => 'browse',
                                                            'options' => $row->details,
                                                        ])
                                                    @elseif($row->type == 'select_multiple')
                                                        @if (property_exists($row->details, 'relationship'))
                                                            @foreach ($data->{$row->field} as $item)
                                                                {{ $item->{$row->field} }}
                                                            @endforeach
                                                        @elseif(property_exists($row->details, 'options'))
                                                            @if (!empty(json_decode($data->{$row->field})))
                                                                @foreach (json_decode($data->{$row->field}) as $item)
                                                                    @if (@$row->details->options->{$item})
                                                                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                {{ __('voyager::generic.none') }}
                                                            @endif
                                                        @endif
                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                        @if (@count(json_decode($data->{$row->field}, true)) > 0)
                                                            @foreach (json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif
                                                    @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))
                                                        {!! $row->details->options->{$data->{$row->field}} ?? '' !!}
                                                    @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                        @if (property_exists($row->details, 'format') && !is_null($data->{$row->field}))
                                                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @elseif($row->type == 'checkbox')
                                                        @if (property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                            @if ($data->{$row->field})
                                                                <span
                                                                    class="label label-info">{{ $row->details->on }}</span>
                                                            @else
                                                                <span
                                                                    class="label label-primary">{{ $row->details->off }}</span>
                                                            @endif
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @elseif($row->type == 'color')
                                                        <span class="badge badge-lg"
                                                            style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                    @elseif($row->type == 'text')
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <div>
                                                            {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                        </div>
                                                    @elseif($row->type == 'text_area')
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <div>
                                                            {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                        </div>
                                                    @elseif($row->type == 'file' && !empty($data->{$row->field}))
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        @php 
                                                            $decodedFile = json_decode($data->{$row->field});
                                                            if (json_last_error() !== JSON_ERROR_NONE) {
                                                                $decodedFile = [$data->{$row->field}];  
                                                            } elseif (!is_array($decodedFile)) {
                                                                $decodedFile = [$decodedFile]; 
                                                            }
                                                        @endphp

                                                        @if ($decodedFile !== null)
                                                            @foreach ($decodedFile as $file)
                                                                @php
                                                                    $downloadLink = is_object($file) ? ($file->download_link ?? '') : $file;
                                                                    $originalName = is_object($file) ? ($file->original_name ?? basename($downloadLink)) : basename($file);
                                                                @endphp
                                                                
                                                                @if(!empty($downloadLink))
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($downloadLink) }}"
                                                                        target="_blank">
                                                                        {{ $originalName ?: __('voyager::generic.download') }}
                                                                    </a>
                                                                    <br />
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}"
                                                                target="_blank">
                                                                {{ __('voyager::generic.download') }}
                                                            </a>
                                                        @endif
                                                    @elseif($row->type == 'rich_text_box')
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <div>
                                                            {{ mb_strlen(strip_tags($data->{$row->field}, '<b><i><u>')) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}
                                                        </div>
                                                    @elseif($row->type == 'coordinates')
                                                        @include('voyager::partials.coordinates-static-image')
                                                    @elseif($row->type == 'multiple_images')
                                                        @php $images = json_decode($data->{$row->field}); @endphp
                                                        @if ($images)
                                                            @php $images = array_slice($images, 0, 3); @endphp
                                                            @foreach ($images as $image)
                                                                <img src="@if (!filter_var($image, FILTER_VALIDATE_URL)) {{ Voyager::image($image) }}@else{{ $image }} @endif"
                                                                    style="width:50px">
                                                            @endforeach
                                                        @endif
                                                    @elseif($row->type == 'media_picker')
                                                        @php
                                                            if (is_array($data->{$row->field})) {
                                                                $files = $data->{$row->field};
                                                            } else {
                                                                $files = json_decode($data->{$row->field});
                                                            }
                                                        @endphp
                                                        @if ($files)
                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                    <img src="@if (!filter_var($file, FILTER_VALIDATE_URL)) {{ Voyager::image($file) }}@else{{ $file }} @endif"
                                                                        style="width:50px">
                                                                @endforeach
                                                            @else
                                                                <ul>
                                                                    @foreach (array_slice($files, 0, 3) as $file)
                                                                        <li>{{ $file }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                            @if (count($files) > 3)
                                                                {{ __('voyager::media.files_more', ['count' => count($files) - 3]) }}
                                                            @endif
                                                        @elseif (is_array($files) && count($files) == 0)
                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                        @elseif ($data->{$row->field} != '')
                                                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)) {{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }} @endif"
                                                                    style="width:50px">
                                                            @else
                                                                {{ $data->{$row->field} }}
                                                            @endif
                                                        @else
                                                            {{ trans_choice('voyager::media.files', 0) }}
                                                        @endif
                                                    @else
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                            <td class="no-sort no-click bread-actions">
                                                @foreach ($actions as $action)
                                                    @if (!method_exists($action, 'massAction'))
                                                        @include('voyager::bread.partials.actions', [
                                                            'action' => $action,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">
                                    {{ trans_choice('voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total(),
                                    ]) }}
                                </div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                        's' => $search->value,
                                        'filter' => $search->filter,
                                        'key' => $search->key,
                                        'order_by' => $orderBy,
                                        'sort_order' => $sortOrder,
                                        'showSoftDeleted' => $showSoftDeleted,
                                    ])->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content"style="border-radius:var(--site-radius) !important; overflow: hidden;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}
                        {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                            value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="import-modal-glass" class="import-overlay">
        <div class="import-glass-card">
            <div class="import-header">
                <h3><i class="voyager-upload"></i> {{ __('admin.import') }}</h3>
                <button type="button" class="close-import">&times;</button>
            </div>

            <div class="import-tabs">
                <div class="import-tab active" data-tab="upload">{{ __('admin.upload_file') }}</div>
                <div class="import-tab" data-tab="template">{{ __('admin.download_template') }}</div>
            </div>

            <div class="import-body">
                <div class="tab-content active" id="tab-upload">
                    <div class="drop-zone" id="import-drop-zone">
                        <i class="voyager-upload"></i>
                        <p>{{ __('admin.drag_drop_file') }}</p>
                        <span class="file-info hidden"></span>
                    </div>
                    <input type="file" id="import-file-input" name="file" accept=".csv,.json,.zip,.txt"
                        style="display: none;">

                    <div class="form-group text-right" style="margin-bottom: 0px !important; padding: 0px !important;">
                        <button type="button" class="btn btn-primary" id="btn-start-import">
                            {{ __('admin.start_import') }}
                        </button>
                    </div>
                </div>

                <div class="tab-content" id="tab-template">
                    <p class="text-muted" style="margin-bottom: 20px;">{{ __('admin.template_desc') }}</p>

                    <div class="import-options" style="padding: 0px !important;">
                        <label class="toggle-switch">
                            <input type="checkbox" id="include-media-template">
                            <span class="slider"></span>
                            <span class="label-text">{{ __('admin.media_and_visuals') }} (ZIP)</span>
                        </label>
                    </div>

                    <div class="template-grid" style="padding: 0px !important;">
                        <a href="{{ route('voyager.import_template', ['slug' => $dataType->slug, 'format' => 'csv']) }}"
                            class="template-card">
                            <i class="voyager-file-text"></i>
                            <span>CSV</span>
                        </a>
                        <a href="{{ route('voyager.import_template', ['slug' => $dataType->slug, 'format' => 'json']) }}"
                            class="template-card">
                            <i class="voyager-code"></i>
                            <span>JSON</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .import-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99990;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .import-overlay.active {
            display: flex !important;
            animation: fadeIn 0.2s ease-out;
        }

        .import-glass-card {
            background: rgba(255, 255, 255, 0.95);
            width: 500px;
            max-width: 90%;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .import-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .import-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .close-import {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .import-tabs {
            display: flex;
            background: #f8f9fa;
        }

        .import-tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            font-weight: 500;
            color: #666;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .import-tab.active {
            background: #fff;
            color: var(--primary-custom, #22a7f0);
            border-bottom-color: var(--primary-custom, #22a7f0);
        }

        .import-body {
            padding: 25px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .drop-zone {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 20px;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: var(--primary-custom, #22a7f0);
            background: rgba(34, 167, 240, 0.05);
        }

        .drop-zone i {
            font-size: 48px;
            color: #ccc;
            margin: 0;
            display: block;
        }

        .drop-zone p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .file-info {
            display: block;
            margin-top: 10px;
            font-weight: 600;
            color: #333;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .template-card {
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
        }

        .template-card:hover {
            border-color: var(--primary-custom, #22a7f0);
            color: var(--primary-custom, #22a7f0);
            background: #fdfdfd;
            text-decoration: none;
        }

        .template-card i {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .toggle-switch {
            display: flex;
            align-items: center;
            cursor: pointer;
            width: fit-content;
            margin-bottom: 20px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-switch .slider {
            width: 40px;
            height: 22px;
            background: #ccc;
            border-radius: 22px;
            position: relative;
            margin-right: 10px;
            transition: 0.3s;
        }

        .toggle-switch .slider:before {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            top: 2px;
            left: 2px;
            transition: 0.3s;
        }

        .toggle-switch input:checked+.slider {
            background: var(--primary-custom, #22a7f0);
        }

        .toggle-switch input:checked+.slider:before {
            transform: translateX(18px);
        }

        .label-text {
            font-size: 13px;
            color: #666;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var importBtn = document.getElementById('btn-import-unified');
            var importModal = document.getElementById('import-modal-glass');
            var closeBtn = document.querySelector('.close-import');
            var dropZone = document.getElementById('import-drop-zone');
            var fileInput = document.getElementById('import-file-input');
            var startBtn = document.getElementById('btn-start-import');

            if (!importBtn) return;

            // Modal Logic
            importBtn.addEventListener('click', function() {
                importModal.classList.add('active');
            });

            closeBtn.addEventListener('click', function() {
                importModal.classList.remove('active');
            });

            importModal.addEventListener('click', function(e) {
                if (e.target === importModal) importModal.classList.remove('active');
            });

            // Tabs Logic
            document.querySelectorAll('.import-tab').forEach(t => {
                t.addEventListener('click', function() {
                    document.querySelectorAll('.import-tab').forEach(x => x.classList.remove(
                        'active'));
                    document.querySelectorAll('.tab-content').forEach(x => x.classList.remove(
                        'active'));
                    this.classList.add('active');
                    document.getElementById('tab-' + this.dataset.tab).classList.add('active');
                });
            });

            // File Handling
            dropZone.addEventListener('click', () => fileInput.click());

            function handleFile(file) {
                document.querySelector('.file-info').textContent = file.name;
                document.querySelector('.file-info').classList.remove('hidden');
                dropZone.querySelector('p').classList.add('hidden');
                dropZone.querySelector('i').classList.remove('voyager-cloud-upload');
                dropZone.querySelector('i').classList.add('voyager-check');
                dropZone.querySelector('i').style.color = '#2ecc71';
            }

            fileInput.addEventListener('change', function() {
                if (this.files.length) handleFile(this.files[0]);
            });

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
            });

            dropZone.addEventListener('drop', function(e) {
                var dt = e.dataTransfer;
                var files = dt.files;
                if (files.length) {
                    fileInput.files = files;
                    handleFile(files[0]);
                }
            });

            // Start Import
            startBtn.addEventListener('click', function() {
                if (!fileInput.files.length) {
                    toastr.warning("{{ __('admin.please_select_file') }}");
                    return;
                }

                var formData = new FormData();
                formData.append('file', fileInput.files[0]);

                startBtn.disabled = true;
                startBtn.innerHTML =
                    '<i class="voyager-refresh voy-spin"></i> {{ __('admin.processing') }}...';

                fetch('{{ route('voyager.import', $dataType->slug) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(res => {
                        startBtn.disabled = false;
                        startBtn.textContent = '{{ __('admin.start_import') }}';

                        if (res.status === 200) {
                            toastr.success(res.body.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            toastr.error(res.body.message || "Hata oluştu.");
                        }
                    })
                    .catch(err => {
                        startBtn.disabled = false;
                        startBtn.textContent = '{{ __('admin.start_import') }}';
                        toastr.error("Sunucu hatası.");
                        console.error(err);
                    });
            });

            // Template Include Media Toggle Logic
            document.querySelectorAll('.template-card').forEach(function(card) {
                card.addEventListener('click', function(e) {
                    var toggle = document.getElementById('include-media-template');
                    if (toggle && toggle.checked) {
                        e.preventDefault();
                        var href = this.getAttribute('href');
                        var url = new URL(href, window.location.origin);
                        url.searchParams.set('include_media', '1');
                        window.location.href = url.toString();
                    }
                });
            });
        });
    </script>
    <div id="export-loading-overlay" class="export-overlay">
        <div class="export-modal">
            <div class="export-spinner"></div>
            <h3 class="export-title">{{ __('admin.exporting') }}</h3>
            <p class="export-desc">{{ __('admin.export_wait_message') }}</p>
        </div>
    </div>

    <style>
        .export-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .export-overlay.active {
            display: flex !important;
            animation: fadeIn 0.2s ease-out forwards;
        }

        .export-modal {
            background: #fff;
            padding: 30px;
            border-radius: var(--site-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            min-width: 300px;
            max-width: 90%;
        }

        .export-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--primary-custom);
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .export-title {
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .export-desc {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@stop

@section('css')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge(
                        [
                            'order' => $orderColumn,
                            'language' => __('voyager::datatable'),
                            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
                        ],
                        config('voyager.dashboard.data_tables', []),
                    ),
                    true,
                ) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                $('#dataTable').on('draw.dt', function() {
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = '{{ route('voyager.' . $dataType->slug . '.destroy', '__id') }}'
                .replace(
                    '__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if ($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}"></a>'
                        );
                    } else {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}"></a>'
                        );
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function() {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);

            var selectedCount = ids.length;
            $('#selected-count').text(selectedCount);

            if (selectedCount > 0) {
                $('#selected-export-group').show();
            } else {
                $('#selected-export-group').hide();
            }
        });

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        function monitorDownload(token) {
            var downloadTimer = window.setInterval(function() {
                var cookieValue = getCookie('download_token');
                if (cookieValue == token) {
                    window.clearInterval(downloadTimer);
                    $('#export-loading-overlay').removeClass('active');
                    document.cookie = "download_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                }
            }, 1000);
        }

        function showExportLoading() {
            var overlay = $('#export-loading-overlay');
            overlay.addClass('active');
        }

        $(document).on('click', '.export-link-unified', function(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.closest('.selected-item').hasClass('disabled')) return;

            var type = $btn.data('type');
            var format = $btn.data('format');
            var lang = $btn.data('lang') || '';
            var includeMedia = $('#include-media-toggle-unified').is(':checked');
            var token = new Date().getTime();

            var ids = [];
            if (type === 'selected') {
                $('input[name="row_id"]:checked').each(function() {
                    ids.push($(this).val());
                });
                if (ids.length === 0) {
                    toastr.warning('{{ __('voyager::generic.please_select') }}');
                    return;
                }
            }

            showExportLoading();
            monitorDownload(token);

            var baseUrl = '{{ route('voyager.export', [$dataType->slug, 'FORMAT']) }}';
            var url = baseUrl.replace('FORMAT', format);

            var params = [];
            if (ids.length > 0) params.push('ids=' + ids.join(','));
            if (format === 'pdf' && lang) params.push('lang=' + lang);
            if (includeMedia) params.push('include_media=1');
            params.push('download_token=' + token);

            url += '?' + params.join('&');

            if (format === 'pdf' && !includeMedia) {
                window.open(url, '_blank');
            } else {
                window.location.href = url;
            }
        });

        $('input[name="row_id"], input[name="select_all"]').on('change', function() {
            var count = $('input[name="row_id"]:checked').length;
            $('#selected-count-unified').text(count);

            if (count > 0) {
                $('.selected-item').removeClass('disabled');
            } else {
                $('.selected-item').addClass('disabled');
            }
        });

        $('#include-media-toggle-unified').on('click', function(e) {
            e.stopPropagation();
        });
    </script>

    <style>
        .export-menu-glass {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05) !important;
            border-radius: 12px !important;
            padding: 10px 0;
            min-width: 240px;
            animation: slideDownFade 0.2s ease-out;
            z-index: 700;
        }

        @keyframes slideDownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .export-menu-glass .dropdown-header {
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 11px;
            padding: 8px 20px;
        }

        .export-menu-glass li>a {
            padding: 8px 20px;
            color: #333;
            transition: all 0.3s ease;
        }

        .export-menu-glass li>a:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #000;
        }

        .export-menu-glass .divider {
            background-color: rgba(0, 0, 0, 0.05);
            margin: 8px 0;
        }

        .selected-item.disabled {
            opacity: 0.5;
            pointer-events: none;
            filter: grayscale(1);
        }
    </style>
@stop
