@extends('adminlte::page')

@section('title', 'Sections')

@section('content_header')
    <h1>Homepage Sections</h1>
@stop

@section('content')
    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Section
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                    <tr>
                        <td>{{ $section->id }}</td>
                        <td>{{ $section->type }}</td>
                        <td>{{ $section->sort_order }}</td>
                        <td>
                            @if($section->is_active)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.sections.destroy', $section->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this section?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop