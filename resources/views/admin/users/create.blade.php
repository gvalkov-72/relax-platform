@extends('adminlte::page')

@section('title', __('users.title.create'))

@section('content_header')
    <h1>{{ __('users.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('users.label.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">{{ __('users.label.email') }}</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('users.label.password') }}</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="role">{{ __('users.label.role') }}</label>
                    <select name="role" id="role" class="form-control">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-save"></i> {{ __('users.button.save') }}
                </button>
            </form>
        </div>
    </div>
@stop