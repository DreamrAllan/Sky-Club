<!DOCTYPE html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="h-full">
    <x-navbar></x-navbar>

    @php
        use Carbon\Carbon;
        $field = $booking_cart['field'];
        $sub_total = $booking_cart['total'];
        $harga_total = $booking_cart['fullTotal'];
        $voucher = $booking_cart['discount'];
        $code_voucher = $booking_cart['voucher']->code ?? '';
        $list_schedules = $booking_cart['list_schedules'];
        $user_offline = $booking_cart['user_offline'] ?? [];
        $isAdmin = Auth()->user()->role == 'admin';
        function formatRupiah($angka)
        {
            $hasil_rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
            return $hasil_rupiah;
        }
    @endphp
    <div class="min-h-full px-16 my-12">
        {{-- <div class="min-h-full my-12"> --}}
        <div class=" grid grid-cols-2 gap-10">
            <div>
                <h2 class=" font-bold text-3xl mb-4">Detail Pembayaran</h2>
                <h4 class=" font-bold text-2xl mb-5">{{ $field->name }}</h4>
                <div class="flex items-center mb-4">
                    <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <p class=" font-bold text-2xl">{{ $averageRating }}</p>
                    <span class="w-1.5 h-1.5 mx-1.5 bg-black rounded-full dark:bg-gray-400"></span>
                    <p class=" font-bold text-2xl">Lokasi</p>
                </div>
                <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                <h4 class=" font-bold text-2xl">{{ $field->name }}</h4>
                <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                <div class="space-y-1">
                    @foreach ($list_schedules as $schedule)
                        <div>
                            <div class="flex items-center">
                                {{-- <span class="w-1.5 h-1.5 mx-1.5 bg-black rounded-full dark:bg-gray-400"></span> --}}
                                <p>{{ Carbon::parse($schedule['date'])->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div
                                class="flex items-center justify-between border-s-8 border-red-600 bg-white p-2.5 font-bold text-base rounded-xl">
                                <p>{{ str_pad($schedule['session'] - 1, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad($schedule['session'], 2, '0', STR_PAD_LEFT) . ':00' }}
                                </p>
                                <p>{{ formatRupiah($schedule['price']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">

                <div x-data="{ dropDown: 'up' }">
                    <div class="flex justify-between mb-4">
                        <h5 class=" font-bold text-2xl">Metode Pembayaran</h5>
                        <svg x-show="dropDown == 'up'" @click="dropDown='down'"
                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m5 15 7-7 7 7" />
                        </svg>
                        <svg x-show="dropDown == 'down'" @click="dropDown='up'"
                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </div>
                    <div x-show="dropDown == 'down'" {{-- <div x-show="true" --}}
                        class="flex justify-between shadow bg-white rounded-lg items-center p-2.5 text-base">
                        <div class="flex items-center space-x-2">
                            <img src="{{ Storage::url('images/Transfer_bank.svg') }}" alt="">
                            <p>Transfer Bank</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input id="default-radio-1" type="radio" value="" name="default-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                required>
                            <label for="default-radio-1" class="ms-2 font-medium text-gray-900 dark:text-gray-300 ">
                                {{ formatRupiah($harga_total) }}</label>
                        </div>
                    </div>
                </div>

                {{-- form --}}
                @if ($isAdmin)
                    {{-- pengisian data user untuk admin --}}
                    <div x-data="{ dropDown: 'up', selectedUser: '{{ session('userOfflineSuccess') }}' }" class="mt-8">
                        <div class="flex justify-between mb-4">
                            <h5 class=" font-bold text-2xl">Masukan Data</h5>
                            <svg x-show="dropDown == 'up'" @click="dropDown='down'"
                                class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                            <svg x-show="dropDown == 'down'" @click="dropDown='up'"
                                class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </div>

                        <form class="w-full mx-auto mb-5" x-show="dropDown == 'down'"
                            action="{{ route('booking.userOffline') }}" method="POST">
                            @csrf
                            <label for="user"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih User</label>
                            <select id="user" x-model="selectedUser" name="user"
                                class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                                <option value="nothing" selected>Belum Pernah Pesan</option>
                                @foreach ($users_offline as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" x-show="selectedUser != 'nothing'"
                                class="mb-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Pilih</button>
                            @if (session()->has('userOfflineSuccess'))
                                <p class="text-sm text-green-600 dark:text-green-500"><span class="font-medium">Sudah
                                        Terpilih
                                </p>
                            @endif
                        </form>

                        <form x-data="{ name: '{{ $user_offline['name'] ?? '' }}', no_telp: '{{ $user_offline['no_telp'] ?? '' }}', email: '{{ $user_offline['email'] ?? '' }}' }" class="w-full mx-auto"
                            x-show="dropDown == 'down' && selectedUser == 'nothing'"
                            action="{{ route('booking.userOffline') }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <input type="text" id="name" name="name" x-model="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                    required />
                            </div>
                            <div class="mb-5">
                                <label for="no_telp"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                    Telepon</label>
                                <input type="text" id="no_telp" name="no_telp" x-model="no_telp"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                    required />
                            </div>
                            <div class="mb-5">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    email</label>
                                <input type="email" id="email" name="email" x-model="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                    placeholder="name@flowbite.com" required />
                            </div>
                            <button type="submit"
                                class="mb-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Submit</button>
                        </form>
                        {{-- end form --}}
                    </div>
                @endif


            </div>
            <div class=" space-y-4" x-data="{ inputVoucher: 'false' }">
                <button @click="inputVoucher = !inputVoucher"
                    class="w-full py-3 border-2 border-red-600 text-center text-base rounded-xl font-bold text-red-600 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/icon_voucher.svg') }}" alt="Voucher Icon" class="w-5 h-5 mr-2">
                    Gunakan Voucher
                </button>
                {{-- voucher --}}

                <form x-show="inputVoucher" class="flex items-center w-full" action="{{ route('booking.voucher') }}"
                    method="POST">
                    @csrf
                    <label for="simple-search" class="sr-only">Voucher</label>
                    <div class="relative w-full flex-grow">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <img src="{{ asset('assets/icons/icon_voucher.svg') }}" alt="Voucher Icon"
                                class="w-5 h-5 mr-2">
                        </div>
                        <input type="text" id="simple-search" name="voucher" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukan Kode Voucher..." required value="{{ $code_voucher }}" />

                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-red-600 rounded-lg border border-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 flex-grow">
                        <p>Gunakan</p>
                        <span class="sr-only">Gunakan</span>
                    </button>
                </form>
                @if (session()->has('voucher'))
                    <p class="text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ session('voucher') }}
                    </p>
                @elseif (session()->has('voucherSuccess'))
                    <p class="text-sm text-green-600 dark:text-green-500"><span
                            class="font-medium">{{ session('voucherSuccess') }}</p>
                @endif

                {{-- end voucher --}}
                <div class="border border-gray-600 p-5 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <img class="rounded-xl h-[100px]" src="{{ Storage::url('images/album_1.svg') }}"
                            alt="">
                        <div>
                            <h3 class="font-bold text-2xl">{{ $field->name }}</h3>
                            <div class="flex items-center mb-4">
                                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path
                                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                <p class=" font-bold text-2xl mx-1.5">{{ $averageRating }}</p>
                                <p class=" font-semibold text-2xl">({{ $countRating }} Reviews)</p>
                            </div>
                        </div>
                    </div>
                    <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                    <h3 class=" text-2xl font-bold mb-4">Detail Harga</h3>
                    <div class=" text-base space-y-1">
                        <div class="flex items-center justify-between">
                            <p>Biaya Sewa</p>
                            <p>{{ formatRupiah($sub_total) }}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p>Potongan Voucher</p>
                            <p>{{ formatRupiah($voucher) }}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p>Biaya Transaksi</p>
                            <p>Rp 0</p>
                        </div>
                    </div>
                    <hr class="h-px my-4 bg-gray-400 border-0 dark:bg-gray-700">
                    <div class="flex items-center justify-between">
                        <p class=" font-bold text-2xl">Total</p>
                        <p class=" font-bold">{{ formatRupiah($harga_total) }}</p>
                    </div>
                </div>

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <button
                        class="w-full py-3 border-2 bg-red-600 text-center text-2xl rounded-xl font-bold text-white flex items-center justify-center">
                        <img src="{{ asset('assets/icons/icon_shield.svg') }}" alt="Voucher Icon" class="mr-2">
                        Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- @endsection --}}

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>
