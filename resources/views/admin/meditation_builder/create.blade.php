@extends('adminlte::page')

@section('title', 'Add Meditation Item')

@section('content')

<h1>Add Item</h1>

<form method="POST" action="{{ route('admin.meditation.builder.store') }}">

@csrf

<input type="hidden" name="meditation_id" value="{{ $meditation->id }}">

<div class="form-group">
<label>Item Type</label>
<select name="item_type" class="form-control">
<option value="audio">Audio</option>
<option value="brainwave">Brainwave</option>
<option value="generator">Generator</option>
<option value="silence">Silence</option>
</select>
</div>

<div class="form-group">
<label>Audio File</label>
<select name="item_id" class="form-control">
<option value="">None</option>

@foreach($audioFiles as $audio)

<option value="{{ $audio->id }}">
{{ $audio->name }}

</option>

@endforeach

</select>
</div>

<div class="form-group">
<label>Brainwave</label>

<select name="item_id" class="form-control">

<option value="">None</option>

@foreach($brainwaves as $bw)

<option value="{{ $bw->id }}">
{{ $bw->name }}

</option>

@endforeach

</select>

</div>

<div class="form-group">
<label>Start Time (seconds)</label>

<input type="number" name="start_time" class="form-control">
</div>

<div class="form-group">
<label>Duration (seconds)</label>

<input type="number" name="duration" class="form-control">
</div>

<div class="form-group">
<label>Volume</label>

<input type="number" name="volume" class="form-control" value="100">
</div>

<button class="btn btn-success">
Save
</button>

</form>

@stop