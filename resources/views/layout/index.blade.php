<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Lobster&family=Playfair+Display:wght@400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/ts/main.ts'])
    <link rel="icon" href="{{ asset('logo/logo-dark.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @stack('styles')
    <title>@yield('title', 'Food Fusion')</title>
</head>
<body class="flex flex-col min-h-[1000px] m-0 p-0 box-border bg-background text-text relative">

    @include('components.header')

    {{-- overlay --}}
    <div id="pop-up-overlay" class="fixed hidden top-0 left-0 right-0 bottom-0 bg-black/50 z-40"></div>

    {{-- pop-up --}}
    <div id="pop-up-container" 
         class="fixed hidden top-0 left-0 right-0 bottom-0 z-50 items-center justify-center">
        <div class="pointer-events-auto">
        </div>
    </div>

    <main class="flex-grow container mx-auto">
        @if (isset($breadcrumbItems))
            <x-breadcrumb :items="$breadcrumbItems" />
        @endif
        @yield('content')
    </main>

    @include('components.footer')
    @stack('scripts')

    {{-- toaster --}}
    <div id="toast-container" class="fixed top-8 right-4 z-50 space-y-2"></div>

    @php
        $toastData = [];

        // Check for session flash messages
        if (session()->has('toastMessage')) {
            $validTypes = ['success', 'info', 'warning', 'error'];
            $message = session('toastMessage');
            $type = session('toastType', 'info');
            $type = in_array($type, $validTypes) ? $type : 'info';
            $toastData[] = [
                'message' => addslashes(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')),
                'type' => $type
            ];
        }
        
        // Check for direct variables (from with() method)
        if (isset($toastMessage) && $toastMessage) {
            $validTypes = ['success', 'info', 'warning', 'error'];
            $message = $toastMessage;
            $type = isset($toastType) ? $toastType : 'info';
            $type = in_array($type, $validTypes) ? $type : 'info';
            $toastData[] = [
                'message' => addslashes(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')),
                'type' => $type
            ];
        }

        // for form validation errosr
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
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
</html>
