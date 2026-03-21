@extends('adminlte::page')

@section('title', __('audio.title.create'))

@section('content_header')
    <h1>{{ __('audio.title.create') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.audio.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('audio.label.name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>{{ __('audio.label.audio_file') }}</label>
                <input type="file" name="audio" class="form-control" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" checked>
                    {{ __('audio.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('audio.button.upload') }}</button>
            <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">{{ __('audio.button.back') }}</a>
        </div>
    </div>
</form>

@stop