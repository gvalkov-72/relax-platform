@extends('adminlte::page')

@section('title', __('pages.title.create'))

@section('content_header')
    <h1>{{ __('pages.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.pages.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="parent_id">{{ __('pages.label.parent_page') }}</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{{ __('pages.label.no_parent') }}</option>
                                @foreach($parentPages as $parent)
                                    @php
                                        $title = $parent->translations->first()->title ?? 'ID: '.$parent->id;
                                    @endphp
                                    <option value="{{ $parent->id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="template">{{ __('pages.label.template') }}</label>
                            <select name="template" id="template" class="form-control" required>
                                <option value="default">{{ __('pages.template.default') }}</option>
                                <option value="home">{{ __('pages.template.home') }}</option>
                                <option value="contact">{{ __('pages.template.contact') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="show_in_menu" id="show_in_menu" class="form-check-input" value="1" checked>
                                <label class="form-check-label" for="show_in_menu">{{ __('pages.label.show_in_menu') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_home" id="is_home" class="form-check-input" value="1">
                                <label class="form-check-label" for="is_home">{{ __('pages.label.is_home') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                                <label class="form-check-label" for="is_active">{{ __('pages.label.is_active') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sort_order">{{ __('pages.label.sort_order') }}</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                </div>

                <hr>
                <h4>{{ __('pages.title.create') }} - {{ __('pages.title.translations') ?? 'Translations' }}</h4>
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach($languages as $lang)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                               id="{{ $lang->code }}-tab"
                               data-toggle="tab"
                               href="#{{ $lang->code }}"
                               role="tab">
                                {{ strtoupper($lang->code) }} - {{ $lang->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3">
                    @foreach($languages as $lang)
                        <div class="tab-pane {{ $loop->first ? 'show active' : '' }}"
                             id="{{ $lang->code }}"
                             role="tabpanel">

                            <div class="form-group">
                                <label>{{ __('pages.label.title') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[title]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.title') }}"
                                       {{ $loop->first ? 'required' : '' }}>
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.menu_title') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[menu_title]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.menu_title') }}">
                                <small class="text-muted">{{ __('pages.helper.menu_title_helper') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.slug') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[slug]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.slug') }}">
                                <small class="text-muted">{{ __('pages.helper.slug_generation') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.excerpt') }}</label>
                                <textarea name="{{ $lang->code }}[excerpt]"
                                          class="form-control"
                                          rows="3">{{ old($lang->code . '.excerpt') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.content') }}</label>
                                <textarea name="{{ $lang->code }}[content]"
                                          class="form-control"
                                          rows="6">{{ old($lang->code . '.content') }}</textarea>
                            </div>

                            <hr>
                            <h5>SEO</h5>

                            <div class="form-group">
                                <label>{{ __('pages.label.meta_title') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[meta_title]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.meta_title') }}">
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.meta_description') }}</label>
                                <textarea name="{{ $lang->code }}[meta_description]"
                                          class="form-control"
                                          rows="2">{{ old($lang->code . '.meta_description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>{{ __('pages.label.meta_keywords') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[meta_keywords]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.meta_keywords') }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('pages.button.save') }}
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">{{ __('pages.button.cancel') }}</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.querySelector('input[name="bg[title]"]');
        const slugInput = document.querySelector('input[name="bg[slug]"]');
        if (titleInput && slugInput) {
            titleInput.addEventListener('blur', function() {
                if (slugInput.value === '') {
                    slugInput.value = titleInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                }
            });
        }
    });
</script>
@stop