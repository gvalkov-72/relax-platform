@extends('adminlte::page')

@section('title', __('brainwaves.title.edit'))

@section('content_header')
    <h1>{{ __('brainwaves.title.edit') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.brainwaves.update', $brainwave) }}">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('brainwaves.label.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $brainwave->name }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.base_frequency') }}</label>
                <input type="number" step="0.1" name="base_frequency" class="form-control" value="{{ $brainwave->base_frequency }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.beat_frequency') }}</label>
                <input type="number" step="0.1" name="beat_frequency" class="form-control" value="{{ $brainwave->beat_frequency }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.duration') }}</label>
                <input type="number" name="duration" class="form-control" value="{{ $brainwave->duration }}" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" {{ $brainwave->is_active ? 'checked' : '' }}>
                    {{ __('brainwaves.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('brainwaves.button.update') }}</button>
            <a href="{{ route('admin.brainwaves.index') }}" class="btn btn-secondary">{{ __('brainwaves.button.back') }}</a>
        </div>
    </div>
</form>

@stop