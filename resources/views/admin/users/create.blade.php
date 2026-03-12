@extends('adminlte::page')

@section('content')

<form method="POST" action="{{ route('admin.users.store') }}">

@csrf

<div class="form-group">

<label>Name</label>

<input type="text" name="name" class="form-control">

</div>

<div class="form-group">

<label>Email</label>

<input type="email" name="email" class="form-control">

</div>

<div class="form-group">

<label>Password</label>

<input type="password" name="password" class="form-control">

</div>

<div class="form-group">

<label>Role</label>

<select name="role" class="form-control">

@foreach($roles as $role)

<option value="{{ $role->name }}">
{{ $role->name }}
</option>

@endforeach

</select>

</div>

<button class="btn btn-success mt-3">
Save
</button>

</form>

@endsection