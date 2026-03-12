<!-- resources/views/admin/dashboard.blade.php -->

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $usersCount ?? 0 }}</h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@stop
