<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>

    <!-- Styles Mazer/Admin -->
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/iconly.css') }}">
</head>
<body>
    <!-- Init Theme -->
    <script src="{{ asset('assets/admin/static/js/initTheme.js') }}"></script>

    <div id="auth">
        {{ $slot }}
    </div>

    <!-- JS Mazer/Admin -->
    <script src="{{ asset('assets/admin/static/js/app.js') }}"></script>
</body>
</html>

