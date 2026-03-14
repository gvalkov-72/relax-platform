

<?php $__env->startSection('content'); ?>
    <?php
        $sections = \App\Models\Section::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    ?>

    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $translation = $section->translations
                ->where('language_id', $currentLanguage->id)
                ->first();

            if (!$translation) continue;

            $title = $translation->title ?? '';
            $subtitle = $translation->subtitle ?? '';
            $data = $translation->data ?? [];
        ?>

        
        <?php if($section->type == 'hero'): ?>
            <section class="hero-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="display-4"><?php echo e($title); ?></h1>
                            <p class="lead"><?php echo e($subtitle); ?></p>
                            <?php if(!empty($data['button_text']) && !empty($data['button_url'])): ?>
                                <a href="<?php echo e($data['button_url']); ?>" class="btn btn-primary btn-lg">
                                    <?php echo e($data['button_text']); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty($data['image'])): ?>
                            <div class="col-md-6">
                                <img src="<?php echo e(Storage::url($data['image'])); ?>" alt="<?php echo e($title); ?>" class="img-fluid rounded">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'features'): ?>
            <section class="features-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 text-center">
                                    <div class="card-body">
                                        <?php if(!empty($feature['icon'])): ?>
                                            <i class="fas fa-<?php echo e($feature['icon']); ?> fa-3x mb-3 text-primary"></i>
                                        <?php endif; ?>
                                        <h5><?php echo e($feature['title'] ?? ''); ?></h5>
                                        <p><?php echo e($feature['description'] ?? ''); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'testimonials'): ?>
            <section class="testimonials-section py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['testimonials'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <?php if(!empty($testimonial['image'])): ?>
                                            <img src="<?php echo e(Storage::url($testimonial['image'])); ?>"
                                                 alt="<?php echo e($testimonial['author'] ?? ''); ?>"
                                                 class="rounded-circle mb-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <?php endif; ?>
                                        <p class="card-text">"<?php echo e($testimonial['text'] ?? ''); ?>"</p>
                                        <footer class="blockquote-footer"><?php echo e($testimonial['author'] ?? ''); ?></footer>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'cta'): ?>
            <section class="cta-section py-5 text-white"
                     style="background: <?php echo e($data['background_color'] ?? '#007bff'); ?>; <?php echo e(!empty($data['image']) ? 'background-image: url(' . Storage::url($data['image']) . '); background-size: cover; background-position: center;' : ''); ?>">
                <div class="container text-center">
                    <h2 class="display-5"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="lead"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <?php if(!empty($data['button_text']) && !empty($data['button_url'])): ?>
                        <a href="<?php echo e($data['button_url']); ?>" class="btn btn-light btn-lg mt-3">
                            <?php echo e($data['button_text']); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </section>

        
        <?php elseif($section->type == 'text'): ?>
            <section class="text-section py-5">
                <div class="container">
                    <h2><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="lead"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="content">
                        <?php echo nl2br(e($data['content'] ?? '')); ?>

                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'how-it-works'): ?>
            <section class="how-it-works-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['steps'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4 text-center">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width: 50px; height: 50px;">
                                    <?php echo e($index + 1); ?>

                                </div>
                                <h5><?php echo e($step['title'] ?? ''); ?></h5>
                                <p><?php echo e($step['description'] ?? ''); ?></p>
                                <?php if(!empty($step['icon'])): ?>
                                    <i class="fas fa-<?php echo e($step['icon']); ?> fa-2x text-primary"></i>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'team'): ?>
            <section class="team-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['members'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4 text-center">
                                <?php if(!empty($member['image'])): ?>
                                    <img src="<?php echo e(Storage::url($member['image'])); ?>"
                                         alt="<?php echo e($member['name'] ?? ''); ?>"
                                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                <?php endif; ?>
                                <h5><?php echo e($member['name'] ?? ''); ?></h5>
                                <p class="text-muted"><?php echo e($member['position'] ?? ''); ?></p>
                                <p><?php echo e($member['bio'] ?? ''); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'faq'): ?>
            <section class="faq-section py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="accordion" id="faqAccordion">
                        <?php $__currentLoopData = $data['faq_items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2">
                                <div class="card-header" id="heading<?php echo e($index); ?>">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse<?php echo e($index); ?>" aria-expanded="false"
                                                aria-controls="collapse<?php echo e($index); ?>">
                                            <?php echo e($item['question'] ?? ''); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse<?php echo e($index); ?>" class="collapse" aria-labelledby="heading<?php echo e($index); ?>"
                                     data-parent="#faqAccordion">
                                    <div class="card-body">
                                        <?php echo e($item['answer'] ?? ''); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'portfolio'): ?>
            <section class="portfolio-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <?php if(!empty($item['image'])): ?>
                                        <img src="<?php echo e(Storage::url($item['image'])); ?>" class="card-img-top" alt="<?php echo e($item['title'] ?? ''); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5><?php echo e($item['title'] ?? ''); ?></h5>
                                        <p><?php echo e($item['description'] ?? ''); ?></p>
                                        <?php if(!empty($item['link'])): ?>
                                            <a href="<?php echo e($item['link']); ?>" class="btn btn-outline-primary btn-sm">View</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

        
        <?php elseif($section->type == 'pricing'): ?>
            <section class="pricing-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3"><?php echo e($title); ?></h2>
                    <?php if($subtitle): ?>
                        <p class="text-center lead mb-5"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['plans'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo e($plan['name'] ?? ''); ?></h5>
                                        <h2 class="card-price"><?php echo e($plan['price'] ?? ''); ?></h2>
                                        <ul class="list-unstyled">
                                            <?php
                                                $features = is_array($plan['features'] ?? null)
                                                    ? $plan['features']
                                                    : (isset($plan['features']) ? explode(',', $plan['features']) : []);
                                            ?>
                                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e(trim($feature)); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php if(!empty($plan['button_text']) && !empty($plan['button_url'])): ?>
                                            <a href="<?php echo e($plan['button_url']); ?>" class="btn btn-primary">
                                                <?php echo e($plan['button_text']); ?>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .step-number {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .card-price {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
    }
    .cta-section {
        position: relative;
        background-attachment: fixed;
    }
    .cta-section .btn-light {
        color: #007bff;
    }
    .faq-section .btn-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    .faq-section .btn-link:hover {
        text-decoration: underline;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/pages/home.blade.php ENDPATH**/ ?>