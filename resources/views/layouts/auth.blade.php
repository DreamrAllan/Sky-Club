<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SkyClub</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="sm:p-12 p-6">

    <main class="flex justify-around">
        @yield('content')
    </main>

    <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}"></script>
</body>
</html>
