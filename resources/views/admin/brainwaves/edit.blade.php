@extends('adminlte::page')

@section('title','Edit Brainwave Preset')

@section('content_header')
<h1>Edit Brainwave Preset</h1>
@stop

@section('content')

<form method="POST"
action="{{ route('admin.brainwaves.update',$brainwave) }}">

@csrf
@method('PUT')

<div class="card">

<div class="card-body">

<div class="form-group">

<label>Name</label>

<input type="text"
name="name"
class="form-control"
value="{{ $brainwave->name }}"
required>

</div>

<div class="form-group">

<label>Base Frequency</label>

<input type="number"
step="0.1"
name="base_frequency"
class="form-control"
value="{{ $brainwave->base_frequency }}"
required>

</div>

<div class="form-group">

<label>Beat Frequency</label>

<input type="number"
step="0.1"
name="beat_frequency"
class="form-control"
value="{{ $brainwave->beat_frequency }}"
required>

</div>

<div class="form-group">

<label>Duration</label>

<input type="number"
name="duration"
class="form-control"
value="{{ $brainwave->duration }}"
required>

</div>

<div class="form-group">

<label>

<input type="checkbox"
name="is_active"
{{ $brainwave->is_active ? 'checked' : '' }}>

Active

</label>

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">
Update
</button>

<a href="{{ route('admin.brainwaves.index') }}"
class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

@stop