@extends('adminlte::page')

@section('content')

<form method="POST" action="{{ route('admin.roles.store') }}">

@csrf

<input type="text"
name="name"
placeholder="Role name"
class="form-control mb-3">

<label>Permissions</label>

@foreach($permissions as $permission)

<div>

<input type="checkbox"
name="permissions[]"
value="{{ $permission->name }}">

{{ $permission->name }}

</div>

@endforeach

<button class="btn btn-success mt-3">
Save
</button>

</form>

@endsection