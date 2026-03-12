@extends('adminlte::page')

@section('content')

<form method="POST"
action="{{ route('admin.permissions.store') }}">

@csrf

<input type="text"
name="name"
placeholder="Permission name"
class="form-control mb-3">

<button class="btn btn-success">
Save
</button>

</form>

@endsection