<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'UniCare Student Counselling')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/unicare-symbol.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,500;0,600;0,700;1,700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/unicare.css') }}?v={{ filemtime(public_path('css/unicare.css')) }}">
</head>
<body>

    @yield('content')

    {{-- Flash messages, shown as toasts on every page --}}
    @if (session('success') || session('error'))
        <div class="toast-stack" role="status" aria-live="polite">
            @if (session('success'))
                <div class="toast toast-success auto-dismiss"><span class="toast-dot"></span>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="toast toast-error auto-dismiss"><span class="toast-dot"></span>{{ session('error') }}</div>
            @endif
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (toast) {
                setTimeout(function () {
                    toast.classList.add('is-hiding');
                    setTimeout(function () { toast.remove(); }, 400);
                }, 3500);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>