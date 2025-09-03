<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo/logo-dark.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>@yield('title', 'Food Fusion')</title>
</head>
<body class="flex min-h-screen m-0 p-0 box-border bg-background text-text">
    <main class="flex-grow min-h-full container mx-auto px-5 py-3 w-full grid grid-cols-1 md:grid-cols-2">
        <section class="flex items-center justify-center p-10">
            @yield('left')
        </section>
        <section class="flex items-center justify-center p-10">
            @yield('right')
        </section>
        @yield('content')
    </main>
    
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @php
        $toastData = [];

        // for session flash messages or direct variables
        if (session()->has('toastMessage') || (isset($toastMessage) && $toastMessage)) {
            $validTypes = ['success', 'info', 'warning', 'error'];
            $message = isset($toastMessage) ? $toastMessage : session('toastMessage');
            $type = isset($toastType) ? $toastType : session('toastType', 'info');
            $toastType = in_array($type, $validTypes) ? $type : 'info';
            $toastData[] = [
                'message' => addslashes(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')),
                'type' => $toastType
            ];
        }

        // for form validation errors
        if ($errors->any()) {
            foreach ($errors->all() as $error) {
                $toastData[] = [
                    'message' => addslashes(htmlspecialchars($error, ENT_QUOTES, 'UTF-8')),
                    'type' => 'error'
                ];
            }
        }
    @endphp

    @if (!empty($toastData))
        <script>
            window.laravelToastData = @json($toastData);
        </script>
    @endif
</body>

<script>
    lucide.createIcons();
</script>
</html>