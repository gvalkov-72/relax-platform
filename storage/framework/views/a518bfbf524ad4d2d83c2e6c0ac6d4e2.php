<?php $layoutHelper = app('JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper'); ?>

<nav class="main-header navbar
    <?php echo e(config('adminlte.classes_topnav_nav', 'navbar-expand')); ?>

    <?php echo e(config('adminlte.classes_topnav', 'navbar-white navbar-light')); ?>">

    
    <ul class="navbar-nav">
        
        <?php echo $__env->make('adminlte::partials.navbar.menu-item-left-sidebar-toggler', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <?php echo $__env->renderEach('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item'); ?>

        
        <?php echo $__env->yieldContent('content_top_nav_left'); ?>
    </ul>

    
    <ul class="navbar-nav ml-auto">
        
        <?php echo $__env->yieldContent('content_top_nav_right'); ?>

        
        <?php echo $__env->renderEach('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item'); ?>

        
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?php echo e(strtoupper(session('admin_locale', config('app.locale')))); ?>

            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="<?php echo e(route('admin.language.switch', 'bg')); ?>" class="dropdown-item <?php echo e(session('admin_locale', config('app.locale')) == 'bg' ? 'active' : ''); ?>">
                    Български
                </a>
                <a href="<?php echo e(route('admin.language.switch', 'en')); ?>" class="dropdown-item <?php echo e(session('admin_locale', config('app.locale')) == 'en' ? 'active' : ''); ?>">
                    English
                </a>
            </div>
        </li>

        
        <?php if(Auth::user()): ?>
            <?php if(config('adminlte.usermenu_enabled')): ?>
                <?php echo $__env->make('adminlte::partials.navbar.menu-item-dropdown-user-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('adminlte::partials.navbar.menu-item-logout-link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if($layoutHelper->isRightSidebarEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.navbar.menu-item-right-sidebar-toggler', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    </ul>

</nav><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/vendor/adminlte/partials/navbar/navbar.blade.php ENDPATH**/ ?>