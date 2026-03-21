@extends('adminlte::page')

@section('title', __('roles.title.create'))

@section('content_header')
    <h1>{{ __('roles.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('roles.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('roles.label.name') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('roles.label.permissions') }}</label>
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}" class="form-check-input">
                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('roles.button.save') }}
                </button>
            </form>
        </div>
    </div>
@stop