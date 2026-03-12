@extends('adminlte::page')

@section('title','Roles')

@section('content')

<a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">
Create Role
</a>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Name</th>
<th>Actions</th>
</tr>

@foreach($roles as $role)

<tr>

<td>{{ $role->id }}</td>
<td>{{ $role->name }}</td>

<td>

<a href="{{ route('admin.roles.edit',$role) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form method="POST"
action="{{ route('admin.roles.destroy',$role) }}"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

@endsection