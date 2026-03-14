@extends('adminlte::page')

@section('title', 'Edit Section')

@section('content_header')
    <h1>Edit Section</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sections.update', $section->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Основен тип на секцията -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Section Type *</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select type</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}" {{ $section->type == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ $section->sort_order }}">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $section->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <hr>
                <h4>Translations</h4>

                <!-- Language tabs -->
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach($languages as $lang)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                               id="{{ $lang->code }}-tab"
                               data-toggle="tab"
                               href="#{{ $lang->code }}"
                               role="tab"
                               aria-controls="{{ $lang->code }}"
                               aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ strtoupper($lang->code) }} - {{ $lang->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab content -->
                <div class="tab-content mt-3">
                    @foreach($languages as $lang)
                        @php
                            $translation = $section->translations->where('language_id', $lang->id)->first();
                            $title = $translation->title ?? '';
                            $subtitle = $translation->subtitle ?? '';
                            $data = $translation->data ?? [];
                        @endphp
                        <div class="tab-pane {{ $loop->first ? 'show active' : '' }}"
                             id="{{ $lang->code }}"
                             role="tabpanel"
                             aria-labelledby="{{ $lang->code }}-tab">

                            <!-- Общи полета (title, subtitle) -->
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                       name="{{ $lang->code }}[title]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.title', $title) }}">
                            </div>

                            <div class="form-group">
                                <label>Subtitle</label>
                                <input type="text"
                                       name="{{ $lang->code }}[subtitle]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.subtitle', $subtitle) }}">
                            </div>

                            <!-- Hero -->
                            <div class="type-specific type-hero" style="display:none;">
                                <div class="form-group">
                                    <label>Hero Image</label>
                                    @if(isset($data['image']))
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($data['image']) }}" style="max-width:200px; max-height:150px;" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <input type="file"
                                           name="{{ $lang->code }}[image]"
                                           class="form-control-file">
                                </div>
                                <div class="form-group">
                                    <label>Button Text</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_text]"
                                           class="form-control"
                                           value="{{ old($lang->code . '.button_text', $data['button_text'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Button URL</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_url]"
                                           class="form-control"
                                           value="{{ old($lang->code . '.button_url', $data['button_url'] ?? '') }}">
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="type-specific type-features" style="display:none;">
                                <div class="form-group">
                                    <label>Features</label>
                                    <small class="text-muted d-block mb-2">Add features with icon, title and description.</small>
                                    <div class="features-repeater">
                                        <table class="table table-bordered" id="features-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Icon (FontAwesome class)</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['features']) && is_array($data['features']))
                                                    @foreach($data['features'] as $index => $feature)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[features][{{ $index }}][icon]" class="form-control" value="{{ $feature['icon'] ?? '' }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[features][{{ $index }}][title]" class="form-control" value="{{ $feature['title'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[features][{{ $index }}][description]" class="form-control">{{ $feature['description'] ?? '' }}</textarea></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-feature" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Feature
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimonials -->
                            <div class="type-specific type-testimonials" style="display:none;">
                                <div class="form-group">
                                    <label>Testimonials</label>
                                    <small class="text-muted d-block mb-2">Add testimonials with author name, text and optional image.</small>
                                    <div class="testimonials-repeater">
                                        <table class="table table-bordered" id="testimonials-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Author</th>
                                                    <th>Text</th>
                                                    <th>Image</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['testimonials']) && is_array($data['testimonials']))
                                                    @foreach($data['testimonials'] as $index => $testimonial)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[testimonials][{{ $index }}][author]" class="form-control" value="{{ $testimonial['author'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[testimonials][{{ $index }}][text]" class="form-control">{{ $testimonial['text'] ?? '' }}</textarea></td>
                                                            <td>
                                                                @if(isset($testimonial['image']))
                                                                    <div class="mb-1">
                                                                        <img src="{{ Storage::url($testimonial['image']) }}" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="{{ $lang->code }}[testimonials][{{ $index }}][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-testimonial" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Testimonial
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA -->
                            <div class="type-specific type-cta" style="display:none;">
                                <div class="form-group">
                                    <label>Button Text</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_text]"
                                           class="form-control"
                                           value="{{ old($lang->code . '.button_text', $data['button_text'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Button URL</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_url]"
                                           class="form-control"
                                           value="{{ old($lang->code . '.button_url', $data['button_url'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Background Image (optional)</label>
                                    @if(isset($data['image']))
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($data['image']) }}" style="max-width:200px; max-height:150px;" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <input type="file"
                                           name="{{ $lang->code }}[image]"
                                           class="form-control-file">
                                </div>
                            </div>

                            <!-- Text Block -->
                            <div class="type-specific type-text" style="display:none;">
                                <!-- nothing extra -->
                            </div>

                            <!-- How It Works -->
                            <div class="type-specific type-how-it-works" style="display:none;">
                                <div class="form-group">
                                    <label>Steps</label>
                                    <small class="text-muted d-block mb-2">Add steps with title, description and optional icon.</small>
                                    <div class="steps-repeater">
                                        <table class="table table-bordered" id="steps-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Icon</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['steps']) && is_array($data['steps']))
                                                    @foreach($data['steps'] as $index => $step)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[steps][{{ $index }}][title]" class="form-control" value="{{ $step['title'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[steps][{{ $index }}][description]" class="form-control">{{ $step['description'] ?? '' }}</textarea></td>
                                                            <td><input type="text" name="{{ $lang->code }}[steps][{{ $index }}][icon]" class="form-control" value="{{ $step['icon'] ?? '' }}"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-step" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Step
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Team -->
                            <div class="type-specific type-team" style="display:none;">
                                <div class="form-group">
                                    <label>Team Members</label>
                                    <small class="text-muted d-block mb-2">Add team members with name, position, bio and photo.</small>
                                    <div class="team-repeater">
                                        <table class="table table-bordered" id="team-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Bio</th>
                                                    <th>Photo</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['members']) && is_array($data['members']))
                                                    @foreach($data['members'] as $index => $member)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[members][{{ $index }}][name]" class="form-control" value="{{ $member['name'] ?? '' }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[members][{{ $index }}][position]" class="form-control" value="{{ $member['position'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[members][{{ $index }}][bio]" class="form-control">{{ $member['bio'] ?? '' }}</textarea></td>
                                                            <td>
                                                                @if(isset($member['image']))
                                                                    <div class="mb-1">
                                                                        <img src="{{ Storage::url($member['image']) }}" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="{{ $lang->code }}[members][{{ $index }}][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-team" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Member
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ -->
                            <div class="type-specific type-faq" style="display:none;">
                                <div class="form-group">
                                    <label>FAQ Items</label>
                                    <small class="text-muted d-block mb-2">Add questions and answers.</small>
                                    <div class="faq-repeater">
                                        <table class="table table-bordered" id="faq-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['faq_items']) && is_array($data['faq_items']))
                                                    @foreach($data['faq_items'] as $index => $item)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[faq_items][{{ $index }}][question]" class="form-control" value="{{ $item['question'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[faq_items][{{ $index }}][answer]" class="form-control">{{ $item['answer'] ?? '' }}</textarea></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-faq" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add FAQ
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Portfolio / Gallery -->
                            <div class="type-specific type-portfolio" style="display:none;">
                                <div class="form-group">
                                    <label>Portfolio Items</label>
                                    <small class="text-muted d-block mb-2">Add portfolio items with title, description, link and image.</small>
                                    <div class="portfolio-repeater">
                                        <table class="table table-bordered" id="portfolio-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Link</th>
                                                    <th>Image</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['items']) && is_array($data['items']))
                                                    @foreach($data['items'] as $index => $item)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[items][{{ $index }}][title]" class="form-control" value="{{ $item['title'] ?? '' }}"></td>
                                                            <td><textarea name="{{ $lang->code }}[items][{{ $index }}][description]" class="form-control">{{ $item['description'] ?? '' }}</textarea></td>
                                                            <td><input type="text" name="{{ $lang->code }}[items][{{ $index }}][link]" class="form-control" value="{{ $item['link'] ?? '' }}"></td>
                                                            <td>
                                                                @if(isset($item['image']))
                                                                    <div class="mb-1">
                                                                        <img src="{{ Storage::url($item['image']) }}" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="{{ $lang->code }}[items][{{ $index }}][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-portfolio" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="type-specific type-pricing" style="display:none;">
                                <div class="form-group">
                                    <label>Pricing Plans</label>
                                    <small class="text-muted d-block mb-2">Add pricing plans with name, price, features list (comma separated) and button.</small>
                                    <div class="pricing-repeater">
                                        <table class="table table-bordered" id="pricing-table-{{ $lang->code }}">
                                            <thead>
                                                <tr>
                                                    <th>Plan Name</th>
                                                    <th>Price</th>
                                                    <th>Features (comma separated)</th>
                                                    <th>Button Text</th>
                                                    <th>Button URL</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['plans']) && is_array($data['plans']))
                                                    @foreach($data['plans'] as $index => $plan)
                                                        <tr>
                                                            <td><input type="text" name="{{ $lang->code }}[plans][{{ $index }}][name]" class="form-control" value="{{ $plan['name'] ?? '' }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[plans][{{ $index }}][price]" class="form-control" value="{{ $plan['price'] ?? '' }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[plans][{{ $index }}][features]" class="form-control" value="{{ is_array($plan['features'] ?? null) ? implode(', ', $plan['features']) : ($plan['features'] ?? '') }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[plans][{{ $index }}][button_text]" class="form-control" value="{{ $plan['button_text'] ?? '' }}"></td>
                                                            <td><input type="text" name="{{ $lang->code }}[plans][{{ $index }}][button_url]" class="form-control" value="{{ $plan['button_url'] ?? '' }}"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-pricing" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> Add Plan
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <hr>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Section
                </button>
                <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Показване на специфичните полета според избрания тип
        $('#type').on('change', function() {
            var selectedType = $(this).val();
            $('.type-specific').hide();
            if (selectedType) {
                $('.type-' + selectedType).show();
            }
        }).trigger('change');

        // Функции за добавяне на редове (същите като в create.blade.php)
        function addFeatureRow(lang) {
            var index = $('#features-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[features][${index}][icon]" class="form-control" placeholder="e.g., brain"></td>
                    <td><input type="text" name="${lang}[features][${index}][title]" class="form-control"></td>
                    <td><textarea name="${lang}[features][${index}][description]" class="form-control"></textarea></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#features-table-' + lang + ' tbody').append(row);
        }

        function addTestimonialRow(lang) {
            var index = $('#testimonials-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[testimonials][${index}][author]" class="form-control"></td>
                    <td><textarea name="${lang}[testimonials][${index}][text]" class="form-control"></textarea></td>
                    <td><input type="file" name="${lang}[testimonials][${index}][image]" class="form-control-file"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#testimonials-table-' + lang + ' tbody').append(row);
        }

        function addStepRow(lang) {
            var index = $('#steps-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[steps][${index}][title]" class="form-control"></td>
                    <td><textarea name="${lang}[steps][${index}][description]" class="form-control"></textarea></td>
                    <td><input type="text" name="${lang}[steps][${index}][icon]" class="form-control" placeholder="e.g., arrow-right"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#steps-table-' + lang + ' tbody').append(row);
        }

        function addTeamRow(lang) {
            var index = $('#team-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[members][${index}][name]" class="form-control"></td>
                    <td><input type="text" name="${lang}[members][${index}][position]" class="form-control"></td>
                    <td><textarea name="${lang}[members][${index}][bio]" class="form-control"></textarea></td>
                    <td><input type="file" name="${lang}[members][${index}][image]" class="form-control-file"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#team-table-' + lang + ' tbody').append(row);
        }

        function addFaqRow(lang) {
            var index = $('#faq-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[faq_items][${index}][question]" class="form-control"></td>
                    <td><textarea name="${lang}[faq_items][${index}][answer]" class="form-control"></textarea></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#faq-table-' + lang + ' tbody').append(row);
        }

        function addPortfolioRow(lang) {
            var index = $('#portfolio-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[items][${index}][title]" class="form-control"></td>
                    <td><textarea name="${lang}[items][${index}][description]" class="form-control"></textarea></td>
                    <td><input type="text" name="${lang}[items][${index}][link]" class="form-control"></td>
                    <td><input type="file" name="${lang}[items][${index}][image]" class="form-control-file"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#portfolio-table-' + lang + ' tbody').append(row);
        }

        function addPricingRow(lang) {
            var index = $('#pricing-table-' + lang + ' tbody tr').length;
            var row = `
                <tr>
                    <td><input type="text" name="${lang}[plans][${index}][name]" class="form-control"></td>
                    <td><input type="text" name="${lang}[plans][${index}][price]" class="form-control" placeholder="e.g., $19/month"></td>
                    <td><input type="text" name="${lang}[plans][${index}][features]" class="form-control" placeholder="Feature1, Feature2, ..."></td>
                    <td><input type="text" name="${lang}[plans][${index}][button_text]" class="form-control"></td>
                    <td><input type="text" name="${lang}[plans][${index}][button_url]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            $('#pricing-table-' + lang + ' tbody').append(row);
        }

        // Свързване на бутоните за добавяне
        $('.add-feature').click(function() {
            addFeatureRow($(this).data('lang'));
        });
        $('.add-testimonial').click(function() {
            addTestimonialRow($(this).data('lang'));
        });
        $('.add-step').click(function() {
            addStepRow($(this).data('lang'));
        });
        $('.add-team').click(function() {
            addTeamRow($(this).data('lang'));
        });
        $('.add-faq').click(function() {
            addFaqRow($(this).data('lang'));
        });
        $('.add-portfolio').click(function() {
            addPortfolioRow($(this).data('lang'));
        });
        $('.add-pricing').click(function() {
            addPricingRow($(this).data('lang'));
        });

        // Изтриване на ред
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@stop