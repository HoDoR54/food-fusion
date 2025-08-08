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
    @livewireStyles
    <title>@yield('title', 'Food Fusion')</title>
</head>
<body class="flex flex-col min-h-[1000px] m-0 p-0 box-border bg-background text-text">
    @include('components.header')

    <main class="flex-grow container mx-auto px-5 py-3">
        @if (isset($breadcrumbItems))
            <x-breadcrumb :items="$breadcrumbItems" />
        @endif
        @yield('content')
    </main>


    @include('components.footer')
    @livewireScripts
</body>
</html>