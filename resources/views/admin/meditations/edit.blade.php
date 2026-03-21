@extends('adminlte::page')

@section('title', __('meditations.title.edit'))

@section('content_header')
    <h1>{{ __('meditations.title.edit') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.meditations.update', $meditation) }}">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('meditations.label.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $meditation->name }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('meditations.label.description') }}</label>
                <textarea name="description" class="form-control">{{ $meditation->description }}</textarea>
            </div>

            <div class="form-group">
                <label>{{ __('meditations.label.duration') }}</label>
                <input type="number" name="duration" class="form-control" value="{{ $meditation->duration }}">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" {{ $meditation->is_active ? 'checked' : '' }}>
                    {{ __('meditations.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('meditations.button.update') }}</button>
            <a href="{{ route('admin.meditations.index') }}" class="btn btn-secondary">{{ __('meditations.button.back') }}</a>
        </div>
    </div>
</form>

@stop