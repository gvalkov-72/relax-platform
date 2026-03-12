

<?php $__env->startSection('title','Brainwave Presets'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Brainwave Presets</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<a href="<?php echo e(route('admin.brainwaves.create')); ?>" class="btn btn-primary mb-3">
Create Preset
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
<th>Base Frequency</th>
<th>Beat Frequency</th>
<th>Duration</th>
<th>Status</th>
<th width="180">Actions</th>

</tr>

</thead>

<tbody>

<?php $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td><?php echo e($preset->id); ?></td>

<td><?php echo e($preset->name); ?></td>

<td><?php echo e($preset->base_frequency); ?> Hz</td>

<td><?php echo e($preset->beat_frequency); ?> Hz</td>

<td><?php echo e($preset->duration); ?> sec</td>

<td>

<?php if($preset->is_active): ?>
<span class="badge bg-success">Active</span>
<?php else: ?>
<span class="badge bg-danger">Disabled</span>
<?php endif; ?>

</td>

<td>

<a href="<?php echo e(route('admin.brainwaves.edit',$preset)); ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="<?php echo e(route('admin.brainwaves.destroy',$preset)); ?>"
method="POST"
style="display:inline">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete preset?')">
Delete
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<?php echo e($presets->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/brainwaves/index.blade.php ENDPATH**/ ?>