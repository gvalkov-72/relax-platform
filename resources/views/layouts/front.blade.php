<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title', 'Relax Platform')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0f172a;
    color:white;
    font-family:Arial;
}

.navbar{
    background:#020617;
}

.card{
    background:#1e293b;
    border:none;
}

.btn-primary{
    background:#3b82f6;
}

</style>

</head>

<body>

@include('partials.header')

<div class="container mt-5">
@yield('content')
</div>

@include('partials.footer')

<script src="/js/meditation-player.js"></script>

</body>
</html>