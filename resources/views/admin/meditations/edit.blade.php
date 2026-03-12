@extends('adminlte::page')

@section('title','Edit Meditation')

@section('content_header')
<h1>Edit Meditation</h1>
@stop

@section('content')

<form method="POST"
action="{{ route('admin.meditations.update',$meditation) }}">

@csrf
@method('PUT')

<div class="card">
<div class="card-body">

<div class="form-group">
<label>Name</label>
<input type="text"
name="name"
class="form-control"
value="{{ $meditation->name }}"
required>
</div>

<div class="form-group">
<label>Description</label>
<textarea
name="description"
class="form-control">{{ $meditation->description }}</textarea>
</div>

<div class="form-group">
<label>Duration</label>
<input type="number"
name="duration"
class="form-control"
value="{{ $meditation->duration }}">
</div>

<div class="form-group">

<label>

<input type="checkbox"
name="is_active"
{{ $meditation->is_active ? 'checked' : '' }}>

Active

</label>

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">
Update
</button>

<a href="{{ route('admin.meditations.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop