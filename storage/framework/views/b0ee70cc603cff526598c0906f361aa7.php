<!-- resources/views/admin/dashboard.blade.php -->



<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Admin Dashboard</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo e($usersCount ?? 0); ?></h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>