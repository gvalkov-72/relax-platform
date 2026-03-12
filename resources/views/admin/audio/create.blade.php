@extends('adminlte::page')

@section('title','Upload Audio')

@section('content_header')
<h1>Upload Audio</h1>
@stop

@section('content')

<form method="POST"
action="{{ route('admin.audio.store') }}"
enctype="multipart/form-data">

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

<label>Audio File</label>

<input type="file"
name="audio"
class="form-control"
required>

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
Upload
</button>

<a href="{{ route('admin.audio.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop