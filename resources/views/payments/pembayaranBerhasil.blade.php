<!DOCTYPE html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="min-h-full">
    <x-navbar></x-navbar>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="my-10">
        <div class="border bg-white shadow p-5 rounded-xl px-[70px] py-[40px] mx-auto w-[765px]">
            <div class="flex flex-col items-center text-center mb-12">
                <img src="{{ Storage::url('images/icon_success.svg') }}" alt="">
                <h4 class=" text-5xl font-bold">Success</h4>
                <div class="flex items-center text-lg">
                    <p>{{ Carbon::now('Asia/Jakarta')->isoFormat('D MMMM YYYY') }}</p>
                    <span class="w-1.5 h-1.5 mx-1.5 bg-black rounded-full dark:bg-gray-400"></span>
                    <p>{{ Carbon::now('Asia/Jakarta')->isoFormat('HH:mm:ss [WIB]') }}</p>
                </div>
            </div>
            <div class=" text-center text-xl font-medium mb-6">
                <p>Pembayaran anda sudah terkirim kepada admin</p>
                <p>untuk konfirmasi penyewaan lapangan dalam waktu 1x24 jam</p>
            </div>
            <div class="flex items-stretch space-x-3">
                <a href="{{ route('profile.show') }}"
                    class="bg-red-600 w-full text-center py-3 rounded-lg font-bold text-white">Cek Status
                    Pembayaran</a>
                <a href="{{ route('schedule.index') }}"
                    class="bg-red-600 w-full text-center py-3 rounded-lg font-bold text-white">Pesan
                    Lagi</a>
            </div>
        </div>
    </div>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>
