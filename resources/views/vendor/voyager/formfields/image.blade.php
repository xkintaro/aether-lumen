<div class="custom-image-wrapper" data-upload-type="image">

    @if (isset($dataTypeContent->{$row->field}))
        <div class="custom-preview-container existing-preview" data-field-name="{{ $row->field }}">
            <a href="#" class="voyager-x remove-single-image close-circle-btn" title="{{ __('admin.remove_image') }}"></a>

            <img draggable="false"
                src="@if (!filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image($dataTypeContent->{$row->field}) }}@else{{ $dataTypeContent->{$row->field} }} @endif"
                data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->getKey() }}"
                class="custom-preview-img">
        </div>
    @endif

    <div class="custom-instant-preview" data-preview-for="{{ $row->field }}" style="display:none;">
        <div class="custom-instant-preview-grid"></div>
    </div>

    <div class="custom-file-input-group">

        <div class="custom-upload-design">
            <i class="voyager-images"></i>
            <span class="custom-file-title">{{ __('admin.select_image') }}</span>
            <span class="custom-file-text">{{ __('admin.no_image_selected') }}</span>
        </div>

        <input @if ($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file"
            name="{{ $row->field }}" accept="image/*" class="custom-real-input" data-preview-target="{{ $row->field }}"
            data-empty-text="{{ __('admin.no_image_selected') }}">
    </div>

</div>