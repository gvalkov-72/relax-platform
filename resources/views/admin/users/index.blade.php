@extends('adminlte::page')

@section('title', __('users.title.index'))

@section('content_header')
    <h1>{{ __('users.title.index') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('users.button.create') }}
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>{{ __('users.table.id') }}</th>
                    <th>{{ __('users.table.name') }}</th>
                    <th>{{ __('users.table.email') }}</th>
                    <th>{{ __('users.table.role') }}</th>
                    <th width="180">{{ __('users.table.actions') }}</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('users.button.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('{{ __('users.confirm.delete') }}')">
                                        <i class="fas fa-trash"></i> {{ __('users.button.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@stop
