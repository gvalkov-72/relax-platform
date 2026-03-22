@extends('adminlte::page')

@section('title', __('users.title.index'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">{{ __('users.title.index') }}</h1>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> {{ __('users.button.create') }}
        </a>
    </div>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users"></i> {{ __('users.title.index') }}
            </h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="60">{{ __('users.table.id') }}</th>
                        <th>{{ __('users.table.name') }}</th>
                        <th>{{ __('users.table.email') }}</th>
                        <th>{{ __('users.table.role') }}</th>
                        <th width="220" class="text-center">
                            {{ __('users.table.actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">{{ $user->id }}</td>

                            <td class="align-middle">
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td class="align-middle">
                                <i class="fas fa-envelope text-muted"></i>
                                {{ $user->email }}
                            </td>

                            <td class="align-middle">
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-info">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>

                            <td class="align-middle text-center">

                                {{-- VIEW --}}
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-info btn-sm"
                                   title="{{ __('users.button.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-warning btn-sm"
                                   title="{{ __('users.button.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- DELETE --}}
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            title="{{ __('users.button.delete') }}"
                                            onclick="return confirm('{{ __('users.confirm.delete') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-muted">
                                <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                                {{ __('users.messages.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>

@stop