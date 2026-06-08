<div class="custom-image-wrapper" data-upload-type="file">
    @php
        $fileVal = isset($dataTypeContent->{$row->field}) ? $dataTypeContent->{$row->field} : null;
        $decoded = $fileVal ? json_decode($fileVal, true) : null;
        $isEmpty = empty($fileVal) || ($decoded !== null && empty($decoded)) || $fileVal === '[]' || $fileVal === 'null';

        $isImageExt = function($filename) {
            if (!$filename) return false;
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
        };
    @endphp

    <div class="unified-preview-container sortable-container" data-field-name="{{ $row->field }}"
        @if ($isEmpty) style="display:none;" @endif>
        @if (!$isEmpty)
            @if ($decoded !== null && is_array($decoded))
                @foreach ($decoded as $file)
                    @php 
                        $file = (object)$file; 
                        $filename = $file->original_name ?? $file->download_link ?? '';
                    @endphp
                    @if($isImageExt($filename))
                        <div class="custom-preview-container existing-preview sortable-item" data-field-name="{{ $row->field }}">
                            <a href="#" class="voyager-x remove-multi-image close-circle-btn" title="{{ __('admin.remove_file') }}"></a>
                            <img draggable="false" src="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) }}" data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}" class="custom-preview-img">
                        </div>
                    @else
                        <div class="custom-preview-container existing-preview sortable-item" data-field-name="{{ $row->field }}"
                            style="padding: 10px 15px; display: flex; align-items: center;">
                            <a href="#" class="voyager-x remove-multi-file close-circle-btn" title="{{ __('admin.remove_file') }}"></a>
                            <a class="fileType" target="_blank"
                                href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}"
                                style="text-decoration: none; color: #555; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                                <i class="voyager-file-text"></i> {{ $file->original_name ?: '' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                @if($isImageExt($fileVal))
                    <div class="custom-preview-container existing-preview" data-field-name="{{ $row->field }}">
                        <a href="#" class="voyager-x remove-single-image close-circle-btn" title="{{ __('admin.remove_file') }}"></a>
                        <img draggable="false" src="{{ Storage::disk(config('voyager.storage.disk'))->url($fileVal) }}" data-file-name="{{ $fileVal }}" data-id="{{ $dataTypeContent->getKey() }}" class="custom-preview-img">
                    </div>
                @else
                    <div class="custom-preview-container existing-preview" data-field-name="{{ $row->field }}"
                        style="padding: 10px 15px;">
                        <a href="#" class="voyager-x remove-single-file close-circle-btn" title="{{ __('admin.remove_file') }}"></a>
                        <a class="fileType" target="_blank"
                            href="{{ Storage::disk(config('voyager.storage.disk'))->url($fileVal) }}"
                            data-file-name="{{ $fileVal }}" data-id="{{ $dataTypeContent->getKey() }}"
                            style="text-decoration: none; color: #555; font-weight: 600;">
                            <i class="voyager-download"></i> {{ __('voyager::generic.download') }}
                        </a>
                    </div>
                @endif
            @endif
        @endif
    </div>

    <div class="custom-file-input-group">
        <div class="custom-upload-design">
            <i class="voyager-upload"></i>
            <span class="custom-file-title">{{ __('admin.select_file') }}</span>
            <span class="custom-file-text">{{ __('admin.no_file_selected') }}</span>
        </div>

        <input @if ($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file"
            name="{{ $row->field }}[]" multiple="multiple" class="custom-real-input"
            data-preview-target="{{ $row->field }}" data-empty-text="{{ __('admin.no_file_selected') }}">
    </div>

</div>