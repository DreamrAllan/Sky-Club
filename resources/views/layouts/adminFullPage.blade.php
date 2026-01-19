<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SkyClub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('header')
</head>
<body >
    @yield('alert')

    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        @include('components.admin-navbar')
        <!-- Sidebar -->
        @include('components.sidebar')


        <main class="md:ml-64 h-auto pt-24 bg-white">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}"></script>
    @stack('script')
</body>
</html>
