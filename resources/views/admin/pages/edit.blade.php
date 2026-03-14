@extends('adminlte::page')

@section('title', 'Edit Page')

@section('content_header')
    <h1>Edit Page</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.pages.update', $page->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="parent_id">Parent Page</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">-- No parent --</option>
                                @foreach($parentPages as $parent)
                                    @php
                                        $title = $parent->translations->first()->title ?? 'ID: '.$parent->id;
                                    @endphp
                                    <option value="{{ $parent->id }}" {{ $page->parent_id == $parent->id ? 'selected' : '' }}>
                                        {{ $title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="template">Template *</label>
                            <select name="template" id="template" class="form-control" required>
                                <option value="default" {{ $page->template == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="home" {{ $page->template == 'home' ? 'selected' : '' }}>Home</option>
                                <option value="contact" {{ $page->template == 'contact' ? 'selected' : '' }}>Contact</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="show_in_menu" id="show_in_menu" class="form-check-input" value="1" {{ $page->show_in_menu ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_in_menu">Show in menu</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_home" id="is_home" class="form-check-input" value="1" {{ $page->is_home ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_home">Set as homepage</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $page->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sort_order">Sort order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ $page->sort_order }}">
                        </div>
                    </div>
                </div>

                <hr>
                <h4>Translations</h4>
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
                        @php
                            $translation = $page->translations->where('language_id', $lang->id)->first();
                        @endphp
                        <div class="tab-pane {{ $loop->first ? 'show active' : '' }}" 
                             id="{{ $lang->code }}" 
                             role="tabpanel">

                            <div class="form-group">
                                <label>Title *</label>
                                <input type="text" 
                                       name="{{ $lang->code }}[title]" 
                                       class="form-control" 
                                       value="{{ old($lang->code . '.title', $translation->title ?? '') }}"
                                       {{ $loop->first ? 'required' : '' }}>
                            </div>

                            <div class="form-group">
                                <label>Menu Title</label>
                                <input type="text" 
                                       name="{{ $lang->code }}[menu_title]" 
                                       class="form-control" 
                                       value="{{ old($lang->code . '.menu_title', $translation->menu_title ?? '') }}">
                                <small class="text-muted">If empty, Title will be used</small>
                            </div>

                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" 
                                       name="{{ $lang->code }}[slug]" 
                                       class="form-control" 
                                       value="{{ old($lang->code . '.slug', $translation->slug ?? '') }}">
                                <small class="text-muted">If empty, it will be generated from Title</small>
                            </div>

                            <div class="form-group">
                                <label>Excerpt</label>
                                <textarea name="{{ $lang->code }}[excerpt]" 
                                          class="form-control" 
                                          rows="3">{{ old($lang->code . '.excerpt', $translation->excerpt ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="{{ $lang->code }}[content]" 
                                          class="form-control" 
                                          rows="6">{{ old($lang->code . '.content', $translation->content ?? '') }}</textarea>
                            </div>

                            <hr>
                            <h5>SEO</h5>

                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" 
                                       name="{{ $lang->code }}[meta_title]" 
                                       class="form-control" 
                                       value="{{ old($lang->code . '.meta_title', $translation->meta_title ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="{{ $lang->code }}[meta_description]" 
                                          class="form-control" 
                                          rows="2">{{ old($lang->code . '.meta_description', $translation->meta_description ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input type="text" 
                                       name="{{ $lang->code }}[meta_keywords]" 
                                       class="form-control" 
                                       value="{{ old($lang->code . '.meta_keywords', $translation->meta_keywords ?? '') }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Page
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    // Автоматично генериране на slug от title за първия език (ако е празен)
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