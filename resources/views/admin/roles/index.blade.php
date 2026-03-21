@extends('adminlte::page')

@section('title', __('roles.title.index'))

@section('content_header')
    <h1>{{ __('roles.title.index') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('roles.button.create') }}
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                     <tr>
                        <th>{{ __('roles.table.id') }}</th>
                        <th>{{ __('roles.table.name') }}</th>
                        <th width="150">{{ __('roles.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> {{ __('roles.button.edit') }}
                            </a>
                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('roles.confirm.delete') }}')">
                                    <i class="fas fa-trash"></i> {{ __('roles.button.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop