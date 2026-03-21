@extends('adminlte::page')

@section('title', __('contents.edit'))

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content_header')
    <h1>{{ __('contents.edit') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contents.update', $content->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="type">{{ __('contents.label.type') }}</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                @foreach ($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $content->type) == $value ? 'selected' : '' }}>
                                        {{ __('contents.type.' . $value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">{{ __('contents.label.title') }}</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $content->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">{{ __('contents.label.excerpt') }}</label>
                            <textarea name="excerpt" id="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $content->excerpt) }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body">{{ __('contents.label.body') }}</label>
                            <textarea name="body" id="body" rows="10" class="form-control @error('body') is-invalid @enderror">{{ old('body', $content->body) }}</textarea>
                            @error('body')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="published_at">{{ __('contents.label.published_at') }}</label>
                            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $content->published_at->format('Y-m-d\TH:i')) }}">
                        </div>

                        @if ($content->attachments->count() > 0)
                            <div class="form-group">
                                <label>{{ __('contents.attachment.current') }}</label>
                                <ul class="list-group">
                                    @foreach ($content->attachments as $attachment)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a>
                                            <button type="button" class="btn btn-danger btn-sm delete-attachment" data-id="{{ $attachment->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="attachments">{{ __('contents.attachment.add_new') }}</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control-file" multiple>
                        </div>

                        <div class="form-group">
                            <label>{{ __('contents.label.share_with') }}</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{ __('contents.label.share_view') }}</label>
                                    <div style="max-height:300px; overflow-y:auto; border:1px solid #ddd; padding:10px; border-radius:5px;">
                                        @foreach ($users as $user)
                                            @if ($user->id != Auth::id())
                                                <div class="form-check">
                                                    <input type="checkbox" name="share_view[]" value="{{ $user->id }}" id="view_{{ $user->id }}" class="form-check-input"
                                                        {{ in_array($user->id, $sharedView ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="view_{{ $user->id }}">{{ $user->name }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                <div class="col-md-6">
                                    <label>{{ __('contents.label.share_edit') }}</label>
                                    <div style="max-height:300px; overflow-y:auto; border:1px solid #ddd; padding:10px; border-radius:5px;">
                                        @foreach ($users as $user)
                                            @if ($user->id != Auth::id())
                                                <div class="form-check">
                                                    <input type="checkbox" name="share_edit[]" value="{{ $user->id }}" id="edit_{{ $user->id }}" class="form-check-input"
                                                        {{ in_array($user->id, $sharedEdit ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="edit_{{ $user->id }}">{{ $user->name }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">{!! nl2br(e(__('contents.helper.share'))) !!}</small>
                        </div>

                        <div class="form-group">
                            <label>{{ __('contents.label.tags') }}</label>
                            <select name="tags[]" class="form-control select2" multiple style="width:100%;">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('contents.button.update') }}</button>
                        <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">{{ __('contents.button.back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        ClassicEditor
            .create(document.querySelector('#body'), {
                height: 600
            })
            .catch(error => {
                console.error(error);
            });

        $('.delete-attachment').on('click', function() {
            if (!confirm('{{ __('contents.messages.delete_attachment_confirm') }}')) return;
            let id = $(this).data('id');
            let row = $(this).closest('li');
            $.ajax({
                url: `/admin/contents/attachments/${id}`,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    row.fadeOut();
                },
                error: function(xhr) {
                    alert('{{ __('contents.messages.delete_error', ['error' => '']) }} ' + xhr.responseJSON.error);
                }
            });
        });
    </script>
@stop