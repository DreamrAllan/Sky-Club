<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Mingguan dengan Slot Waktu dan Keranjang</title>
    <!-- Tambahkan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="">

    <nav class="bg-gray-50 py-2" x-data="{ isOpen: false }">
        <div class="mx-auto px-6 sm:px-6 lg:px-8 ">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ Storage::url('images/logo.svg') }}" alt="Sky Club">
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-baseline space-x-4">
                        <x-navlink href="/field-schedule" :active="request()->is('jadwalLapangan')">Jadwal Lapangan</x-navlink>
                        <x-navlink href="/sparing" :active="request()->is('posts')">Sparing</x-navlink>
                        <x-navlink href="/article" :active="request()->is('about')">Artikel</x-navlink>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="flex">
                        @auth
                            <div class="flex items-center space-x-3 self-center">
                                <button type="button"
                                    class="relative rounded-full p-1 text-black focus:outline-none">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </button>
                                <div class="flex items-center space-x-2">
                                    {{-- keranjang button --}}
                                    <button type="button" class="relative flex max-w-xs items-center border-e-2 border-red-600 text-sm pr-3">
                                        <span class="sr-only">Cart</span>
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                                          </svg>
                                        <span class="ml-2 text-base">Keranjang</span>
                                    </button>
                                </div>
                                <!-- Profile dropdown -->
                                <div class="relative ml-3" x-data="{ isOpen: false }">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" @click="isOpen = !isOpen"
                                            class="relative flex max-w-xs items-center rounded-full text-sm "
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="h-8 w-8 rounded-full"
                                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt="">
                                            <span class="ml-2 font-semibold">{{ auth()->user()->name }}</span>
                                        </button>
                                    </div>
                                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75 transform"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"q
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                        tabindex="-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-1">Settings</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                                tabindex="-1" id="user-menu-item-2">Sign out</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-baseline space-x-2">
                                <a href="{{ route('login.index') }}"
                                    class="rounded-md px-5 py-2 text-sm font-medium bg-gray-200">Masuk</a>
                                <a href="{{ route('register.index') }}"
                                    class="rounded-md px-5 py-2 text-sm font-medium bg-red-600 text-white">Daftar</a>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="-mr-2 flex md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" @click="isOpen = !isOpen"
                        class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div x-show="isOpen" class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <x-navlink href="/home" :active="request()->is('home')">Home</x-navlink>
                <x-navlink href="/posts" :active="request()->is('posts')">Posts</x-navlink>
                <x-navlink href="/contact" :active="request()->is('contact')">Contact</x-navlink>
                <x-navlink href="/about" :active="request()->is('about')">About</x-navlink>
            </div>
            <div class="border-t border-gray-700 pb-3 pt-4">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">Tom Cook</div>
                        <div class="text-sm font-medium text-gray-400">tom@example.com</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                        Profile</a>
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                        out</a>
                </div>
            </div>
        </div>
    </nav>

    <div x-data="calendar()" x-init="init()" class="w-full max-w-3xl">
        <!-- Kalender Mingguan -->
        <div class="flex items-center justify-between p-4 bg-white shadow rounded-md mb-4">
            <button @click="previousWeek" class="text-gray-500 hover:text-gray-700">
                &#8249;
            </button>

            <div class="flex space-x-2">
                <template x-for="(day, index) in weekDays" :key="index">
                    <div @click="selectDate(day.date)" :class="{'bg-red-500 text-white': isSelected(day.date)}"
                         class="cursor-pointer text-center w-16 p-2 rounded-md">
                        <div class="text-xs font-medium" x-text="day.name"></div>
                        <div class="text-sm font-semibold" x-text="day.date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })"></div>
                    </div>
                </template>
            </div>

            <button @click="nextWeek" class="text-gray-500 hover:text-gray-700">
                &#8250;
            </button>

            <!-- Date Picker -->
            <div class="relative ml-4">
                <label>
                    <input type="date" x-model="selectedDate" @change="goToSelectedDate" class="absolute opacity-0 w-full h-full cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-500 hover:text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-6 0h6m2 2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h12z" />
                    </svg>
                </label>
            </div>
        </div>

        <!-- Slot Waktu -->
        <div class="grid grid-cols-3 gap-4 mb-4">
            <template x-for="(slot, index) in timeSlots" :key="index">
                <div :class="{'bg-gray-200 text-gray-400': !slot.available || slotInCart(slot), 'border border-red-500': slot.selected}"
                     @click="toggleSlotSelection(slot)"
                     class="p-4 bg-white shadow rounded-md cursor-pointer text-center"
                     :style="{ pointerEvents: slot.available && !slotInCart(slot) ? 'auto' : 'none' }">
                    <div class="text-xs font-medium" x-text="slot.duration + ' Menit'"></div>
                    <div class="text-lg font-semibold" x-text="slot.time"></div>
                    <div class="text-sm font-medium" x-text="slot.available ? slot.price : 'Booked'"></div>
                </div>
            </template>
        </div>

        <!-- Keranjang Slot Terpilih -->
        <div class="bg-white shadow rounded-md p-4">
            <h2 class="text-lg font-semibold mb-2">Keranjang</h2>
            <template x-if="cart.length > 0">
                <ul>
                    <template x-for="(item, index) in cart" :key="index">
                        <li class="flex items-center justify-between mb-2">
                            <span><span x-text="item.time"></span> - <span x-text="item.date.toLocaleDateString('id-ID')"></span></span>
                            <button @click="removeFromCart(item)" class="text-red-500 hover:text-red-700">X</button>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="cart.length === 0">
                <p class="text-gray-500">Keranjang kosong</p>
            </template>
        </div>
    </div>

    <script>
        function calendar() {
            return {
                currentDate: new Date(),
                weekDays: [],
                selectedDate: '',
                timeSlots: [],
                cart: [],

                // Inisialisasi kalender mingguan
                init() {
                    this.updateWeekDays();
                    this.loadTimeSlots();
                },

                // Memperbarui tanggal dalam seminggu
                updateWeekDays() {
                    const startOfWeek = new Date(this.currentDate);
                    startOfWeek.setDate(this.currentDate.getDate() - this.currentDate.getDay()); // Mulai dari Senin

                    this.weekDays = [];
                    const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

                    for (let i = 0; i < 7; i++) {
                        const day = new Date(startOfWeek);
                        day.setDate(startOfWeek.getDate() + i);
                        this.weekDays.push({
                            name: dayNames[i],
                            date: day
                        });
                    }
                },

                // Memilih tanggal untuk melihat slot waktu
                selectDate(date) {
                    this.currentDate = new Date(date);
                    this.selectedDate = date;
                    this.loadTimeSlots();
                },

                // Menandai atau membatalkan penandaan pada slot waktu dan menambahkannya ke keranjang
                toggleSlotSelection(slot) {
                    if (slot.available && !this.slotInCart(slot)) {
                        slot.selected = true;
                        this.cart.push({ ...slot, date: new Date(this.selectedDate) });
                    }
                },

                // Menghapus slot dari keranjang
                removeFromCart(item) {
                    this.cart = this.cart.filter(slot => slot.time !== item.time || slot.date.toDateString() !== item.date.toDateString());
                    this.timeSlots.forEach(slot => {
                        if (slot.time === item.time) {
                            slot.selected = false;
                        }
                    });
                },

                // Cek apakah slot sudah ada di keranjang
                slotInCart(slot) {
                    return this.cart.some(item => item.time === slot.time && item.date.toDateString() === new Date(this.selectedDate).toDateString());
                },

                // Memeriksa apakah tanggal dipilih
                isSelected(date) {
                    return this.selectedDate && date.toDateString() === new Date(this.selectedDate).toDateString();
                },

                // Pergi ke tanggal tertentu menggunakan date picker
                goToSelectedDate() {
                    if (this.selectedDate) {
                        this.currentDate = new Date(this.selectedDate);
                        this.updateWeekDays();
                        this.loadTimeSlots();
                    }
                },

                // Berpindah minggu
                previousWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() - 7);
                    this.updateWeekDays();
                },

                nextWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() + 7);
                    this.updateWeekDays();
                },

                // Memuat slot waktu (contoh data statis)
                loadTimeSlots() {
                    this.timeSlots = [
                        { time: '06.00 - 08.00', duration: 120, price: 'Booked', available: false, selected: false },
                        { time: '08.00 - 10.00', duration: 120, price: 'Booked', available: false, selected: false },
                        { time: '10.00 - 12.00', duration: 120, price: 'Rp 1.000.000', available: true, selected: false },
                        { time: '12.00 - 14.00', duration: 120, price: 'Rp 1.000.000', available: true, selected: false },
                        { time: '14.00 - 16.00', duration: 120, price: 'Rp 1.000.000', available: true, selected: false },
                        { time: '18.00 - 20.00', duration: 120, price: 'Booked', available: false, selected: false },
                        { time: '20.00 - 22.00', duration: 120, price: 'Booked', available: false, selected: false },
                    ];
                },
            };
        }
    </script>
</body>
</html>
