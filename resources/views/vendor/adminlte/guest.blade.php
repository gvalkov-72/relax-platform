<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        /* Нулиране на потенциални конфликти */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e2b3a 0%, #2a3b4e 100%);
            display: flex;
            align-items: center !important;
            justify-content: center !important;
            min-height: 100vh;
        }
        .login-box {
            width: 420px;
            margin: 0 auto !important; /* Презаписва горния маржин на AdminLTE */
            position: relative;
            top: auto !important;
            transform: none !important;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        .login-logo a {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }
        .login-logo b {
            color: #00d4ff;
            font-weight: 800;
        }
        .login-card-body {
            background: transparent !important;
            color: #fff;
        }
        .login-box-msg {
            color: #cbd5e0;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }
        .form-control {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #fff;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(0, 0, 0, 0.3);
            border-color: #00d4ff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.2);
            color: #fff;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 300;
        }
        .input-group-text {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #00d4ff;
        }
        .btn-primary {
            background: linear-gradient(45deg, #00d4ff, #0066ff);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5);
        }
        .icheck-primary label {
            color: #cbd5e0;
        }
        .icheck-primary input[type="checkbox"]:checked + label::before {
            background-color: #00d4ff;
            border-color: #00d4ff;
        }
        a {
            color: #00d4ff;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #fff;
            text-decoration: none;
        }
        .invalid-feedback {
            color: #ff6b6b;
            font-size: 12px;
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- jQuery, Bootstrap, AdminLTE JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>