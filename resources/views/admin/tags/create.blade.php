@extends('adminlte::page')

@section('title', __('tags.title.create'))

@section('content_header')
    <h1>{{ __('tags.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.tags.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('tags.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('tags.label.description') }}</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">{{ __('tags.button.save') }}</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">{{ __('tags.button.cancel') }}</a>
            </form>
        </div>
    </div>
@stop