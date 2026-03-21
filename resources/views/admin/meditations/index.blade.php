@extends('adminlte::page')

@section('title', __('meditations.title.index'))

@section('content_header')
    <h1>{{ __('meditations.title.index') }}</h1>
@stop

@section('content')

<a href="{{ route('admin.meditations.create') }}" class="btn btn-primary mb-3">
    {{ __('meditations.button.create') }}
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>{{ __('meditations.table.id') }}</th>
            <th>{{ __('meditations.table.name') }}</th>
            <th>{{ __('meditations.table.duration') }}</th>
            <th>{{ __('meditations.table.active') }}</th>
            <th width="220">{{ __('meditations.table.actions') }}</th>
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
                    <span class="badge badge-success">{{ __('meditations.status.yes') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('meditations.status.no') }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.meditations.edit', $meditation->id) }}" class="btn btn-warning btn-sm">
                    {{ __('meditations.button.edit') }}
                </a>
                <a href="{{ route('admin.meditation.builder', $meditation->id) }}" class="btn btn-info btn-sm">
                    {{ __('meditations.button.builder') }}
                </a>
                <form method="POST" action="{{ route('admin.meditations.destroy', $meditation->id) }}" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('meditations.confirm.delete') }}')">
                        {{ __('meditations.button.delete') }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop