@extends('adminlte::page')

@section('title', 'Languages')

@section('content_header')
    <h1>Languages</h1>
@stop

@section('content')
    <a href="{{ route('admin.languages.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Language
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Default</th>
                        <th>Active</th>
                        <th>Order</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($languages as $lang)
                    <tr>
                        <td>{{ $lang->id }}</td>
                        <td>{{ $lang->name }}</td>
                        <td><code>{{ $lang->code }}</code></td>
                        <td>
                            @if($lang->is_default)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if($lang->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $lang->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.languages.edit', $lang->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.languages.destroy', $lang->id) }}"
                                  style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete language?')">
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