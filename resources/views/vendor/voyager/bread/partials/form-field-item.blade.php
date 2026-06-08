<div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}"
    @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
    {{ $row->slugify }}

    <label class="control-label" for="{{ $row->field }}">
        {{ $row->getTranslatedAttribute('display_name') }}
        @if($row->required == 1) <span style="color:var(--primary-custom)">*</span> @endif
    </label>

    @include('voyager::multilingual.input-hidden-bread-edit-add')

    @php
        $add = is_null($dataTypeContent->getKey());
        $edit = !$add;
    @endphp

    @if ($add && isset($row->details->view_add))
        @include($row->details->view_add, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'add', 'options' => $row->details])
    @elseif ($edit && isset($row->details->view_edit))
        @include($row->details->view_edit, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'edit', 'options' => $row->details])
    @elseif (isset($row->details->view))
        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
    @elseif ($row->type == 'relationship')
        @include('voyager::formfields.relationship', ['options' => $row->details])
    @else
        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
    @endif

    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
    @endforeach

    @if($row->field == 'icon')
        <small class="help-block" style="margin-top: 8px; display: block; color: #666; font-weight: 500;">
            <i class="voyager-info-circled"></i>
            İkon listesine ve isimlerine <a href="{{ route('admin.icons') }}" target="_blank"
                style="text-decoration: underline; font-weight: bold; color: #666;">buradan</a> ulaşabilir,
            istediğiniz ikon ismini kopyalayıp yukarıdaki alana yapıştırabilirsiniz.
        </small>
    @endif

    @if(substr($row->field, -4) === '_url' && isset($allBreadFields) && in_array(substr($row->field, 0, -4), $allBreadFields))
        <small class="help-block" style="margin-top: 8px; display: block; color: #8a6d3b;">
            <i class="voyager-lightbulb"></i>
            Buraya bir link yapıştırırsanız, sistem yukarıdaki dosyayı değil, bu linkteki veriyi kullanır.
        </small>
    @elseif(isset($allBreadFields) && in_array($row->field . '_url', $allBreadFields))
        <small class="help-block" style="margin-top: 8px; display: block; color: #666;">
            <i class="voyager-info-circled"></i>
            <strong>URL</strong> kutusu doluysa, buradaki dosya yerine o adresteki veri geçerli olur.
        </small>
    @endif

    @if ($errors->has($row->field))
        @foreach ($errors->get($row->field) as $error)
            <span class="help-block text-danger">{{ $error }}</span>
        @endforeach
    @endif
</div>