

<?php $__env->startSection('title', 'Meditations'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Meditations</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<a href="<?php echo e(route('admin.meditations.create')); ?>" class="btn btn-primary mb-3">
    Create Meditation
</a>

<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Duration</th>
<th>Status</th>
<th width="180">Actions</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $meditations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meditation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td><?php echo e($meditation->id); ?></td>

<td><?php echo e($meditation->name); ?></td>

<td><?php echo e($meditation->duration); ?></td>

<td>
<?php if($meditation->is_active): ?>
<span class="badge bg-success">Active</span>
<?php else: ?>
<span class="badge bg-danger">Disabled</span>
<?php endif; ?>
</td>

<td>

<a href="<?php echo e(route('admin.meditations.edit',$meditation)); ?>"
class="btn btn-sm btn-warning">Edit</a>

<form action="<?php echo e(route('admin.meditations.destroy',$meditation)); ?>"
method="POST"
style="display:inline">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="btn btn-sm btn-danger"
onclick="return confirm('Delete meditation?')">
Delete
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<?php echo e($meditations->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/meditations/index.blade.php ENDPATH**/ ?>