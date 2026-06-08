@extends('voyager::master')

@section('page_title', __('admin.edit_language_file'))

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-edit"></i> {{ __('admin.edit_language_file') }}
    </h1>
    <a href="{{ route('admin.language-files.index') }}" class="btn btn-warning">
        <i class="voyager-angle-left"></i> {{ __('admin.back') }}
    </a>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="flag-icon flag-icon-{{ $locale }}"></span>
                            {{ strtoupper($locale) }} - {{ $file }}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('admin.language-files.update', ['locale' => $locale, 'file' => $file]) }}"
                            method="POST" id="translationForm">
                            @csrf

                            <div class="table-responsive">
                                <table class="table table-striped" id="translationsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">{{ __('admin.translation_key') }}</th>
                                            <th style="width: 60%;">{{ __('admin.translation_value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $key => $value)
                                            <tr class="translation-row">
                                                <td>
                                                    <input type="hidden" name="keys[]" value="{{ $key }}">
                                                    <code class="key-display">{{ $key }}</code>
                                                </td>
                                                <td>
                                                    <textarea class="form-control value-input" name="values[]" rows="2">{{ $value }}</textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">
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
@stop

@section('css')
    <style>
        .translation-row td {
            vertical-align: middle;
        }

        .key-display {
            font-size: 13px;
            background: #f5f5f5;
            padding: 6px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        .value-input {
            resize: vertical;
            min-height: 40px;
        }

        .mt-3 {
            margin-top: 15px;
        }
    </style>
@stop
