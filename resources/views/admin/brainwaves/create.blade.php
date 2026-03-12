@extends('adminlte::page')

@section('title','Create Brainwave Preset')

@section('content_header')
<h1>Create Brainwave Preset</h1>
@stop

@section('content')

<form method="POST"
action="{{ route('admin.brainwaves.store') }}">

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

<label>Base Frequency (Hz)</label>

<input type="number"
step="0.1"
name="base_frequency"
class="form-control"
value="200"
required>

</div>

<div class="form-group">

<label>Beat Frequency (Hz)</label>

<input type="number"
step="0.1"
name="beat_frequency"
class="form-control"
required>

</div>

<div class="form-group">

<label>Duration (seconds)</label>

<input type="number"
name="duration"
class="form-control"
value="600"
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
Create
</button>

<a href="{{ route('admin.brainwaves.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop