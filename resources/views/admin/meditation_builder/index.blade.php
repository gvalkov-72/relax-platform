@extends('adminlte::page')

@section('title', 'Meditation Builder')

@section('content')

<h1>{{ $meditation->name }} Builder</h1>

<a href="{{ route('admin.meditation.builder.create', $meditation->id) }}" class="btn btn-primary mb-3">
Add Item
</a>

<table class="table table-bordered">
<thead>
<tr>
<th>Type</th>
<th>Start</th>
<th>Duration</th>
<th>Volume</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($items as $item)

<tr>

<td>{{ $item->item_type }}</td>

<td>{{ $item->start_time }}</td>

<td>{{ $item->duration }}</td>

<td>{{ $item->volume }}</td>

<td>

<form method="POST"
action="{{ route('admin.meditation.builder.destroy',$item->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">Delete</button>

</form>

</td>

</tr>

@endforeach

</tbody>
</table>

@stop