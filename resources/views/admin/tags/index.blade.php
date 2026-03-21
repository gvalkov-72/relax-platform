@extends('adminlte::page')

@section('title', __('tags.title.index'))

@section('content_header')
    <h1>{{ __('tags.title.index') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('tags.button.create') }}
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    乳
                        <th>{{ __('tags.table.id') }}</th>
                        <th>{{ __('tags.table.name') }}</th>
                        <th>{{ __('tags.table.slug') }}</th>
                        <th>{{ __('tags.table.description') }}</th>
                        <th width="150">{{ __('tags.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->slug }}</td>
                            <td>{{ Str::limit($tag->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('tags.button.edit') }}
                                </a>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('tags.confirm.delete') }}')">
                                        <i class="fas fa-trash"></i> {{ __('tags.button.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    </div>
@stop