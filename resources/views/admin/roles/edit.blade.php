@extends('adminlte::page')

@section('content')

<form method="POST"
action="{{ route('admin.roles.update',$role) }}">

@csrf
@method('PUT')

<input type="text"
name="name"
value="{{ $role->name }}"
class="form-control mb-3">

<label>Permissions</label>

@foreach($permissions as $permission)

<div>

<input type="checkbox"
name="permissions[]"
value="{{ $permission->name }}"
@if($role->hasPermissionTo($permission->name)) checked @endif
>

{{ $permission->name }}

</div>

@endforeach

<button class="btn btn-success mt-3">
Update
</button>

</form>

@endsection