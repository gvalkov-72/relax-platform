@extends('adminlte::page')

@section('title', __('tags.title.edit'))

@section('content_header')
    <h1>{{ __('tags.title.edit') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.tags.update', $tag->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">{{ __('tags.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $tag->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('tags.label.description') }}</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $tag->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">{{ __('tags.button.update') }}</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">{{ __('tags.button.back') }}</a>
            </form>
        </div>
    </div>
@stop