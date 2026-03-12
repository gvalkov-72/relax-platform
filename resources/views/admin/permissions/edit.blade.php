@extends('adminlte::page')

@section('content')

<form method="POST"
action="{{ route('admin.permissions.update',$permission) }}">

@csrf
@method('PUT')

<input type="text"
name="name"
value="{{ $permission->name }}"
class="form-control mb-3">

<button class="btn btn-success">
Update
</button>

</form>

@endsection