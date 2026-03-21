@extends('adminlte::page')

@section('title', __('permissions.title.index'))

@section('content_header')
    <h1>{{ __('permissions.title.index') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('permissions.button.create') }}
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('permissions.table.id') }}</th>
                        <th>{{ __('permissions.table.name') }}</th>
                        <th width="150">{{ __('permissions.table.actions') }}</th>
                    </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('permissions.button.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('permissions.confirm.delete') }}')">
                                        <i class="fas fa-trash"></i> {{ __('permissions.button.delete') }}
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