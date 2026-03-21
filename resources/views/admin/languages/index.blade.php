@extends('adminlte::page')

@section('title', __('languages.title'))

@section('content_header')
    <h1>{{ __('languages.title') }}</h1>
@stop

@section('content')
    <a href="{{ route('admin.languages.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> {{ __('languages.button.add') }}
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('languages.table.id') }}</th>
                        <th>{{ __('languages.table.name') }}</th>
                        <th>{{ __('languages.table.code') }}</th>
                        <th>{{ __('languages.table.default') }}</th>
                        <th>{{ __('languages.table.active') }}</th>
                        <th>{{ __('languages.table.order') }}</th>
                        <th width="150">{{ __('languages.table.actions') }}</th>
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
                                <span class="badge badge-success">{{ __('languages.status.yes') }}</span>
                            @else
                                <span class="badge badge-secondary">{{ __('languages.status.no') }}</span>
                            @endif
                         </td>
                         <td>
                            @if($lang->is_active)
                                <span class="badge badge-success">{{ __('languages.status.active') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('languages.status.inactive') }}</span>
                            @endif
                         </td>
                         <td>{{ $lang->sort_order }}</td>
                         <td>
                            <a href="{{ route('admin.languages.edit', $lang->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> {{ __('languages.button.edit') }}
                            </a>
                            <form method="POST" action="{{ route('admin.languages.destroy', $lang->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('languages.confirm.delete') }}')">
                                    <i class="fas fa-trash"></i> {{ __('languages.button.delete') }}
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