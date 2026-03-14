<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Relax Platform'); ?></title>

    <!-- Bootstrap CSS (от CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome за икони (ако искаш) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Допълнителни CSS -->
    <?php echo $__env->yieldPushContent('css'); ?>
    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: Arial;
        }

        .navbar {
            background: #020617;
        }

        .card {
            background: #1e293b;
            border: none;
        }

        .btn-primary {
            background: #3b82f6;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- jQuery (необходим за Bootstrap 4, но Bootstrap 5 не изисква jQuery) -->
    <!-- Ако ползваш Bootstrap 5, махни jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (за Bootstrap 4) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS (използваме Bootstrap 4, за да пасне на AdminLTE) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Алтернативно за Bootstrap 5 (без jQuery) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <?php echo $__env->yieldPushContent('js'); ?>
</body>

</html>
<?php /**PATH D:\xampp\htdocs\relax-platform\resources\views/layouts/front.blade.php ENDPATH**/ ?>