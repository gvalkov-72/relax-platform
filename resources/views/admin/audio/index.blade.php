@extends('adminlte::page')

@section('title','Audio Files')

@section('content_header')
<h1>Audio Files</h1>
@stop

@section('content')

<a href="{{ route('admin.audio.create') }}" class="btn btn-primary mb-3">
Upload Audio
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
<th>Type</th>
<th>Status</th>
<th width="180">Actions</th>

</tr>

</thead>

<tbody>

@foreach($audioFiles as $audio)

<tr>

<td>{{ $audio->id }}</td>

<td>{{ $audio->name }}</td>

<td>{{ $audio->type }}</td>

<td>

@if($audio->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Disabled</span>
@endif

</td>

<td>

<a href="{{ route('admin.audio.edit',$audio) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.audio.destroy',$audio) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete audio?')">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $audioFiles->links() }}

@stop