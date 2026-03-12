@extends('adminlte::page')

@section('title','Brainwave Presets')

@section('content_header')
<h1>Brainwave Presets</h1>
@stop

@section('content')

<a href="{{ route('admin.brainwaves.create') }}" class="btn btn-primary mb-3">
Create Preset
</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Base Frequency</th>
<th>Beat Frequency</th>
<th>Duration</th>
<th>Status</th>
<th width="180">Actions</th>

</tr>

</thead>

<tbody>

@foreach($presets as $preset)

<tr>

<td>{{ $preset->id }}</td>

<td>{{ $preset->name }}</td>

<td>{{ $preset->base_frequency }} Hz</td>

<td>{{ $preset->beat_frequency }} Hz</td>

<td>{{ $preset->duration }} sec</td>

<td>

@if($preset->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Disabled</span>
@endif

</td>

<td>

<a href="{{ route('admin.brainwaves.edit',$preset) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.brainwaves.destroy',$preset) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete preset?')">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $presets->links() }}

@stop