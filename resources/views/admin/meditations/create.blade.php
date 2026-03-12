@extends('adminlte::page')

@section('title','Create Meditation')

@section('content_header')
<h1>Create Meditation</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.meditations.store') }}">

@csrf

<div class="card">
<div class="card-body">

<div class="form-group">
<label>Name</label>
<input type="text"
name="name"
class="form-control"
required>
</div>

<div class="form-group">
<label>Description</label>
<textarea
name="description"
class="form-control"></textarea>
</div>

<div class="form-group">
<label>Duration (seconds)</label>
<input type="number"
name="duration"
class="form-control">
</div>

<div class="form-group">

<label>

<input type="checkbox"
name="is_active"
checked>

Active

</label>

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">
Save
</button>

<a href="{{ route('admin.meditations.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop