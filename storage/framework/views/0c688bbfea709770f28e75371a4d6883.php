

<?php $__env->startSection('title', 'Edit Section'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit Section</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.sections.update', $section->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Основен тип на секцията -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Section Type *</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select type</option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php echo e($section->type == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e($section->sort_order); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?php echo e($section->is_active ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <hr>
                <h4>Translations</h4>

                <!-- Language tabs -->
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>"
                               id="<?php echo e($lang->code); ?>-tab"
                               data-toggle="tab"
                               href="#<?php echo e($lang->code); ?>"
                               role="tab"
                               aria-controls="<?php echo e($lang->code); ?>"
                               aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                <?php echo e(strtoupper($lang->code)); ?> - <?php echo e($lang->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <!-- Tab content -->
                <div class="tab-content mt-3">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $translation = $section->translations->where('language_id', $lang->id)->first();
                            $title = $translation->title ?? '';
                            $subtitle = $translation->subtitle ?? '';
                            $data = $translation->data ?? [];
                        ?>
                        <div class="tab-pane <?php echo e($loop->first ? 'show active' : ''); ?>"
                             id="<?php echo e($lang->code); ?>"
                             role="tabpanel"
                             aria-labelledby="<?php echo e($lang->code); ?>-tab">

                            <!-- Общи полета (title, subtitle) -->
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                       name="<?php echo e($lang->code); ?>[title]"
                                       class="form-control"
                                       value="<?php echo e(old($lang->code . '.title', $title)); ?>">
                            </div>

                            <div class="form-group">
                                <label>Subtitle</label>
                                <input type="text"
                                       name="<?php echo e($lang->code); ?>[subtitle]"
                                       class="form-control"
                                       value="<?php echo e(old($lang->code . '.subtitle', $subtitle)); ?>">
                            </div>

                            <!-- Hero -->
                            <div class="type-specific type-hero" style="display:none;">
                                <div class="form-group">
                                    <label>Hero Image</label>
                                    <?php if(isset($data['image'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(Storage::url($data['image'])); ?>" style="max-width:200px; max-height:150px;" class="img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file"
                                           name="<?php echo e($lang->code); ?>[image]"
                                           class="form-control-file">
                                </div>
                                <div class="form-group">
                                    <label>Button Text</label>
                                    <input type="text"
                                           name="<?php echo e($lang->code); ?>[button_text]"
                                           class="form-control"
                                           value="<?php echo e(old($lang->code . '.button_text', $data['button_text'] ?? '')); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Button URL</label>
                                    <input type="text"
                                           name="<?php echo e($lang->code); ?>[button_url]"
                                           class="form-control"
                                           value="<?php echo e(old($lang->code . '.button_url', $data['button_url'] ?? '')); ?>">
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="type-specific type-features" style="display:none;">
                                <div class="form-group">
                                    <label>Features</label>
                                    <small class="text-muted d-block mb-2">Add features with icon, title and description.</small>
                                    <div class="features-repeater">
                                        <table class="table table-bordered" id="features-table-<?php echo e($lang->code); ?>">
                                            <thead>
                                                <tr>
                                                    <th>Icon (FontAwesome class)</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($data['features']) && is_array($data['features'])): ?>
                                                    <?php $__currentLoopData = $data['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[features][<?php echo e($index); ?>][icon]" class="form-control" value="<?php echo e($feature['icon'] ?? ''); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[features][<?php echo e($index); ?>][title]" class="form-control" value="<?php echo e($feature['title'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[features][<?php echo e($index); ?>][description]" class="form-control"><?php echo e($feature['description'] ?? ''); ?></textarea></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-feature" data-lang="<?php echo e($lang->code); ?>">
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
                                        <table class="table table-bordered" id="testimonials-table-<?php echo e($lang->code); ?>">
                                            <thead>
                                                <tr>
                                                    <th>Author</th>
                                                    <th>Text</th>
                                                    <th>Image</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($data['testimonials']) && is_array($data['testimonials'])): ?>
                                                    <?php $__currentLoopData = $data['testimonials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[testimonials][<?php echo e($index); ?>][author]" class="form-control" value="<?php echo e($testimonial['author'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[testimonials][<?php echo e($index); ?>][text]" class="form-control"><?php echo e($testimonial['text'] ?? ''); ?></textarea></td>
                                                            <td>
                                                                <?php if(isset($testimonial['image'])): ?>
                                                                    <div class="mb-1">
                                                                        <img src="<?php echo e(Storage::url($testimonial['image'])); ?>" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <input type="file" name="<?php echo e($lang->code); ?>[testimonials][<?php echo e($index); ?>][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-testimonial" data-lang="<?php echo e($lang->code); ?>">
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
                                           name="<?php echo e($lang->code); ?>[button_text]"
                                           class="form-control"
                                           value="<?php echo e(old($lang->code . '.button_text', $data['button_text'] ?? '')); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Button URL</label>
                                    <input type="text"
                                           name="<?php echo e($lang->code); ?>[button_url]"
                                           class="form-control"
                                           value="<?php echo e(old($lang->code . '.button_url', $data['button_url'] ?? '')); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Background Image (optional)</label>
                                    <?php if(isset($data['image'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(Storage::url($data['image'])); ?>" style="max-width:200px; max-height:150px;" class="img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file"
                                           name="<?php echo e($lang->code); ?>[image]"
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
                                        <table class="table table-bordered" id="steps-table-<?php echo e($lang->code); ?>">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Icon</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($data['steps']) && is_array($data['steps'])): ?>
                                                    <?php $__currentLoopData = $data['steps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[steps][<?php echo e($index); ?>][title]" class="form-control" value="<?php echo e($step['title'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[steps][<?php echo e($index); ?>][description]" class="form-control"><?php echo e($step['description'] ?? ''); ?></textarea></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[steps][<?php echo e($index); ?>][icon]" class="form-control" value="<?php echo e($step['icon'] ?? ''); ?>"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-step" data-lang="<?php echo e($lang->code); ?>">
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
                                        <table class="table table-bordered" id="team-table-<?php echo e($lang->code); ?>">
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
                                                <?php if(isset($data['members']) && is_array($data['members'])): ?>
                                                    <?php $__currentLoopData = $data['members']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[members][<?php echo e($index); ?>][name]" class="form-control" value="<?php echo e($member['name'] ?? ''); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[members][<?php echo e($index); ?>][position]" class="form-control" value="<?php echo e($member['position'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[members][<?php echo e($index); ?>][bio]" class="form-control"><?php echo e($member['bio'] ?? ''); ?></textarea></td>
                                                            <td>
                                                                <?php if(isset($member['image'])): ?>
                                                                    <div class="mb-1">
                                                                        <img src="<?php echo e(Storage::url($member['image'])); ?>" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <input type="file" name="<?php echo e($lang->code); ?>[members][<?php echo e($index); ?>][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-team" data-lang="<?php echo e($lang->code); ?>">
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
                                        <table class="table table-bordered" id="faq-table-<?php echo e($lang->code); ?>">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th width="50"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($data['faq_items']) && is_array($data['faq_items'])): ?>
                                                    <?php $__currentLoopData = $data['faq_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[faq_items][<?php echo e($index); ?>][question]" class="form-control" value="<?php echo e($item['question'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[faq_items][<?php echo e($index); ?>][answer]" class="form-control"><?php echo e($item['answer'] ?? ''); ?></textarea></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-faq" data-lang="<?php echo e($lang->code); ?>">
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
                                        <table class="table table-bordered" id="portfolio-table-<?php echo e($lang->code); ?>">
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
                                                <?php if(isset($data['items']) && is_array($data['items'])): ?>
                                                    <?php $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[items][<?php echo e($index); ?>][title]" class="form-control" value="<?php echo e($item['title'] ?? ''); ?>"></td>
                                                            <td><textarea name="<?php echo e($lang->code); ?>[items][<?php echo e($index); ?>][description]" class="form-control"><?php echo e($item['description'] ?? ''); ?></textarea></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[items][<?php echo e($index); ?>][link]" class="form-control" value="<?php echo e($item['link'] ?? ''); ?>"></td>
                                                            <td>
                                                                <?php if(isset($item['image'])): ?>
                                                                    <div class="mb-1">
                                                                        <img src="<?php echo e(Storage::url($item['image'])); ?>" style="max-width:100px; max-height:60px;">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <input type="file" name="<?php echo e($lang->code); ?>[items][<?php echo e($index); ?>][image]" class="form-control-file">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-portfolio" data-lang="<?php echo e($lang->code); ?>">
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
                                        <table class="table table-bordered" id="pricing-table-<?php echo e($lang->code); ?>">
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
                                                <?php if(isset($data['plans']) && is_array($data['plans'])): ?>
                                                    <?php $__currentLoopData = $data['plans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[plans][<?php echo e($index); ?>][name]" class="form-control" value="<?php echo e($plan['name'] ?? ''); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[plans][<?php echo e($index); ?>][price]" class="form-control" value="<?php echo e($plan['price'] ?? ''); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[plans][<?php echo e($index); ?>][features]" class="form-control" value="<?php echo e(is_array($plan['features'] ?? null) ? implode(', ', $plan['features']) : ($plan['features'] ?? '')); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[plans][<?php echo e($index); ?>][button_text]" class="form-control" value="<?php echo e($plan['button_text'] ?? ''); ?>"></td>
                                                            <td><input type="text" name="<?php echo e($lang->code); ?>[plans][<?php echo e($index); ?>][button_url]" class="form-control" value="<?php echo e($plan['button_url'] ?? ''); ?>"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-success add-pricing" data-lang="<?php echo e($lang->code); ?>">
                                            <i class="fas fa-plus"></i> Add Plan
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <hr>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Section
                </button>
                <a href="<?php echo e(route('admin.sections.index')); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/sections/edit.blade.php ENDPATH**/ ?>