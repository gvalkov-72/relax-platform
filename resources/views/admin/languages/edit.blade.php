@extends('adminlte::page')

@section('title', __('languages.edit'))

@section('content_header')
    <h1>{{ __('languages.edit') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.languages.update', $language->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">{{ __('languages.label.name') }}</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $language->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="code">{{ __('languages.label.code') }}</label>
                    <input type="text" name="code" id="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $language->code) }}" required>
                </div>

                <div class="form-group">
                    <label for="sort_order">{{ __('languages.label.sort_order') }}</label>
                    <input type="number" name="sort_order" id="sort_order"
                           class="form-control" value="{{ old('sort_order', $language->sort_order) }}">
                </div>

                <div class="form-check mb-2">
                    <input type="checkbox" name="is_default" id="is_default"
                           class="form-check-input" value="1"
                           {{ $language->is_default ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">
                        {{ __('languages.label.is_default') }}
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active"
                           class="form-check-input" value="1"
                           {{ $language->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        {{ __('languages.label.is_active') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('languages.button.update') }}
                </button>
                <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">
                    {{ __('languages.button.cancel') }}
                </a>
            </form>
        </div>
    </div>
@stop