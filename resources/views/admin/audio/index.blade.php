@extends('adminlte::page')

@section('title', __('audio.title.index'))

@section('content_header')
    <h1>{{ __('audio.title.index') }}</h1>
@stop

@section('content')

<a href="{{ route('admin.audio.create') }}" class="btn btn-primary mb-3">
    {{ __('audio.button.upload') }}
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('audio.table.id') }}</th>
            <th>{{ __('audio.table.name') }}</th>
            <th>{{ __('audio.table.type') }}</th>
            <th>{{ __('audio.table.status') }}</th>
            <th width="180">{{ __('audio.table.actions') }}</th>
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
                        <span class="badge bg-success">{{ __('audio.status.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('audio.status.disabled') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.audio.edit', $audio) }}" class="btn btn-warning btn-sm">
                        {{ __('audio.button.edit') }}
                    </a>
                    <form action="{{ route('admin.audio.destroy', $audio) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('audio.confirm.delete') }}')">
                            {{ __('audio.button.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $audioFiles->links() }}

@stop