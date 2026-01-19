@extends('layouts.master')
@section('content')
    {{-- Banner --}}
    <div class="flex flex-col items-center">
        <div class=" relative bg-cover rounded-xl overflow-hidden group w-full h-banner-profile">
            <img class="w-full h-full object-cover" src="{{ Storage::url('images/album_1.svg') }}" alt="">
            <a href="/" class="absolute bottom-5 right-5 bg-red-600 rounded px-4 py-2 font-semibold text-white">Lihat
                Semua Foto</a>
        </div>
        <div class="relative">
            <div class="-mt-20 relative bg-cover rounded-full overflow-hidden group size-40 ring-4 ring-red-700">
                <img class="w-full h-full object-cover" src="{{ Storage::url('images/album_1.svg') }}" alt="">
            </div>
            <button class="absolute bottom-0 right-0 p-2.5 bg-red-600 rounded-full">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <img class="absolute top-0 left-0 -mt-20" src="{{ Storage::url('images/verified.svg') }}" alt="">
        </div>
    </div>

    {{-- profile --}}
    <div class="mt-8 flex flex-col items-center space-y-2">
        <h5 class=" text-2xl font-semibold">{{ $data_user->name }}</h5>
        <p class="text-base text-gray-700">{{ $data_user->email }}</p>
    </div>

    {{-- tab --}}
    <div x-data="{ activeTab: 'account', activeBookingTab: 'Dashboard', activeBookingTab: 'field' }">
        <!-- Tab Menu for Account and History -->
        <div class="mt-8 pt-4 px-6 shadow bg-white rounded-lg">
            <div class="grid grid-cols-3 -mb-px text-sm font-semibold" role="tablist">
                <div class="text-center py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeTab === 'account' }">
                    <button @click="activeTab = 'account'" class="inline-block">Account</button>
                </div>
                {{-- <div class="border-l border-gray-400 h-7 my-auto"></div> --}}
                <div class="text-center py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeTab === 'dashboard' }">
                    <button @click="activeTab = 'dashboard'" class="inline-block">Dashboard</button>
                </div>
                <div class="text-center py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeTab === 'history' }">
                    <button @click="activeTab = 'history'" class="inline-block">History</button>
                </div>
            </div>
        </div>

        <!-- Account Tab Content -->
        <div x-show="activeTab === 'account'" class="mt-10">
            <h2 class="font-bold text-3xl mb-4">Account</h2>
            <div class="px-6 py-8 rounded-lg bg-gray-200 space-y-8">
                <!-- Account Details -->
                <div class="flex justify-between items-center">
                    <div>
                        <p>Name</p>
                        <p class="font-semibold text-xl">{{ $data_user->name }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Email</p>
                        <p class=" font-semibold text-xl">{{ $data_user->email }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Password</p>
                        <p class=" font-semibold text-xl">************</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Phone number</p>
                        <p class=" font-semibold text-xl">{{ $data_user->no_telp }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Address</p>
                        <p class=" font-semibold text-xl">{{ $data_user->address }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Date of birth</p>
                        <p class=" font-semibold text-xl">{{ $data_user->date_of_birth }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p class="">Nama Tim</p>
                        <p class=" font-semibold text-xl">{{ $data_user->team }}</p>
                    </div>
                    <a class="px-6 border-2 border-red-500 self-stretch items-center flex rounded-lg space-x-1"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- History Tab Content -->
        <div x-show="activeTab === 'history'" class="mt-10">
            <h2 class="font-bold text-3xl mb-4">Bookings</h2>

            <!-- Tab Menu for Bookings -->
            <div class="mt-8 pt-4 px-6 shadow bg-white rounded-lg">
                <div class="flex justify-evenly flex-wrap -mb-px text-sm font-semibold" role="tablist">
                    <div class="text-center p-40 py-4"
                        :class="{ 'text-red-600 border-b-4 border-black': activeBookingTab === 'field' }">
                        <button @click="activeBookingTab = 'field'" class="inline-block">Lapangan</button>
                    </div>
                    <div class="border-l border-gray-400 h-7 my-auto"></div>
                    <div class="text-center p-40 py-4"
                        :class="{ 'text-red-600 border-b-4 border-black': activeBookingTab === 'sparing' }">
                        <button @click="activeBookingTab = 'sparing'" class="inline-block">Sparing</button>
                    </div>
                    <div class="border-l border-gray-400 h-7 my-auto"></div>
                    <div class="text-center p-40 py-4"
                        :class="{ 'text-red-600 border-b-4 border-black': activeBookingTab === 'finish' }">
                        <button @click="activeBookingTab = 'finish'" class="inline-block">Selesai</button>
                    </div>
                </div>
            </div>

            <!-- Booking Tab Contents -->
            <div x-show="activeBookingTab === 'field'" class="mt-8 space-y-10">
                @forelse ($bookings as $booking)
                    @foreach ($booking->listBooking as $sesi)
                        <x-drop-booking :booking="$booking" :sesi="$sesi" />
                    @endforeach
                @empty
                    <p>Tidak ada jadwal yang telah dipesan</p>
                @endforelse
            </div>
            <div x-show="activeBookingTab === 'sparing'" class="mt-8 space-y-10">
                @for ($x = 0; $x < 3; $x++)
                    <x-drop-sparing />
                @endfor
            </div>
            <div x-show="activeBookingTab === 'finish'" class="mt-8 space-y-10">
                @for ($x = 0; $x < 2; $x++)
                    <x-drop-history-booking />
                @endfor
                @for ($x = 0; $x < 2; $x++)
                    <x-drop-history-sparing />
                @endfor
            </div>
        </div>


        <!-- Dashboard Tab Content -->
    <div x-show="activeTab === 'dashboard'" class="mt-10">
        <h2 class="font-bold text-3xl mb-4">Dashboard</h2>

        <!-- Tab Menu for Bookings -->
        <div class="mt-8 pt-4 px-6 shadow bg-white rounded-lg">
            <div class="flex justify-evenly flex-wrap -mb-px text-sm font-semibold" role="tablist">
                <div class="text-center p-40 py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeDashboardTab === 'lapangan' }">
                    <button @click="activeDashboardTab = 'lapangan'" class="inline-block">Lapangan</button>
                </div>
                <div class="border-l border-gray-400 h-7 my-auto"></div>
                <div class="text-center p-40 py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeDashboardTab === 'fiturTambahan' }">
                    <button @click="activeDashboardTab = 'fiturTambahan'" class="inline-block">Fitur Tambahan</button>
                </div>
                <div class="border-l border-gray-400 h-7 my-auto"></div>
                <div class="text-center p-40 py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeDashboardTab === 'artikel' }">
                    <button @click="activeDashboardTab = 'artikel'" class="inline-block">Artikel</button>
                </div>
            </div>
        </div>

        <!-- Dashboard Tab Contents -->
        <div x-show="activeDashboardTab === 'dashboard'" class="mt-8 space-y-10">
            @forelse ($bookings as $booking)
                @foreach ($booking->listBooking as $sesi)
                    <x-drop-booking :booking="$booking" :sesi="$sesi" />
                @endforeach
            @empty
                <p>Tidak ada jadwal yang telah dipesan</p>
            @endforelse
        </div>
        <div x-show="activeDashboardTab === 'fiturTambahan'" class="mt-8 space-y-10">
            @for ($x = 0; $x < 3; $x++)
                <x-drop-sparing />
            @endfor
        </div>
        <div x-show="activeDashboardTab === 'artikel'" class="mt-8 space-y-10">
            @for ($x = 0; $x < 2; $x++)
                <x-drop-history-booking />
            @endfor
            @for ($x = 0; $x < 2; $x++)
                <x-drop-history-sparing />
            @endfor
        </div>
    </div>

</div>




@endsection
