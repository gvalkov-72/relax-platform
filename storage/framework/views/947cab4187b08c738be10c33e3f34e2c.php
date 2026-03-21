<aside class="main-sidebar <?php echo e(config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4')); ?>">
    
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset(config('adminlte.logo_img'))); ?>"
             alt="<?php echo e(config('adminlte.logo_img_alt')); ?>"
             class="<?php echo e(config('adminlte.logo_img_class')); ?>">
        <span class="brand-text font-weight-light"><?php echo config('adminlte.logo'); ?></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <?php $__currentLoopData = $adminlteMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($item['header'])): ?>
                        
                        <li class="nav-header"><?php echo e($item['header']); ?></li>
                    <?php elseif(isset($item['submenu'])): ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($item['can'] ?? null)): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is(($item['active'][0] ?? '')) ? 'menu-open' : ''); ?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon <?php echo e($item['icon'] ?? 'fas fa-circle'); ?>"></i>
                                <p>
                                    <?php echo e($item['text']); ?>

                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php $__currentLoopData = $item['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e($sub['href']); ?>" class="nav-link <?php echo e(request()->is(($sub['active'][0] ?? '')) ? 'active' : ''); ?>">
                                            <i class="nav-icon <?php echo e($sub['icon'] ?? 'far fa-circle'); ?>"></i>
                                            <p><?php echo e($sub['text']); ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    <?php else: ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($item['can'] ?? null)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e($item['href']); ?>" class="nav-link <?php echo e(request()->is(($item['active'][0] ?? '')) ? 'active' : ''); ?>">
                                <i class="nav-icon <?php echo e($item['icon'] ?? 'fas fa-circle'); ?>"></i>
                                <p><?php echo e($item['text']); ?></p>
                            </a>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </nav>
    </div>
</aside><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>