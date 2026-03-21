@extends('adminlte::page')

@section('title', __('brainwaves.title.index'))

@section('content_header')
    <h1>{{ __('brainwaves.title.index') }}</h1>
@stop

@section('content')

<a href="{{ route('admin.brainwaves.create') }}" class="btn btn-primary mb-3">
    {{ __('brainwaves.button.create') }}
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('brainwaves.table.id') }}</th>
            <th>{{ __('brainwaves.table.name') }}</th>
            <th>{{ __('brainwaves.table.base_frequency') }}</th>
            <th>{{ __('brainwaves.table.beat_frequency') }}</th>
            <th>{{ __('brainwaves.table.duration') }}</th>
            <th>{{ __('brainwaves.table.status') }}</th>
            <th width="180">{{ __('brainwaves.table.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presets as $preset)
            <tr>
                <td>{{ $preset->id }}</td>
                <td>{{ $preset->name }}</td>
                <td>{{ $preset->base_frequency }} Hz</td>
                <td>{{ $preset->beat_frequency }} Hz</td>
                <td>{{ $preset->duration }} {{ __('common.sec') }}</td>
                <td>
                    @if($preset->is_active)
                        <span class="badge bg-success">{{ __('brainwaves.status.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('brainwaves.status.disabled') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.brainwaves.edit', $preset) }}" class="btn btn-warning btn-sm">
                        {{ __('brainwaves.button.edit') }}
                    </a>
                    <form action="{{ route('admin.brainwaves.destroy', $preset) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('brainwaves.confirm.delete') }}')">
                            {{ __('brainwaves.button.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $presets->links() }}

@stop