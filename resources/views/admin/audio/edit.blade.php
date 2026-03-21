@extends('adminlte::page')

@section('title', __('audio.title.edit'))

@section('content_header')
    <h1>{{ __('audio.title.edit') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.audio.update', $audio) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('audio.label.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $audio->name }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('audio.label.replace_audio') }}</label>
                <input type="file" name="audio" class="form-control">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" {{ $audio->is_active ? 'checked' : '' }}>
                    {{ __('audio.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('audio.button.update') }}</button>
            <a href="{{ route('admin.audio.index') }}" class="btn btn-secondary">{{ __('audio.button.back') }}</a>
        </div>
    </div>
</form>

@stop