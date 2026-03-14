@extends('adminlte::page')

@section('title', 'Pages')

@section('content_header')
    <h1>Pages</h1>
@stop

@section('content')
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Create Page
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
                        <th>Title (BG)</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Active</th>
                        <th>In Menu</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        @php
                            $bgTranslation = $page->translations->where('language_id', 1)->first(); // ако bg е с id=1
                        @endphp
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $bgTranslation->title ?? 'No title' }}</td>
                            <td>{{ $bgTranslation->slug ?? '-' }}</td>
                            <td>{{ $page->template }}</td>
                            <td>
                                @if($page->is_active)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td>
                                @if($page->show_in_menu)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this page?')">
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