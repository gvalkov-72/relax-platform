

<?php $__env->startSection('title', 'Meditations'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Meditations</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<a href="<?php echo e(route('admin.meditations.create')); ?>" class="btn btn-primary mb-3">
Create Meditation
</a>

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Duration</th>
<th>Active</th>
<th width="220">Actions</th>
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
<span class="badge badge-success">Yes</span>
<?php else: ?>
<span class="badge badge-danger">No</span>
<?php endif; ?>
</td>

<td>

<a href="<?php echo e(route('admin.meditations.edit',$meditation->id)); ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="<?php echo e(route('admin.meditation.builder',$meditation->id)); ?>"
class="btn btn-info btn-sm">
Builder
</a>

<form method="POST"
action="<?php echo e(route('admin.meditations.destroy',$meditation->id)); ?>"
style="display:inline-block">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/meditations/index.blade.php ENDPATH**/ ?>