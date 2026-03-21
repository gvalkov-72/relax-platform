@extends('adminlte::page')

@section('title', __('permissions.title.edit'))

@section('content_header')
    <h1>{{ __('permissions.title.edit') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('permissions.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('permissions.button.update') }}
                </button>
            </form>
        </div>
    </div>
@stop