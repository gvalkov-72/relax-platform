@extends('adminlte::page')

@section('title','Users')

@section('content')

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
Create User
</a>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Actions</th>
</tr>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>{{ $user->roles->pluck('name')->join(', ') }}</td>

<td>

<a href="{{ route('admin.users.edit',$user) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form method="POST"
action="{{ route('admin.users.destroy',$user) }}"
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