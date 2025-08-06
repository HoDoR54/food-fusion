<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>@yield('title', 'Food Fusion')</title>
</head>
<body class="flex flex-col min-h-screen m-0 p-0 box-border">
    @include('partials.header')

    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>


    @include('partials.footer')
</body>
</html>