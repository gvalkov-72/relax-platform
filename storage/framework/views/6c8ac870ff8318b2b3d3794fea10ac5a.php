

<?php $__env->startSection('title', __('roles.title.index')); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e(__('roles.title.index')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> <?php echo e(__('roles.button.create')); ?>

    </a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                     <tr>
                        <th><?php echo e(__('roles.table.id')); ?></th>
                        <th><?php echo e(__('roles.table.name')); ?></th>
                        <th width="150"><?php echo e(__('roles.table.actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($role->id); ?></td>
                        <td><?php echo e($role->name); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> <?php echo e(__('roles.button.edit')); ?>

                            </a>
                            <form method="POST" action="<?php echo e(route('admin.roles.destroy', $role)); ?>" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('<?php echo e(__('roles.confirm.delete')); ?>')">
                                    <i class="fas fa-trash"></i> <?php echo e(__('roles.button.delete')); ?>

                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>