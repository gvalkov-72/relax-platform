@extends('adminlte::page')

@section('content')

<a href="{{ route('admin.permissions.create') }}"
class="btn btn-primary mb-3">
Create Permission
</a>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Name</th>
<th>Actions</th>
</tr>

@foreach($permissions as $permission)

<tr>

<td>{{ $permission->id }}</td>

<td>{{ $permission->name }}</td>

<td>

<a href="{{ route('admin.permissions.edit',$permission) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form method="POST"
action="{{ route('admin.permissions.destroy',$permission) }}"
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