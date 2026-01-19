<!DOCTYPE html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/dropzonePayment.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="min-h-full">
    <x-navbar></x-navbar>
    @php
        $max_payment = $booking_cart['order_date']->copy()->addMinutes(5)->setTimezone('Asia/Jakarta');
        if ($max_payment->greaterThan(now())) {
            $diffInSeconds = (int) -$max_payment->diffInSeconds(now());
        } else {
            $diffInSeconds = 0;
        }
        function formatRupiah($angka)
        {
            $hasil_rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
            return $hasil_rupiah;
        }
    @endphp
    <div class="my-10" x-data="countdownTimer({{ $diffInSeconds }})">
        {{-- <div class="my-10" x-data="countdownTimer(5 * 60)"> --}}
        <div class="border bg-white shadow p-5 rounded-xl px-[70px] py-[40px] mx-auto w-[765px] space-y-10">
            <div class="flex flex-col items-center text-center font-bold">
                <p class=" text-2xl ">Selesaikan pembayaran sebelum</p>
                <div
                    class="text-red-600 bg-gray-200 w-fit px-3 py-2 rounded-xl space-x-1 flex items-center text-2xl my-2">
                    <svg class="w-6 h-6 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p x-text="formattedTime"></p>
                </div>
                <p class=" text-lg">Kirim Bukti Pembayaran Sebelum</p>
                <p class=" text-lg">{{ $max_payment }}</p>
            </div>
            <div class="p-3 border border-gray-500 rounded-lg text-lg">
                <div class="flex justify-between items-center">
                    <p>Transfer Bank</p>
                    <img src="{{ Storage::url('images/Transfer_bank.svg') }}" alt="">
                </div>
                <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div class=" space-y-1">
                        <p>Nomor Rekening</p>
                        <p class=" font-bold">45663245</p>
                    </div>
                    <a href="/" class="flex font-semibold">
                        <span>Salin</span>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white ml-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z" />
                        </svg>
                    </a>
                </div>
                <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div class=" space-y-1">
                        <p>Total Tagihan</p>
                        <p class=" font-bold">{{ formatRupiah($booking_cart['fullTotal']) }}</p>
                    </div>
                    <a href="/" class="font-semibold">Lihat Detail</a>
                </div>
            </div>
            <div class="p-3 border border-gray-400 rounded-lg space-y-2">
                <p class=" text-lg">Upload Bukti Pembayaran</p>
                <div class="flex items-center justify-center w-full">
                    <form action="/payment/uploadImage" method="post" class="dropzone flex flex-col items-center justify-center w-full h-64 hover:bg-gray-100" id="dropzone-form">
                        @csrf
                        @method('PUT')
                    </form>
                </div>
                {{-- if error --}}
                @error('photo')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                @enderror
            </div>
            <button id="upload-button" class="flex items-center justify-center w-full mt-4 px-4 py-2 bg-red-600 font-semibold text-white rounded hover:bg-red-700">Kirim</button>
        </div>
    </div>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script>
        function countdownTimer(duration) {
            return {
                time: duration,
                formattedTime: '',
                init() {
                    this.updateFormattedTime();
                    this.startCountdown();
                },
                startCountdown() {
                    const interval = setInterval(() => {
                        if (this.time > 0) {
                            this.time--;
                            this.updateFormattedTime();
                        } else {
                            clearInterval(interval);
                        }
                    }, 1000);
                },
                updateFormattedTime() {
                    const minutes = Math.floor(this.time / 60);
                    const seconds = this.time % 60;
                    this.formattedTime = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            };
        }
    </script>
</body>

</html>
