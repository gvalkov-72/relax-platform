@extends('adminlte::page')

@section('title', __('permissions.title.create'))

@section('content_header')
    <h1>{{ __('permissions.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('permissions.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('permissions.label.name') }}" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('permissions.button.save') }}
                </button>
            </form>
        </div>
    </div>
@stop