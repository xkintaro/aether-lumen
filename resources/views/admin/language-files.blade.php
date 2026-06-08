@extends('voyager::master')

@section('page_title', __('admin.system_translations'))

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-world"></i> {{ __('admin.system_translations') }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @foreach ($languages as $locale => $files)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="flag-icon flag-icon-{{ $locale == 'en' ? 'gb' : $locale }}"></span>
                                {{ strtoupper($locale) }}
                                @if ($locale == $default)
                                    <span class="label label-primary">{{ __('voyager::generic.default') }}</span>
                                @endif
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.file_name') }}</th>
                                            <th>{{ __('admin.status') }}</th>
                                            <th>{{ __('admin.size') }}</th>
                                            <th class="text-right">{{ __('voyager::generic.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($files as $file)
                                            <tr>
                                                <td>
                                                    <i class="voyager-file-code"></i>
                                                    {{ $file['name'] }}
                                                </td>
                                                <td>
                                                    @if ($file['exists'])
                                                        <span class="label label-success">
                                                            <i class="voyager-check"></i> {{ __('admin.exists') }}
                                                        </span>
                                                    @else
                                                        <span class="label label-danger">
                                                            <i class="voyager-x"></i> {{ __('admin.missing') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($file['exists'])
                                                        {{ number_format($file['size'] / 1024, 2) }} KB
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if ($file['exists'])
                                                        <a href="{{ route('admin.language-files.edit', ['locale' => $locale, 'file' => $file['name']]) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="voyager-edit"></i> {{ __('voyager::generic.edit') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <style>
        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title .label {
            font-size: 11px;
        }
    </style>
@stop
