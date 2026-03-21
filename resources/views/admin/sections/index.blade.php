@extends('adminlte::page')

@section('title', __('sections.title.index'))

@section('content_header')
    <h1>{{ __('sections.title.index') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('sections.button.add') }}
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                     <tr>
                        <th>{{ __('sections.table.id') }}</th>
                        <th>{{ __('sections.table.type') }}</th>
                        <th>{{ __('sections.table.order') }}</th>
                        <th>{{ __('sections.table.active') }}</th>
                        <th width="150">{{ __('sections.table.actions') }}</th>
                     </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                     <tr>
                         <td>{{ $section->id }}</td>
                         <td>{{ ucfirst($section->type) }}</td>
                         <td>{{ $section->sort_order }}</td>
                         <td>
                            @if($section->is_active)
                                <span class="badge badge-success">{{ __('sections.status.yes') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('sections.status.no') }}</span>
                            @endif
                         </td>
                         <td>
                            <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> {{ __('sections.button.edit') }}
                            </a>
                            <form method="POST" action="{{ route('admin.sections.destroy', $section->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('sections.confirm.delete') }}')">
                                    <i class="fas fa-trash"></i> {{ __('sections.button.delete') }}
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