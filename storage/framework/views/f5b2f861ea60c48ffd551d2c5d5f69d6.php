

<?php $__env->startSection('title','Audio Files'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Audio Files</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<a href="<?php echo e(route('admin.audio.create')); ?>" class="btn btn-primary mb-3">
Upload Audio
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
<th>Type</th>
<th>Status</th>
<th width="180">Actions</th>

</tr>

</thead>

<tbody>

<?php $__currentLoopData = $audioFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td><?php echo e($audio->id); ?></td>

<td><?php echo e($audio->name); ?></td>

<td><?php echo e($audio->type); ?></td>

<td>

<?php if($audio->is_active): ?>
<span class="badge bg-success">Active</span>
<?php else: ?>
<span class="badge bg-danger">Disabled</span>
<?php endif; ?>

</td>

<td>

<a href="<?php echo e(route('admin.audio.edit',$audio)); ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="<?php echo e(route('admin.audio.destroy',$audio)); ?>"
method="POST"
style="display:inline">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete audio?')">
Delete
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<?php echo e($audioFiles->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/audio/index.blade.php ENDPATH**/ ?>