@extends('adminlte::page')

@section('title', __('brainwaves.title.create'))

@section('content_header')
    <h1>{{ __('brainwaves.title.create') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.brainwaves.store') }}">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('brainwaves.label.name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.base_frequency') }}</label>
                <input type="number" step="0.1" name="base_frequency" class="form-control" value="200" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.beat_frequency') }}</label>
                <input type="number" step="0.1" name="beat_frequency" class="form-control" required>
            </div>

            <div class="form-group">
                <label>{{ __('brainwaves.label.duration') }}</label>
                <input type="number" name="duration" class="form-control" value="600" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" checked>
                    {{ __('brainwaves.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('brainwaves.button.create') }}</button>
            <a href="{{ route('admin.brainwaves.index') }}" class="btn btn-secondary">{{ __('brainwaves.button.back') }}</a>
        </div>
    </div>
</form>

@stop