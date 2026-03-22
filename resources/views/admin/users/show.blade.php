@extends('adminlte::page')

@section('title', __('users.title.show'))

@section('content_header')
    <h1>{{ __('users.title.show') }}</h1>
@stop

@section('content')

<div class="row">

    {{-- LEFT COLUMN --}}
    <div class="col-md-4">

        {{-- PROFILE CARD --}}
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">

                <div class="mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->email }}</p>

                <hr>

                {{-- Roles --}}
                <strong><i class="fas fa-user-tag mr-1"></i> {{ __('users.label.role') }}</strong>
                <p class="text-muted">
                    @forelse($user->roles as $role)
                        <span class="badge badge-info">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">{{ __('users.empty.roles') }}</span>
                    @endforelse
                </p>

                <hr>

                {{-- Permissions --}}
                <strong><i class="fas fa-key mr-1"></i> {{ __('users.label.permissions') }}</strong>
                <p class="text-muted">
                    @forelse($user->permissions as $perm)
                        <span class="badge badge-secondary">{{ $perm->name }}</span>
                    @empty
                        <span class="text-muted">{{ __('users.empty.permissions') }}</span>
                    @endforelse
                </p>

            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-md-8">

        {{-- USER DETAILS --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('users.section.info') }}</h3>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>ID</strong></div>
                    <div class="col-sm-8">{{ $user->id }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>{{ __('users.label.name') }}</strong></div>
                    <div class="col-sm-8">{{ $user->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>{{ __('users.label.email') }}</strong></div>
                    <div class="col-sm-8">{{ $user->email }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>{{ __('users.label.created_at') }}</strong></div>
                    <div class="col-sm-8">{{ $user->created_at?->format('d.m.Y H:i') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>{{ __('users.label.updated_at') }}</strong></div>
                    <div class="col-sm-8">{{ $user->updated_at?->format('d.m.Y H:i') }}</div>
                </div>

                <hr>

                {{-- LAST LOGIN --}}
                @php
                    $lastSession = DB::table('sessions')
                        ->where('user_id', $user->id)
                        ->orderByDesc('last_activity')
                        ->first();
                @endphp

                <div class="row mb-3">
                    <div class="col-sm-4"><strong>{{ __('users.label.last_activity') }}</strong></div>
                    <div class="col-sm-8">
                        @if($lastSession)
                            {{ \Carbon\Carbon::createFromTimestamp($lastSession->last_activity)->format('d.m.Y H:i') }}
                        @else
                            <span class="text-muted">{{ __('users.empty.last_activity') }}</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('users.section.actions') }}</h3>
            </div>

            <div class="card-body">

                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> {{ __('users.button.edit') }}
                </a>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('users.button.back') }}
                </a>

            </div>
        </div>

    </div>

</div>

@stop