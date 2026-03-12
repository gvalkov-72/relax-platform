@extends('adminlte::page')

@section('title', 'Meditations')

@section('content_header')
    <h1>Meditations</h1>
@stop

@section('content')

<a href="{{ route('admin.meditations.create') }}" class="btn btn-primary mb-3">
    Create Meditation
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
<th>Duration</th>
<th>Status</th>
<th width="180">Actions</th>
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
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Disabled</span>
@endif
</td>

<td>

<a href="{{ route('admin.meditations.edit',$meditation) }}"
class="btn btn-sm btn-warning">Edit</a>

<form action="{{ route('admin.meditations.destroy',$meditation) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('Delete meditation?')">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $meditations->links() }}

@stop