@extends('adminlte::page')

@section('title', 'Meditations')

@section('content_header')
<h1>Meditations</h1>
@stop

@section('content')

<a href="{{ route('admin.meditations.create') }}" class="btn btn-primary mb-3">
Create Meditation
</a>

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Duration</th>
<th>Active</th>
<th width="220">Actions</th>
</tr>
</thead>

<tbody>

@foreach($meditations as $meditation)

<tr>

<td>{{ $meditation->id }}</td>

<td>{{ $meditation->name }}</td>

<td>{{ $meditation->duration }}</td>

<td>
@if($meditation->is_active)
<span class="badge badge-success">Yes</span>
@else
<span class="badge badge-danger">No</span>
@endif
</td>

<td>

<a href="{{ route('admin.meditations.edit',$meditation->id) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="{{ route('admin.meditation.builder',$meditation->id) }}"
class="btn btn-info btn-sm">
Builder
</a>

<form method="POST"
action="{{ route('admin.meditations.destroy',$meditation->id) }}"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@stop