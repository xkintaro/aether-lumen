<div class="custom-image-wrapper" data-upload-type="multiple_images">
    @php
        $imageVal = isset($dataTypeContent->{$row->field}) ? $dataTypeContent->{$row->field} : null;
        $images = $imageVal ? json_decode($imageVal, true) : [];
        $isEmpty = empty($images);
    @endphp

    <div class="unified-preview-container sortable-container" data-field-name="{{ $row->field }}"
        @if ($isEmpty) style="display:none;" @endif>
        @if (!$isEmpty)
            @foreach ($images as $image)
                <div class="custom-preview-container existing-preview sortable-item" data-field-name="{{ $row->field }}">
                    <a href="#" class="voyager-x remove-multi-image close-circle-btn"
                        title="{{ __('admin.remove_image') }}"></a>
                    <img draggable="false" src="{{ Voyager::image($image) }}" data-file-name="{{ $image }}"
                        data-id="{{ $dataTypeContent->getKey() }}" class="custom-preview-img">
                </div>
            @endforeach
        @endif
    </div>

    <div class="custom-file-input-group">
        <div class="custom-upload-design">
            <i class="voyager-images"></i>
            <span class="custom-file-title">{{ __('admin.select_images_multi') }}</span>
            <span class="custom-file-text">{{ __('admin.no_image_selected') }}</span>
        </div>

        <input @if ($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file"
            name="{{ $row->field }}[]" multiple="multiple" accept="image/*" class="custom-real-input"
            data-preview-target="{{ $row->field }}" data-empty-text="{{ __('admin.no_image_selected') }}">
    </div>

</div>