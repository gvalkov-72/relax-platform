@extends('adminlte::page')

@section('title', __('meditations.title.create'))

@section('content_header')
    <h1>{{ __('meditations.title.create') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.meditations.store') }}">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('meditations.label.name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>{{ __('meditations.label.description') }}</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>{{ __('meditations.label.duration') }}</label>
                <input type="number" name="duration" class="form-control">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" checked>
                    {{ __('meditations.label.active') }}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('meditations.button.save') }}</button>
            <a href="{{ route('admin.meditations.index') }}" class="btn btn-secondary">{{ __('meditations.button.back') }}</a>
        </div>
    </div>
</form>

@stop