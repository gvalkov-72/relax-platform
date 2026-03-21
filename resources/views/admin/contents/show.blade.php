@extends('adminlte::page')

@section('title', __('contents.show'))

@section('content_header')
    <h1>{{ __('contents.show') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>{{ $content->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('contents.button.back') }}
                        </a>
                        @if ($content->canEdit(Auth::user()))
                            <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> {{ __('contents.button.edit') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">{{ __('contents.label.type') }}</th>
                                    <td><span class="badge badge-info">{{ __('contents.type.' . $content->type) }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ __('contents.label.author') }}</th>
                                    <td><i class="fas fa-user mr-1"></i>{{ $content->author->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('contents.label.date') }}</th>
                                    <td><i class="fas fa-calendar-alt mr-1"></i>{{ $content->published_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                @if ($content->tags->count() > 0)
                                    <tr>
                                        <th>{{ __('contents.table.tags') }}</th>
                                        <td>
                                            @foreach ($content->tags as $tag)
                                                <span class="badge badge-info">{{ $tag->name }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                                @if ($content->excerpt)
                                    <tr>
                                        <th>{{ __('contents.label.excerpt') }}</th>
                                        <td><em>{{ $content->excerpt }}</em></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5><i class="fas fa-align-left mr-2"></i>{{ __('contents.label.body') }}</h5>
                    <div class="p-4 bg-light rounded border">
                        {!! $content->body !!}
                    </div>

                    @if ($content->attachments->count() > 0)
                        <hr>
                        <h5><i class="fas fa-paperclip mr-2"></i>{{ __('contents.attachment.count', ['count' => $content->attachments->count()]) }}</h5>
                        <div class="row">
                            @foreach ($content->attachments as $attachment)
                                @php
                                    $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']);
                                    $isPdf = $ext == 'pdf';
                                @endphp
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card h-100 text-center">
                                        <div class="card-body">
                                            @if ($isImage)
                                                <i class="fas fa-image fa-4x text-primary mb-2"></i>
                                                <br>
                                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> {{ __('contents.attachment.view') }}
                                                </a>
                                            @elseif($isPdf)
                                                <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                                                <br>
                                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-eye"></i> {{ __('contents.attachment.view_pdf') }}
                                                </a>
                                            @else
                                                <i class="fas fa-file fa-4x text-secondary mb-2"></i>
                                                <br>
                                                <a href="{{ route('admin.contents.download', $attachment->id) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download"></i> {{ __('contents.attachment.download') }}
                                                </a>
                                            @endif
                                            <div class="mt-2 small text-truncate" title="{{ $attachment->file_name }}">
                                                {{ $attachment->file_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop