@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());

    $tabConfiguration = [
        'general' => [
            'title'  => __('admin.general_informations'),
            'icon'   => 'voyager-info-circled',
            'fields' => [
                'title', 'subtitle', 'name', 'slug', 'status', 
                'category_id', 'parent_id', 'order', 
                'received_at', '', 'date', 'email', 'phone', 
                'subject', 'name', 'surname', 'ip_address', 
                'old_url' , 'new_url'
            ]
        ],
        'details' => [
            'title'  => __('admin.details_and_price'),
            'icon'   => 'voyager-list',
            'fields' => [
                'price', 'old_price', 'sku', 'product_code', 'oem_no', 'barcode', 'stock_count',
                'url', 'link', 'action_text', 'action_link', 'username', 
                'value', 'percentage', 'rating', 'company', 'organization', 'completion_date',
                'client', 'location',  'question', 'answer'
            ]
        ],
        'content' => [
            'title'  => __('admin.content_management'),
            'icon'   => 'voyager-file-text',
            'fields' => ['excerpt', 'description', 'content', 'table_html', 'body', 'comment', 'message']
        ],
        'media' => [
            'title'  => __('admin.media_and_visuals'),
            'icon'   => 'voyager-photos',
            'fields' => [
                'image', 'images', 'image_url', 'image_gallery', 
                'video', 'video_url', 'video_gallery', 'embed_code', 
                'banner', 'banner_url', 'icon', 
                'bg_image', 'bg_image_url', 'mascot_image', 'mascot_image_url', 
                'bg_video', 'bg_video_url', 'file', 'file_url'
            ]
        ],
        'seo' => [
            'title'  => __('admin.seo_settings'),
            'icon'   => 'voyager-search',
            'fields' => ['meta_title', 'meta_description', 'seo_text', 'keywords']
        ]
    ];

    $definedFields = collect($tabConfiguration)->pluck('fields')->flatten()->toArray();
    $allBreadFields = $dataType->{($edit ? 'editRows' : 'addRows')}->pluck('field')->toArray();
    $missingFields = array_diff($allBreadFields, $definedFields);

    if (!empty($missingFields)) {
        $tabConfiguration['other'] = [
            'title'  => __('admin.other_settings'),
            'icon'   => 'voyager-settings',
            'fields' => $missingFields
        ];
    }
@endphp

@extends('voyager::master')

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))


@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <style>
        .page-content.edit-add { padding: 0; background-color: #f9f9f9; min-height: 100vh; }
        .row { margin: 0; }
        .col-md-12 { padding: 0; }

        .custom-header {
            padding: 25px 40px;
            border-bottom: 1px solid #e1e1e1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .custom-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .custom-header h1 i { color: var(--primary-custom); font-size: 32px; }
        
        .nav-tabs-custom {
            background: #fff;
            padding: 0 40px;
            border-bottom: 1px solid #e1e1e1;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .nav-tabs-custom > li {
            margin-bottom: -1px;
            margin-right: 20px;
        }
        .nav-tabs-custom > li > a {
            border: none;
            border-bottom: 3px solid transparent;
            color: #777;
            font-weight: 700;
            padding: 20px 5px;
            font-size: 13px;
            text-transform: uppercase;
            background: transparent !important;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-tabs-custom > li > a:hover {
            color: var(--primary-custom);
            background: transparent !important;
        }
        .nav-tabs-custom > li.active > a {
            color: var(--primary-custom) !important;
            border-bottom: 3px solid var(--primary-custom) !important;
            background: transparent !important;
        }
        .nav-tabs-custom > li.has-error > a {
            color: #d9534f !important;
            border-bottom-color: #d9534f !important;
        }

        .tab-content-custom {
            padding: 0 40px 100px 40px; 
        }

        @media (max-width: 768px) {
         
              .tab-content-custom {
            padding: 0 0 100px 0 !important; 
        }

        }
        .content-card {
            background: #fff;
            border-radius: 30px; 
            border: 1px solid #e5e5e5;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }

          @media (min-width: 1200px) {
         
             
        .tab-pane>.content-card {
            max-width: 960px ;
        
        }
    }

        .form-group {
            margin-bottom: 30px;
        }

        .control-label {
            font-weight: 700;
            color: #444;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            gap: 2px;
        }
        
        .form-control {
            border-radius: 12px !important;
            border: 1px solid #ddd;
            padding: 12px 15px;
            height: auto;
            box-shadow: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary-custom) !important;
        }

        .select2-container .select2-selection--single {
            height: 45px !important;
            border-radius: 12px !important;
            border: 1px solid #ddd !important;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
        }

        .sticky-actions {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 0; 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid #e1e1e1;
            padding: 10px 40px;
            z-index: 999;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        }

        .tab-pane { 
            display: block !important; 
            height: 0 !important;     
            overflow: hidden !important; 
            opacity: 0 !important;
            padding: 0 !important;
            visibility: hidden !important; 
        }

        .tab-pane.active { 
            height: auto !important;  
            opacity: 1 !important;
            overflow: visible !important;
            visibility: visible !important;
        }

        .field-relation-group {
            border-left: 4px solid var(--primary-custom);
            border-radius: 16px;
            padding: 30px 20px 5px 20px;
            margin-bottom: 30px;
            position: relative;
            width: 100%;
            float: left;
        }
        .field-relation-group::before {
            content: '\01F517  Benzer Alanlar — URL önceliklidir';
            position: absolute;
            top: -12px;
            left: 16px;
            background: #fff;
            padding: 2px 14px;
            font-size: 10px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            white-space: nowrap;
        }
        .field-relation-group .form-group {
            margin-bottom: 25px;
        }

        .voyager-x {
    display: flex;
    align-items: center;
    justify-content: center;
}

        .layout-toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-right: 25px;
            background: #f0f0f0;
            padding: 6px 14px;
            border-radius: 50px;
            border: 1px solid #e5e5e5;
        }
        
  @media (max-width: 1200px) {
         
           .layout-toggle-wrapper {
            display: none !important;
                  }
        }
        
        .switch-premium {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 20px;
            margin-bottom: 0;
        }

        .switch-premium input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider-premium {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 34px;
        }

        .slider-premium:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        input:checked + .slider-premium {
            background-color: var(--primary-custom);
        }

        input:checked + .slider-premium:before {
            transform: translateX(18px);
        }

        .page-content.full-width-mode .tab-pane > .content-card {
            max-width: 100% !important;
            transition: max-width 0.3s ease-in-out;
        }

        .tab-pane > .content-card {
            transition: max-width 0.3s ease-in-out;
        }
    </style>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        
        <form role="form"
                class="form-edit-add"
                action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                method="POST" enctype="multipart/form-data">
            
            @if($edit) {{ method_field("PUT") }} @endif
            {{ csrf_field() }}

            <div class="custom-header">
                <h1>
                    <i class="{{ $dataType->icon }}"></i>
                    <div>
                        {{ mb_strtoupper($dataType->getTranslatedAttribute('display_name_singular')) }} 
                        <span style="font-weight: 400; font-size: 14px; color: #999; display: block; text-transform: none; margin-top: 5px;">
                            {{ $edit ? __('admin.editing_record') : __('admin.creating_new') }}
                        </span>
                    </div>
                </h1>
                <div style="display: flex; align-items: center;">
                    <div class="layout-toggle-wrapper">
                        <span style="font-size: 11px; font-weight: 700; color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Tam Genişlik</span>
                        <label class="switch-premium">
                            <input type="checkbox" id="layout-width-toggle">
                            <span class="slider-premium"></span>
                        </label>
                    </div>
                    <div class="lang-selector-wrapper">
                        @include('voyager::multilingual.language-selector')
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                @php $activeTabSet = false; @endphp
                @foreach($tabConfiguration as $key => $tab)
                    @php
                        $hasFields = false;
                        $breadRows = $dataType->{($edit ? 'editRows' : 'addRows')};
                        $rowsInTab = $breadRows->filter(fn($r) => in_array($r->field, $tab['fields']));
                        if($rowsInTab->isNotEmpty()) $hasFields = true;
                        $hasError = false;
                        foreach($tab['fields'] as $f) {
                            if($errors->has($f)) { $hasError = true; break; }
                        }
                        $isActive = false;
                        if ($hasFields && !$activeTabSet) {
                            $isActive = true;
                            $activeTabSet = true;
                        }
                    @endphp

                    @if($hasFields)
                        <li role="presentation" class="{{ $isActive ? 'active' : '' }} {{ $hasError ? 'has-error' : '' }}">
                            <a href="#tab-{{ $key }}" aria-controls="tab-{{ $key }}" role="tab" data-toggle="tab">
                                <i class="{{ $tab['icon'] }}"></i> 
                                {{ $tab['title'] }}
                                @if($hasError) <i class="voyager-warning" style="margin-left:5px; font-size:12px;"></i> @endif
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="tab-content tab-content-custom">
                
                @if (count($errors) > 0)
                    <div class="alert alert-danger" style="border-radius: 12px; margin-bottom: 30px;">
                        <ul style="margin:0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php 
                    $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )}; 
                    $activeContentSet = false;
                @endphp

                @foreach($tabConfiguration as $key => $tab)
                    @php
                        $groupRows = $dataTypeRows->filter(fn($row) => in_array($row->field, $tab['fields']));
                        if($groupRows->isEmpty()) continue;
                        $isActive = false;
                        if (!$activeContentSet) {
                            $isActive = true;
                            $activeContentSet = true;
                        }
                    @endphp

                    <div role="tabpanel" class="tab-pane {{ $isActive ? 'active' : '' }}" id="tab-{{ $key }}">
                        <div class="content-card">
                            <div class="row">
                                @php
                                    $allFieldNames = $groupRows->pluck('field')->toArray();
                                    
                                     $pairs = [];
                                    $pairedFields = [];
                                    foreach ($allFieldNames as $fieldName) {
                                        if (substr($fieldName, -4) === '_url') {
                                            $baseField = substr($fieldName, 0, -4);
                                            if (in_array($baseField, $allFieldNames)) {
                                                $pairs[$baseField] = $fieldName;
                                                $pairedFields[] = $baseField;
                                                $pairedFields[] = $fieldName;
                                            }
                                        }
                                    }
                                @endphp

                                @foreach($groupRows as $row)
                                    @php
                                        if (in_array($row->field, $pairedFields) && substr($row->field, -4) === '_url') continue;

                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                    @endphp

                                    @if(isset($pairs[$row->field]))
                                        @php
                                            $urlFieldName = $pairs[$row->field];
                                            $urlRow = $groupRows->first(fn($r) => $r->field === $urlFieldName);
                                        @endphp
                                        <div class="field-relation-group">
                                            @include('vendor.voyager.bread.partials.form-field-item', ['row' => $row, 'display_options' => $display_options])
                                            
                                            @if($urlRow)
                                                @php
                                                    $urlDisplayOptions = $urlRow->details->display ?? NULL;
                                                    if ($dataTypeContent->{$urlRow->field.'_'.($edit ? 'edit' : 'add')}) {
                                                        $dataTypeContent->{$urlRow->field} = $dataTypeContent->{$urlRow->field.'_'.($edit ? 'edit' : 'add')};
                                                    }
                                                @endphp
                                                @include('vendor.voyager.bread.partials.form-field-item', ['row' => $urlRow, 'display_options' => $urlDisplayOptions])
                                            @endif
                                        </div>
                                    @else
                                     @include('vendor.voyager.bread.partials.form-field-item', ['row' => $row, 'display_options' => $display_options])
                                    @endif
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sticky-actions">
                <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-danger">
                    {{ __('voyager::generic.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="voyager-check"></i> {{ __('voyager::generic.save') }}
                </button>
            </div>

        </form>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; overflow:hidden;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);
            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }
            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            var toggle = $('#layout-width-toggle');
            var pageContent = $('.page-content.edit-add');
            var isFullWidth = localStorage.getItem('bread-full-width') === 'true';

            if (isFullWidth) {
                toggle.prop('checked', true);
                pageContent.addClass('full-width-mode');
            }

            toggle.on('change', function() {
                if (this.checked) {
                    pageContent.addClass('full-width-mode');
                    localStorage.setItem('bread-full-width', 'true');
                } else {
                    pageContent.removeClass('full-width-mode');
                    localStorage.setItem('bread-full-width', 'false');
                }
            });

            $('.toggleswitch').bootstrapToggle();

            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response && response.data && response.data.status && response.data.status == 200 ) {
                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });
                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();

             $('img').attr('draggable', 'false');

            function getFileIconClass(fileName) {
                var ext = fileName.split('.').pop().toLowerCase();
                if (['pdf'].includes(ext)) return 'icon-pdf';
                if (['doc', 'docx', 'odt', 'rtf'].includes(ext)) return 'icon-doc';
                if (['xls', 'xlsx', 'csv', 'ods'].includes(ext)) return 'icon-xls';
                if (['zip', 'rar', '7z', 'tar', 'gz'].includes(ext)) return 'icon-zip';
                return 'icon-default';
            }

            function getFileIconName(fileName) {
                var ext = fileName.split('.').pop().toLowerCase();
                if (['pdf'].includes(ext)) return 'voyager-file-text';
                if (['doc', 'docx', 'odt', 'rtf'].includes(ext)) return 'voyager-file-text';
                if (['xls', 'xlsx', 'csv', 'ods'].includes(ext)) return 'voyager-file-text';
                if (['zip', 'rar', '7z', 'tar', 'gz'].includes(ext)) return 'voyager-archive';
                return 'voyager-file-text';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 B';
                var k = 1024;
                var sizes = ['B', 'KB', 'MB', 'GB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            }

            function isImageFile(file) {
                return file.type && file.type.startsWith('image/');
            }

            function createImagePreviewCard(file, index) {
                var card = $('<div class="custom-instant-preview-card" style="animation-delay:' + (index * 0.08) + 's"></div>');
                var removeBtn = $('<span class="preview-remove-btn close-circle-btn"><i class="voyager-x"></i></span>');
                var img = $('<img draggable="false">');

                var reader = new FileReader();
                reader.onload = function(e) {
                    img.attr('src', e.target.result);
                };
                reader.readAsDataURL(file);

                card.append(removeBtn).append(img);
                return card;
            }

            function createFilePreviewCard(file, index) {
                var iconClass = getFileIconClass(file.name);
                var iconName = getFileIconName(file.name);
                
                var card = $('<div class="custom-instant-preview-card" style="animation-delay:' + (index * 0.08) + 's"></div>');
                var removeBtn = $('<span class="preview-remove-btn close-circle-btn"><i class="voyager-x"></i></span>');
                var fileInfo = $(
                    '<div class="preview-file-info">' +
                        '<div class="preview-file-icon ' + iconClass + '"><i class="' + iconName + '"></i></div>' +
                        '<div class="preview-file-details">' +
                            '<span class="preview-file-name" title="' + file.name + '">' + file.name + '</span>' +
                            '<span class="preview-file-size">' + formatFileSize(file.size) + '</span>' +
                        '</div>' +
                    '</div>'
                );

                card.append(removeBtn).append(fileInfo);
                return card;
            }

            function createReplaceCompare(file, existingImgSrc) {
                var compare = $('<div class="image-replace-compare"></div>');

                var oldDiv = $('<div class="compare-old-image"></div>');
                var oldImg = $('<img draggable="false">').attr('src', existingImgSrc);
                var oldLabel = $('<span class="compare-label">Mevcut</span>');
                oldDiv.append(oldImg).append(oldLabel);

                var arrowDiv = $(
                    '<div class="compare-arrow">' +
                        '<div class="compare-arrow-icon"><i class="voyager-angle-right"></i></div>' +
                        '<span class="compare-arrow-text">Değişecek</span>' +
                    '</div>'
                );

                var newDiv = $('<div class="compare-new-image" style="position:relative;"></div>');
                var newImg = $('<img draggable="false">');
                var newLabel = $('<span class="compare-label">Yeni</span>');
                var removeBtn = $('<span class="compare-remove-btn close-circle-btn"><i class="voyager-x"></i></span>');
                
                var reader = new FileReader();
                reader.onload = function(e) {
                    newImg.attr('src', e.target.result);
                };
                reader.readAsDataURL(file);

                newDiv.append(removeBtn).append(newImg).append(newLabel);
                compare.append(oldDiv).append(arrowDiv).append(newDiv);
                return compare;
            }

            function showInstantPreview(input) {
                var $input = $(input);
                var fieldName = $input.data('preview-target');
                var emptyText = $input.data('empty-text');
                var $wrapper = $input.closest('.custom-image-wrapper');
                var uploadType = $wrapper.data('upload-type');
                var $inputGroup = $input.closest('.custom-file-input-group');
                var $textSpan = $inputGroup.find('.custom-file-text');

                if (uploadType === 'image') {
                    var $previewArea = $wrapper.find('.custom-instant-preview[data-preview-for="' + fieldName + '"]');
                    var $grid = $previewArea.find('.custom-instant-preview-grid');
                    var $existingPreview = $wrapper.find('.existing-preview');
                    $grid.empty();

                    if (!input.files || input.files.length === 0) {
                        $previewArea.hide();
                        $inputGroup.removeClass('has-preview');
                        $textSpan.text(emptyText || 'Dosya seçilmedi');
                        $existingPreview.show();
                        return;
                    }

                    $textSpan.text(input.files[0].name);
                    var file = input.files[0];

                    if ($existingPreview.length > 0) {
                        var existingSrc = $existingPreview.find('.custom-preview-img').attr('src');
                        if (existingSrc && isImageFile(file)) {
                            $existingPreview.hide();
                            var compareEl = createReplaceCompare(file, existingSrc);
                            $grid.append(compareEl);
                            $previewArea.show();
                            $inputGroup.addClass('has-preview');

                            compareEl.find('.compare-remove-btn').on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                compareEl.fadeOut(200, function() {
                                    $(this).remove();
                                    $previewArea.hide();
                                    $inputGroup.removeClass('has-preview');
                                    $input.val('');
                                    $textSpan.text(emptyText || 'Dosya seçilmedi');
                                    $existingPreview.show();
                                });
                            });
                            return;
                        }
                    }

                    var card;
                    if (isImageFile(file)) {
                        card = createImagePreviewCard(file, 0);
                    } else {
                        card = createFilePreviewCard(file, 0);
                    }
                    $grid.append(card);
                    $previewArea.show();
                    $inputGroup.addClass('has-preview');
                    $existingPreview.hide();

                    $grid.find('.preview-remove-btn').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).closest('.custom-instant-preview-card').fadeOut(200, function() {
                            $(this).remove();
                            $previewArea.hide();
                            $inputGroup.removeClass('has-preview');
                            $input.val('');
                            $textSpan.text(emptyText || 'Dosya seçilmedi');
                            $existingPreview.show();
                        });
                    });
                    return;
                }

                var $unified = $wrapper.find('.unified-preview-container');
                $unified.find('.new-preview-card').remove();

                if (!input.files || input.files.length === 0) {
                    $inputGroup.removeClass('has-preview');
                    $textSpan.text(emptyText || 'Dosya seçilmedi');
                    toggleUnified($unified);
                    refreshSortable($unified[0]);
                    return;
                }

                var files = input.files;
                $textSpan.text(files.length > 1 ? files.length + ' dosya seçildi' : files[0].name);

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var card;

                    if (uploadType === 'file' && !isImageFile(file)) {
                        card = createFilePreviewCard(file, i);
                    } else {
                        card = createImagePreviewCard(file, i);
                    }

                    card.addClass('new-preview-card sortable-item');
                    card.attr('data-field-name', fieldName);
                    card[0]._fileRef = file;
                    card.append('<span class="new-preview-badge">Yeni</span>');
                    $unified.append(card);
                }

                $inputGroup.addClass('has-preview');
                toggleUnified($unified);
                refreshSortable($unified[0]);
                updateSortOrder($unified[0]);
                bindNewCardRemove($unified, $input, $inputGroup, emptyText);
            }

            function bindNewCardRemove($unified, $input, $inputGroup, emptyText) {
                $unified.find('.new-preview-card .preview-remove-btn').off('click.newcard').on('click.newcard', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $card = $(this).closest('.new-preview-card');
                    $card.fadeOut(200, function() {
                        $(this).remove();
                        rebuildFileInput($input[0], $unified[0]);
                        toggleUnified($unified);
                        updateSortOrder($unified[0]);
                        refreshSortable($unified[0]);

                        var remaining = $unified.find('.new-preview-card').length;
                        var $textSpan = $inputGroup.find('.custom-file-text');
                        if (remaining === 0) {
                            $inputGroup.removeClass('has-preview');
                            $textSpan.text(emptyText || 'Dosya seçilmedi');
                        } else {
                            $textSpan.text(remaining > 1 ? remaining + ' dosya seçildi' : '1 dosya seçildi');
                        }
                    });
                });
            }

            function rebuildFileInput(input, container) {
                var dt = new DataTransfer();
                container.querySelectorAll('.new-preview-card').forEach(function(card) {
                    if (card._fileRef) dt.items.add(card._fileRef);
                });
                input.files = dt.files;
            }

            function toggleUnified($c) {
                $c.css('display', $c.children().length > 0 ? 'flex' : 'none');
            }

            $(document).on('change', '.custom-real-input', function() {
                showInstantPreview(this);
            });

            document.querySelectorAll('.custom-real-input').forEach(function(input) {
                var design = input.closest('.custom-file-input-group').querySelector('.custom-upload-design');
                var dragCounter = 0;

                input.addEventListener('dragenter', function() {
                    dragCounter++;
                    design.classList.add('dragover');
                });

                input.addEventListener('dragleave', function() {
                    dragCounter--;
                    if (dragCounter <= 0) {
                        dragCounter = 0;
                        design.classList.remove('dragover');
                    }
                });

                input.addEventListener('drop', function() {
                    dragCounter = 0;
                    design.classList.remove('dragover');
                });
            });

             document.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (e.dataTransfer) {
                    e.dataTransfer.dropEffect = 'copy';
                }
            }, true);

            document.addEventListener('drop', function(e) {
                var t = e.target;
                if (!(t.tagName === 'INPUT' && t.type === 'file')) {
                    e.preventDefault();
                }
            });

            var errorTab = $('.nav-tabs-custom li.has-error').first().find('a');
            if(errorTab.length > 0){
                errorTab.tab('show');
            }

            var invalidTimer = null;
            $('input, select, textarea').on('invalid', function() {
                var $el = $(this);
                if (!invalidTimer) {
                    invalidTimer = setTimeout(function() {
                        invalidTimer = null;
                    }, 100);

                    var tabPane = $el.closest('.tab-pane');
                    if (tabPane.length && !tabPane.hasClass('active')) {
                        var tabId = tabPane.attr('id');
                        $('.nav-tabs-custom a[href="#' + tabId + '"]').tab('show');
                        setTimeout(function() {
                            $el.focus();
                        }, 150);
                    } else {
                        setTimeout(function() {
                            $el.focus();
                        }, 150);
                    }
                }
            });

            function updateSortOrder(container) {
                var wrapper = container.closest('.custom-image-wrapper');
                if (!wrapper) return;

                var items = container.querySelectorAll('.sortable-item');
                var fieldName = null;
                var order = [];

                items.forEach(function(item) {
                    var fn = item.getAttribute('data-field-name');
                    if (fn) fieldName = fn;

                    if (item.classList.contains('new-preview-card')) {
                        order.push('__new__');
                    } else {
                        var img = item.querySelector('img[data-file-name]');
                        var fileLink = item.querySelector('a[data-file-name]');
                        if (img) order.push(img.getAttribute('data-file-name'));
                        else if (fileLink) order.push(fileLink.getAttribute('data-file-name'));
                    }
                });

                if (fieldName && order.length > 0) {
                    var inputName = fieldName + '_sort_order';
                    var existing = wrapper.querySelector('input[name="' + inputName + '"]');
                    if (!existing) {
                        existing = document.createElement('input');
                        existing.type = 'hidden';
                        existing.name = inputName;
                        wrapper.appendChild(existing);
                    }
                    existing.value = JSON.stringify(order);
                }
            }

            function refreshSortable(container) {
                if (!container) return;
                var items = container.querySelectorAll('.sortable-item');

                if (items.length < 2) {
                    if (container._sortableInstance) {
                        container._sortableInstance.destroy();
                        container._sortableInstance = null;
                    }
                    updateSortOrder(container);
                    return;
                }

                if (container._sortableInstance) {
                    container._sortableInstance.destroy();
                    container._sortableInstance = null;
                }

                container._sortableInstance = new Sortable(container, {
                    animation: 300,
                    easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    draggable: '.sortable-item',
                    filter: '.custom-delete-btn, .preview-remove-btn, .compare-remove-btn',
                    preventOnFilter: false,
                    forceFallback: true,
                    fallbackClass: 'sortable-fallback',
                    fallbackOnBody: true,
                    fallbackTolerance: 3,
                    delay: 80,
                    delayOnTouchOnly: true,
                    swapThreshold: 0.65,
                    onEnd: function() {
                        updateSortOrder(container);
                        var fileInput = container.closest('.custom-image-wrapper')
                            ? container.closest('.custom-image-wrapper').querySelector('input[type="file"]')
                            : null;
                        if (fileInput) {
                            rebuildFileInput(fileInput, container);
                        }
                    }
                });
            }

            document.querySelectorAll('.unified-preview-container.sortable-container').forEach(function(c) {
                refreshSortable(c);
                updateSortOrder(c);
            });
        });
    </script>
@stop