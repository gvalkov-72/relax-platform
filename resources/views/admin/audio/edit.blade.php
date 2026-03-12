@extends('adminlte::page')

@section('title','Edit Audio')

@section('content_header')
<h1>Edit Audio</h1>
@stop

@section('content')

<form method="POST"
action="{{ route('admin.audio.update',$audio) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="card">

<div class="card-body">

<div class="form-group">

<label>Name</label>

<input type="text"
name="name"
class="form-control"
value="{{ $audio->name }}"
required>

</div>

<div class="form-group">

<label>Replace Audio</label>

<input type="file"
name="audio"
class="form-control">

</div>

<div class="form-group">

<label>

<input type="checkbox"
name="is_active"
{{ $audio->is_active ? 'checked' : '' }}>

Active

</label>

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">
Update
</button>

<a href="{{ route('admin.audio.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop