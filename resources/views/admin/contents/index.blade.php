@extends('adminlte::page')

@section('title', __('contents.title'))

@section('content_header')
    <h1>{{ __('contents.title') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('contents.list') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contents.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('contents.button.create') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.contents.index') }}" class="form-inline mb-3">
                        <div class="form-group mr-2">
                            <select name="type" class="form-control form-control-sm">
                                <option value="">{{ __('contents.filter.all_types') }}</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ __('contents.type.' . $type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="{{ __('contents.filter.search') }}" value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">{{ __('contents.filter.filter_btn') }}</button>
                        <a href="{{ route('admin.contents.index') }}" class="btn btn-sm btn-secondary ml-2">{{ __('contents.filter.clear_btn') }}</a>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('contents.table.id') }}</th>
                                <th>{{ __('contents.table.type') }}</th>
                                <th>{{ __('contents.table.title') }}</th>
                                <th>{{ __('contents.table.excerpt') }}</th>
                                <th>{{ __('contents.table.tags') }}</th>
                                <th>{{ __('contents.table.author') }}</th>
                                <th>{{ __('contents.table.date') }}</th>
                                <th width="200">{{ __('contents.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contents as $content)
                                @if ($content->canView(Auth::user()))
                                    <tr>
                                        <td>{{ $content->id }}</td>
                                        <td>{{ __('contents.type.' . $content->type) }}</td>
                                        <td>{{ $content->title }}</td>
                                        <td>{{ Str::limit($content->excerpt, 50) }}</td>
                                        <td>
                                            @foreach ($content->tags as $tag)
                                                <span class="badge badge-secondary">{{ $tag->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $content->author->name }}</td>
                                        <td>{{ $content->published_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.contents.show', $content->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> {{ __('contents.button.view') }}
                                            </a>
                                            @if ($content->canEdit(Auth::user()))
                                                <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> {{ __('contents.button.edit') }}
                                                </a>
                                            @endif
                                            @if ($content->canDelete(Auth::user()))
                                                <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('contents.messages.delete_confirm') }}')">
                                                        <i class="fas fa-trash"></i> {{ __('contents.button.delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    {{ $contents->links() }}
                </div>
            </div>
        </div>
    </div>
@stop