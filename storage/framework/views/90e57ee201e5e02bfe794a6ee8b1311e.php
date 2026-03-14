<?php
    $languages = \App\Models\Language::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $currentLanguage = $currentLanguage ?? \App\Models\Language::where('is_default', true)->first();

    $menuPages = \App\Models\Page::whereNull('parent_id')
        ->where('show_in_menu', true)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/<?php echo e($currentLanguage->code); ?>">Relax Platform</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Меню със страници -->
            <ul class="navbar-nav mr-auto">
                <?php $__currentLoopData = $menuPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $translation = $page->translations()
                            ->where('language_id', $currentLanguage->id)
                            ->first();
                    ?>
                    <?php if($translation): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/<?php echo e($currentLanguage->code); ?>/<?php echo e($translation->slug); ?>">
                                <?php echo e($translation->menu_title); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <!-- Language Switcher -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(strtoupper($currentLanguage->code)); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item" href="/<?php echo e($lang->code); ?>">
                                <?php echo e($lang->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/partials/header.blade.php ENDPATH**/ ?>