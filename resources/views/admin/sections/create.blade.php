@extends('adminlte::page')

@section('title', __('sections.title.create'))

@section('content_header')
    <h1>{{ __('sections.title.create') }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sections.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">{{ __('sections.label.type') }}</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">{{ __('sections.placeholder.select_type') }}</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">{{ __('sections.label.sort_order') }}</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                    <label class="form-check-label" for="is_active">{{ __('sections.label.active') }}</label>
                </div>

                <hr>
                <h4>{{ __('sections.header.translations') }}</h4>

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

                <div class="tab-content mt-3">
                    @foreach($languages as $lang)
                        <div class="tab-pane {{ $loop->first ? 'show active' : '' }}"
                             id="{{ $lang->code }}"
                             role="tabpanel"
                             aria-labelledby="{{ $lang->code }}-tab">

                            <div class="form-group">
                                <label>{{ __('sections.label.title') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[title]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.title') }}">
                            </div>

                            <div class="form-group">
                                <label>{{ __('sections.label.subtitle') }}</label>
                                <input type="text"
                                       name="{{ $lang->code }}[subtitle]"
                                       class="form-control"
                                       value="{{ old($lang->code . '.subtitle') }}">
                            </div>

                            {{-- Hero specific fields --}}
                            <div class="type-specific type-hero" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.hero.image') }}</label>
                                    <input type="file"
                                           name="{{ $lang->code }}[image]"
                                           class="form-control-file">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('sections.hero.button_text') }}</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_text]"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('sections.hero.button_url') }}</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_url]"
                                           class="form-control">
                                </div>
                            </div>

                            {{-- Features --}}
                            <div class="type-specific type-features" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.features.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.features.helper') }}</small>
                                    <div class="features-repeater">
                                        <table class="table table-bordered" id="features-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.features.table.icon') }}</th>
                                                    <th>{{ __('sections.features.table.title') }}</th>
                                                    <th>{{ __('sections.features.table.description') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                                <!-- rows will be added here -->
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-feature" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_feature') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Testimonials --}}
                            <div class="type-specific type-testimonials" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.testimonials.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.testimonials.helper') }}</small>
                                    <div class="testimonials-repeater">
                                        <table class="table table-bordered" id="testimonials-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.testimonials.table.author') }}</th>
                                                    <th>{{ __('sections.testimonials.table.text') }}</th>
                                                    <th>{{ __('sections.testimonials.table.image') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-testimonial" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_testimonial') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="type-specific type-cta" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.cta.button_text') }}</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_text]"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('sections.cta.button_url') }}</label>
                                    <input type="text"
                                           name="{{ $lang->code }}[button_url]"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('sections.cta.background_image') }}</label>
                                    <input type="file"
                                           name="{{ $lang->code }}[image]"
                                           class="form-control-file">
                                </div>
                            </div>

                            {{-- Text Block --}}
                            <div class="type-specific type-text" style="display:none;"></div>

                            {{-- How It Works --}}
                            <div class="type-specific type-how-it-works" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.how_it_works.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.how_it_works.helper') }}</small>
                                    <div class="steps-repeater">
                                        <table class="table table-bordered" id="steps-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.how_it_works.table.title') }}</th>
                                                    <th>{{ __('sections.how_it_works.table.description') }}</th>
                                                    <th>{{ __('sections.how_it_works.table.icon') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-step" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_step') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Team --}}
                            <div class="type-specific type-team" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.team.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.team.helper') }}</small>
                                    <div class="team-repeater">
                                        <table class="table table-bordered" id="team-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.team.table.name') }}</th>
                                                    <th>{{ __('sections.team.table.position') }}</th>
                                                    <th>{{ __('sections.team.table.bio') }}</th>
                                                    <th>{{ __('sections.team.table.photo') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-team" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_member') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- FAQ --}}
                            <div class="type-specific type-faq" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.faq.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.faq.helper') }}</small>
                                    <div class="faq-repeater">
                                        <table class="table table-bordered" id="faq-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.faq.table.question') }}</th>
                                                    <th>{{ __('sections.faq.table.answer') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-faq" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_faq') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Portfolio / Gallery --}}
                            <div class="type-specific type-portfolio" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.portfolio.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.portfolio.helper') }}</small>
                                    <div class="portfolio-repeater">
                                        <table class="table table-bordered" id="portfolio-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.portfolio.table.title') }}</th>
                                                    <th>{{ __('sections.portfolio.table.description') }}</th>
                                                    <th>{{ __('sections.portfolio.table.link') }}</th>
                                                    <th>{{ __('sections.portfolio.table.image') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-portfolio" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_item') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Pricing --}}
                            <div class="type-specific type-pricing" style="display:none;">
                                <div class="form-group">
                                    <label>{{ __('sections.pricing.label') }}</label>
                                    <small class="text-muted d-block mb-2">{{ __('sections.pricing.helper') }}</small>
                                    <div class="pricing-repeater">
                                        <table class="table table-bordered" id="pricing-table-{{ $lang->code }}">
                                            <thead>
                                                 <tr>
                                                    <th>{{ __('sections.pricing.table.plan_name') }}</th>
                                                    <th>{{ __('sections.pricing.table.price') }}</th>
                                                    <th>{{ __('sections.pricing.table.features') }}</th>
                                                    <th>{{ __('sections.pricing.table.button_text') }}</th>
                                                    <th>{{ __('sections.pricing.table.button_url') }}</th>
                                                    <th width="50"></th>
                                                 </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-pricing" data-lang="{{ $lang->code }}">
                                            <i class="fas fa-plus"></i> {{ __('sections.button.add_plan') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ __('sections.button.create') }}
                </button>
                <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">{{ __('sections.button.cancel') }}</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Show specific fields based on selected type
        $('#type').on('change', function() {
            var selectedType = $(this).val();
            $('.type-specific').hide();
            if (selectedType) {
                $('.type-' + selectedType).show();
            }
        }).trigger('change');

        // Functions for adding rows
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

        $('.add-feature').click(function() { addFeatureRow($(this).data('lang')); });
        $('.add-testimonial').click(function() { addTestimonialRow($(this).data('lang')); });
        $('.add-step').click(function() { addStepRow($(this).data('lang')); });
        $('.add-team').click(function() { addTeamRow($(this).data('lang')); });
        $('.add-faq').click(function() { addFaqRow($(this).data('lang')); });
        $('.add-portfolio').click(function() { addPortfolioRow($(this).data('lang')); });
        $('.add-pricing').click(function() { addPricingRow($(this).data('lang')); });

        $(document).on('click', '.remove-row', function() { $(this).closest('tr').remove(); });
    });
</script>
@stop