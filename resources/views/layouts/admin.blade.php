<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SkyClub</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('header')
</head>
<body class="">
    @yield('alert')
    <div class="antialiased bg-gray-50 dark:bg-gray-900">

        @include('components.admin-navbar')
        <!-- Sidebar -->
        @include('components.sidebar')


        <main class="p-4 md:ml-64 h-auto pt-20">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}"></script>
    @stack('script')
</body>
</html>
