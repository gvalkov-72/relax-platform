@extends('adminlte::page')

@section('title', __('roles.title.edit'))

@section('content_header')
    <h1>{{ __('roles.title.edit') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">{{ __('roles.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('roles.label.permissions') }}</label>
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   id="perm-{{ $permission->id }}" class="form-check-input"
                                   @if($role->hasPermissionTo($permission->name)) checked @endif>
                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('roles.button.update') }}
                </button>
            </form>
        </div>
    </div>
@stop