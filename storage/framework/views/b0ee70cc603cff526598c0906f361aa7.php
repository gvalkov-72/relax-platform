<?php $__env->startSection('title', __('dashboard.title')); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e(__('dashboard.header')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo e($usersCount ?? 0); ?></h3>
                <p><?php echo e(__('dashboard.users')); ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="small-box-footer"><?php echo e(__('dashboard.more_info')); ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success" id="online-users-box">
            <div class="inner">
                <h3 id="online-users-count"><?php echo e($onlineUsersCount ?? 0); ?></h3>
                <p><?php echo e(__('dashboard.online_users')); ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__('dashboard.online_users_list')); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body collapse show" id="online-users-list">
                <table class="table table-striped" id="online-users-table">
                    <thead>
                          <tr>
                            <th>ID</th>
                            <th><?php echo e(__('dashboard.name')); ?></th>
                            <th><?php echo e(__('dashboard.email')); ?></th>
                          </tr>
                    </thead>
                    <tbody>
                        <?php if($onlineUsers->count()): ?>
                            <?php $__currentLoopData = $onlineUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->id); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr id="no-online-row">
                                <td colspan="3" class="text-muted"><?php echo e(__('dashboard.no_online_users')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    // Функция за обновяване на списъка с онлайн потребители
    function refreshOnlineUsers() {
        fetch('<?php echo e(route("admin.online-users")); ?>', {
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Обновяване на броя
            document.getElementById('online-users-count').innerText = data.count;

            // Обновяване на таблицата
            const tableBody = document.querySelector('#online-users-table tbody');
            if (!tableBody) return;

            // Изтриваме съществуващите редове
            tableBody.innerHTML = '';

            if (data.users.length > 0) {
                data.users.forEach(user => {
                    const row = tableBody.insertRow();
                    row.insertCell(0).innerText = user.id;
                    row.insertCell(1).innerText = user.name;
                    row.insertCell(2).innerText = user.email;
                });
            } else {
                const row = tableBody.insertRow();
                row.id = 'no-online-row';
                const cell = row.insertCell(0);
                cell.colSpan = 3;
                cell.className = 'text-muted';
                cell.innerText = '<?php echo e(__('dashboard.no_online_users')); ?>';
            }
        })
        .catch(error => console.error('Грешка при обновяване на онлайн потребителите:', error));
    }

    // Първоначално зареждане (не е задължително, защото данните са вече в HTML)
    // Но можем да извикаме refresh след 1 секунда, за да синхронизираме
    setTimeout(refreshOnlineUsers, 1000);

    // Автоматично обновяване на всеки 30 секунди
    setInterval(refreshOnlineUsers, 30000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>