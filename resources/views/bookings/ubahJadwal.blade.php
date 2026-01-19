@extends('layouts.master')
@section('content')
    @php
        $schedulesArray = json_decode(json_encode($schedules), true);
    @endphp
    {{-- gallery --}}
    <div x-data="{ gallery: false }"
        class="grid grid-cols-3 grid-flow-col gap-1 sm:gap-2 md:gap-4 h-[270px] sm:h-[370px] md:h-[470px] lg:h-[670px]">
        {{-- gallery --}}
        @foreach ($fieldPhotos->take(3) as $index => $photo)
            @if ($index == 0)
                <div class="col-span-2 row-span-2 bg-cover rounded-s-3xl"
                    style="background-image: url('{{ $photo }}');"></div>
            @elseif ($index == 1)
                <div class="bg-cover rounded-tr-3xl" style="background-image: url('{{ $photo }}');"></div>
            @elseif ($index == 2)
                <div class="relative bg-cover rounded-br-3xl" style="background-image: url('{{ $photo }}');">
                    <button @click="gallery = true"
                        class="absolute bottom-2 right-2 sm:bottom-5 sm:right-5 bg-red-600 rounded p-1 sm:px-4 sm:py-2 font-semibold text-white sm:text-base text-sm">Lihat
                        Semua Foto</button>
                </div>
            @endif
        @endforeach

        {{-- modal --}}
        <div x-show="gallery" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false"
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-sm xs:max-w-md sm:max-w-lg w-full">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Gallery</h3>
                        <button @click="gallery = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <!-- Carousel -->
                        <div x-data="{
                            activeSlide: 0,
                            slides: [
                                @foreach ($fieldPhotos as $photo)
                                    '{{ $photo }}', @endforeach
                            ]
                        }">
                            <div class="relative">
                                <!-- Carousel Images -->
                                <template x-for="(slides, index) in slides" :key="index">
                                    <div x-show="activeSlide === index"
                                        class="w-full h-64 bg-cover bg-center rounded-lg transition-all duration-500"
                                        :style="`background-image: url('${slides}')`">
                                    </div>
                                </template>

                                <!-- Previous Button -->
                                <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                    class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full">
                                    &#8249;
                                </button>

                                <!-- Next Button -->
                                <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                    class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full">
                                    &#8250;
                                </button>

                                <!-- Carousel Indicators -->
                                <div
                                    class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex justify-center mt-4 space-x-2">
                                    <template x-for="(slide, index) in slides" :key="index">
                                        <button @click="activeSlide = index"
                                            :class="{
                                                'bg-red-600 w-6': activeSlide === index,
                                                'bg-gray-400': activeSlide !==
                                                    index
                                            }"
                                            class="w-3 h-3 rounded-full transition-colors"></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- cart & desc --}}
    <div x-data="calendar()" x-init="init()"
        class="flex flex-col xl:grid xl:grid-flow-col gap-2 xl:flex-row justify-between my-12">
        <div class=" xl:max-w-[700px] xxl:max-w-full">
            <div class=" space-y-1">
                <h1 class=" text-4.5xl font-bold">SKY CLUB MINI SOCCER</h1>
                <div class="flex space-x-1">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                    </svg>
                    <p class=" text-lg">Puncak Kab. Bogor</p>
                </div>
                <div class="flex">
                    <div class="flex items-center border rounded-lg px-2.5">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $averageRating }}</p>
                        <svg class="ms-1 w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                    </div>
                    <p class="p-2.5 text-sm font-medium"><span class=" font-bold">Very
                            Good - </span>{{ $countRating }} reviews</p>
                </div>
            </div>
            <hr class="h-px my-8 bg-gray-400 border-0 dark:bg-gray-700">
            <div>
                <h3 class="mb-4 text-3xl font-bold">Deskripsi</h3>
                <p class="leading-loose">{{ Str::limit($field->description, 500) . '.....' }}</p>
            </div>
            <hr class="h-px my-8 bg-gray-400 border-0 dark:bg-gray-700">
            <div class="space-y-8">
                <h3 class=" text-3xl font-bold">Fasilitas</h3>
                <div x-data="facilitySliceSelection({{ json_encode($selectedSliceFacilities) }})"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-2 gap-8 xxl:grid-cols-4">
                    <template x-if="selected.includes('mushola')">
                        <x-facility icon="icon_mosque.svg" name="Mushola" />
                    </template>
                    <template x-if="selected.includes('parking')">
                        <x-facility icon="icon_parking.svg" name="Parkir Area" />
                    </template>
                    <template x-if="selected.includes('toilet')">
                        <x-facility icon="icon_toilet.svg" name="Toilet" />
                    </template>
                    <template x-if="selected.includes('medical')">
                        <x-facility icon="icon_med.svg" name="Medis" />
                    </template>
                    <template x-if="selected.includes('security')">
                        <x-facility icon="icon_security.svg" name="Security" />
                    </template>
                    <template x-if="selected.includes('tribune')">
                        <x-facility icon="icon_tribune.svg" name="Tribun Penonton" />
                    </template>
                    <template x-if="selected.includes('wifi')">
                        <x-facility icon="icon_wifi.svg" name="Wifi" />
                    </template>
                    <template x-if="selected.includes('shower')">
                        <x-facility icon="icon_shower.svg" name="Shower" />
                    </template>
                    <template x-if="selected.includes('gym')">
                        <x-facility icon="icon_gym.svg" name="Gym" />
                    </template>
                    <template x-if="selected.includes('locker')">
                        <x-facility icon="icon_locker.svg" name="Locker" />
                    </template>
                    <template x-if="selected.includes('canteen')">
                        <x-facility icon="icon_eat.svg" name="Kantin" />
                    </template>
                    <template x-if="selected.includes('sauna')">
                        <x-facility icon="icon_sauna.svg" name="Sauna" />
                    </template>
                    <template x-if="selected.includes('run')">
                        <x-facility icon="icon_run.svg" name="Lintasan Lari" />
                    </template>
                </div>
                <div x-data="{ fasilitas: false }">
                    <button @click="fasilitas = true"
                        class="border border-red-400 rounded p-2 font-semibold text-red-500">Lihat Semua Fasilitas</button>
                    <div x-show="fasilitas" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div @click.away="fasilitas = false"
                            class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-4xl :w-full max-w-sm xs:max-w-md w-full h-4/5 overflow-scroll custom-scrollbar">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex justify-end">
                                    <button @click="fasilitas = false" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <h3 class="mb-8 text-3xl font-bold">Deskripsi</h3>
                                <div class="py-8 border-y-2">
                                    <p x-data="{ expanded: false }" class="leading-loose">
                                        <span x-show="!expanded">{{ Str::limit($fieldDescription, 500) }}</span> <span
                                            x-show="expanded">{{ $fieldDescription }}</span> <button
                                            @click="expanded = !expanded" class="text-red-500 font-semibold">
                                            <span x-show="!expanded">lihat selengkapnya</span>
                                            <span x-show="expanded">lihat lebih sedikit</span>
                                        </button>
                                    </p>
                                </div>
                                <h3 class="text-3xl font-bold my-8">Fasilitas</h3>
                                <div x-data="facilitySelection({{ json_encode($selectedFacilities) }})"
                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-2 gap-8">
                                    <template x-if="selected.includes('mushola')">
                                        <x-facility icon="icon_mosque.svg" name="Mushola" />
                                    </template>
                                    <template x-if="selected.includes('parking')">
                                        <x-facility icon="icon_parking.svg" name="Parkir Area" />
                                    </template>
                                    <template x-if="selected.includes('toilet')">
                                        <x-facility icon="icon_toilet.svg" name="Toilet" />
                                    </template>
                                    <template x-if="selected.includes('medical')">
                                        <x-facility icon="icon_med.svg" name="Medis" />
                                    </template>
                                    <template x-if="selected.includes('security')">
                                        <x-facility icon="icon_security.svg" name="Security" />
                                    </template>
                                    <template x-if="selected.includes('tribune')">
                                        <x-facility icon="icon_tribune.svg" name="Tribun Penonton" />
                                    </template>
                                    <template x-if="selected.includes('wifi')">
                                        <x-facility icon="icon_wifi.svg" name="Wifi" />
                                    </template>
                                    <template x-if="selected.includes('shower')">
                                        <x-facility icon="icon_shower.svg" name="Shower" />
                                    </template>
                                    <template x-if="selected.includes('gym')">
                                        <x-facility icon="icon_gym.svg" name="Gym" />
                                    </template>
                                    <template x-if="selected.includes('locker')">
                                        <x-facility icon="icon_locker.svg" name="Locker" />
                                    </template>
                                    <template x-if="selected.includes('canteen')">
                                        <x-facility icon="icon_eat.svg" name="Kantin" />
                                    </template>
                                    <template x-if="selected.includes('sauna')">
                                        <x-facility icon="icon_sauna.svg" name="Sauna" />
                                    </template>
                                    <template x-if="selected.includes('run')">
                                        <x-facility icon="icon_run.svg" name="Lintasan Lari" />
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="h-px my-8 bg-gray-400 border-0 dark:bg-gray-700">

            {{-- Date & slot Picker --}}
            <div class="w-full max-w-4xl">
                <div class="flex items-center justify-between p-4 bg-white shadow rounded-md mb-4">

                    {{-- button previous --}}
                    <button @click="previousWeek" class="text-gray-500 hover:text-gray-700 w-12">
                        &#8249;
                    </button>

                    <!-- week days -->
                    <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-7 gap-2">
                        <template x-for="(day, index) in weekDays" :key="index">
                            <div @click="isWithinRange(day.date) && selectDate(day.date)"
                                :class="{
                                    'bg-red-500 text-white': isSelected(day.date),
                                    'text-gray-400': !isWithinRange(day.date),
                                }"
                                class="cursor-pointer text-center w-16 p-2 rounded-md">
                                <div class="text-xs font-medium" x-text="day.name"></div>
                                <div class="text-sm font-semibold"
                                    x-text="day.date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })">
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- next button --}}
                    <button @click="nextWeek" class="text-gray-500 hover:text-gray-700 w-12">
                        &#8250;
                    </button>

                    <div class="border-l border-gray-400 h-8 my-auto"></div>
                    <!-- Date Picker -->
                    <div class="relative w-14 cursor-pointer">
                        <label class="flex items-center justify-center">
                            <input type="date" x-model="selectedDate" @change="goToSelectedDate"
                                :min="minDate.toISOString().split('T')[0]" :max="maxDate.toISOString().split('T')[0]"
                                class="absolute opacity-0 w-full h-full cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-6 h-6 text-gray-500 hover:text-gray-700">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-6 0h6m2 2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h12z" />
                            </svg>
                        </label>
                    </div>

                </div>

                <!-- Time Slot -->
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 mb-4">
                    <template x-for="(slot, index) in timeSlots" :key="index">
                        <div :class="{
                            'bg-gray-200 text-gray-400': !slot.available || slotInCart(
                                slot),
                            'border border-red-500': slot.selected
                        }"
                            @click="toggleSlotSelection(slot)"
                            class="p-2 bg-white shadow rounded-md cursor-pointer text-center"
                            :style="{ pointerEvents: slot.available && !slotInCart(slot) ? 'auto' : 'none' }">
                            <div class="text-sm font-medium" x-text="slot.duration + ' Menit'"></div>
                            <div class="text-xs font-semibold" x-text="slot.time"></div>
                            <div class="text-sm font-medium" x-text="slot.available ? slot.price : 'Booked'"></div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-between gap-2 xl:hidden">
                    <button type="submit"
                        class="bg-red-600 w-full text-center py-3 rounded-lg font-bold text-white ">Ubah Jadwal</button>
                    <a href="#"
                        class="border-2 border-red-600 w-full text-center py-3 rounded-lg font-bold text-red-600">+Keranjang</a>
                </div>
            </div>
        </div>

        {{-- cart --}}
        <div
            class="border px-5 py-8 bg-white rounded-2xl max-h-fit space-y-7 sticky top-2 w-[490px] min-w-[360px] hidden xl:block">
            <div>
                <h4 class="font-bold text-2xl">Mulai dari</h4>
                <p class=" font-bold text-4xl">Rp. 100.000,00 <span class=" text-xl">/Sesi</span></p>
            </div>
            <template x-if="cart.length > 0">
                <ul class=" space-y-4">
                    <template x-for="(item, index) in cart" :key="index">
                        <li
                            class="w-full flex justify-between items-center border border-gray-500 text-lg rounded-xl py-2 px-4">
                            <div>
                                <p
                                    x-text="new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })">
                                </p>
                                <p x-text="item.time"></p>
                            </div>
                            <div class="flex space-x-7">
                                <p x-text="item.price"></p>
                                <button @click="removeFromCart(item)" class="text-red-500 hover:text-red-700">X</button>
                            </div>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="cart.length === 0">
                <p class="text-gray-500">Keranjang kosong</p>
            </template>

            <hr class="h-px my-8 bg-gray-400 border-0 dark:bg-gray-700">
            <div class="flex justify-between text-2xl font-semibold">
                <p>Total Harga</p>
                <p x-text="totalPrice.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })"></p>
            </div>
            <div>

                <form action="{{ route('schedule.rescheduleValidate', $list_booking->id) }}" method="POST">
                    @csrf
                    <template class="hidden" x-for="(item, index) in cart" :key="index">
                        <div>
                            <input type="hidden" :name="`schedule[${index}]`"
                                :value="item.date.toDateString('yyyy-mm-dd')">
                            <input type="hidden" :name="`session[${index}]`" :value="item.time">
                            <input type="hidden" :name="`price[${index}]`" :value="item.price">
                        </div>
                    </template>
                    <div class="flex space-x-4">
                        <button type="submit"
                            class="bg-red-600 w-full text-center py-3 rounded-lg font-bold text-white ">Ubah
                            Jadwal</button>
                        <a href="#"
                            class="border-2 border-red-600 w-full text-center py-3 rounded-lg font-bold text-red-600">+Keranjang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- customer testimoni --}}
    <div x-data="{ testimoni: false }" class="">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-4xl font-bold">Customer Testimonials</h2>
                <h6 class="text-lg">Kesan dari kawan kawan SKY CLUB</h6>
            </div>
            <div>
                <button @click="testimoni = true">Lihat Selengkapnya</button>
            </div>
        </div>

        {{-- testimoni modal --}}
        <div x-show="testimoni" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="testimoni = false"
                class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-4xl sm:w-full h-4/5 overflow-scroll custom-scrollbar max-w-sm xs:max-w-md w-full">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-3xl leading-6 font-bold text-gray-900">Ulasan</h3>
                        <button @click="testimoni = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center space-x-6 mb-8">
                        <p class=" text-gray-500 font-bold"><span
                                class="text-black text-3xl">{{ $averageRating }}</span>/5</p>
                        <div class="flex space-x-1">
                            @for ($x = 0; $x < 5; $x++)
                                <svg class="w-6 h-6 text-yellow-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path
                                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <div class="mt-4 space-y-4">
                        @foreach ($reviews as $review)
                            <div class="p-4 rounded-lg border">
                                <div class="flex justify-between mb-6">
                                    <div class="flex items-center space-x-4">
                                        <img class=" rounded-full w-12 h-12"
                                            src="{{ asset('storage/' . $review->user->profile_photo) }}" alt="">
                                        <div>
                                            <p class="text-base font-bold">{{ $review->user->name }}</p>
                                            <p class="text-base">{{ $review->user->team }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center p-2 rounded-lg border">
                                        <svg class="w-6 h-6 text-yellow-300 me-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                        <p class="font-semibold text-2xl">{{ $review->rating }}</p>
                                    </div>
                                </div>
                                <p>"{{ $review->comment }}"</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- testimoni --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach ($reviews as $review)
                <div class="space-y-6 sm:space-y-8 border-b-2 pb-6 sm:border-b-0 sm:pb-0">
                    <div class="flex items-center">
                        @for ($x = 0; $x < $review->rating; $x++)
                            <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path
                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        @endfor
                    </div>
                    <p>{{ $review->comment }}</p>
                    <div class="flex items-center sm:block">
                        <img class=" rounded-full w-14 sm:mb-4 mr-4"
                            src="{{ 'storage/' . $review->user->profile_photo }}" alt="">
                        <div>
                            <p class="text-base font-bold">{{ $review->user->name }}</p>
                            <p class="text-base">{{ $review->user->team }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="h-px my-8 bg-gray-400 border-0 dark:bg-gray-700">
        <div class="rounded-lg border border-gray-300">
            <div class=" grid p-6 sm:p-12 space-y-8">
                <div>
                    <p class="text-3xl font-bold">Lokasi Venue</p>
                    <p class="text-xl font-bold">Jalan Raya Palsu No. 123, Kota Bogor, Jawa Barat, 16111</p>
                </div>
                <iframe class="w-full sm:h-[27rem] "
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7906.299606239549!2d110.36796849553049!3d-7.77393531109345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a584a6eaf7cbb%3A0x294cd98559dc9c8c!2sSekolah%20Vokasi%20UGM!5e0!3m2!1sid!2sid!4v1729779883264!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
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
                dataServer: @json($schedules),
                dataWeekInServer: [],
                dataDateInServer: [],
                minDate: new Date(), // Tanggal minimum yang dapat dipilih
                maxDate: new Date(new Date().setMonth(new Date().getMonth() + 2)), // Tanggal maksimum yang dapat dipilih

                // Inisialisasi kalender mingguan
                init() {
                    const dataArrayServer = this.dataServer.map(item => Object.values(item));
                    this.dataServer = dataArrayServer;
                    const indexWeek = this.getWeekIndexByDate(this.dataServer, this.currentDate);
                    this.dataWeekInServer = this.dataServer[indexWeek];
                    this.dataWeekInServer.forEach(dataDate => {
                        dateObject = new Date(dataDate.date);
                        this.dataDateInServer.push(dateObject);
                    });
                    this.updateWeekDays();
                    this.selectedDate = this.currentDate.toISOString().split('T')[
                        0]; // Set tanggal saat ini sebagai default
                    const index = this.getIndexData(this.currentDate);
                    this.loadTimeSlots(index);
                    // console.log(new Date(this.dataServer[0].date)); // tanggal 4 nov
                },
                updateWeekInServer() {
                    this.dataWeekInServer = this.dataServer[indexWeek];
                    this.dataWeekInServer.forEach(dataDate => {
                        dateObject = new Date(dataDate.date);
                        this.dataDateInServer.push(dateObject);
                    });
                },

                getWeekIndexByDate(data, targetDate) {
                    // Iterasi melalui setiap minggu
                    for (let weekIndex = 0; weekIndex < data.length; weekIndex++) {
                        const week = data[weekIndex];
                        // Iterasi melalui setiap hari dalam minggu
                        for (let day of week) {
                            if (new Date(day.date).toDateString() === new Date(targetDate).toDateString()) {
                                return weekIndex;
                            }
                        }
                    }
                    return null;
                },

                // Memperbarui tanggal dalam seminggu
                updateWeekDays() {
                    const startOfWeek = new Date(this.currentDate);
                    // Mengatur tanggal ke awal minggu (Senin)
                    const day = this.currentDate.getDay();
                    const diff = (day === 0 ? -6 : 1) -
                        day; // Jika hari Minggu (0), mundur 6 hari, jika tidak, mundur sesuai hari
                    startOfWeek.setDate(this.currentDate.getDate() + diff);

                    this.weekDays = [];
                    const dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

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
                    const index = this.getIndexData(date);
                    this.loadTimeSlots(index);
                },

                //mendapatkan index pada data di server
                getIndexData(date) {
                    arrayDataDate = []
                    this.dataWeekInServer.forEach(dataDate => {
                        dateObject = new Date(dataDate.date);
                        arrayDataDate.push(dateObject);
                    });
                    this.dataDateInServer = arrayDataDate;
                    return this.dataDateInServer.findIndex(dataDate => dataDate.toDateString() === date.toDateString());
                },

                // Menandai atau membatalkan penandaan pada slot waktu dan menambahkannya ke keranjang
                toggleSlotSelection(slot) {
                    if (slot.available && !this.slotInCart(slot)) {
                        slot.selected = true;
                        if (this.cart.length > 0) {
                            this.cart.length = 0
                            this.cart.push({
                                ...slot,
                                date: new Date(this.selectedDate)
                            });
                        } else {
                            this.cart.push({
                                ...slot,
                                date: new Date(this.selectedDate)
                            });
                        }
                    }
                },

                // Menghapus slot dari keranjang
                removeFromCart(item) {
                    this.cart = this.cart.filter(slot => slot.time !== item.time || slot.date.toDateString() !== item.date
                        .toDateString());
                    this.timeSlots.forEach(slot => {
                        if (slot.time === item.time) {
                            slot.selected = false;
                        }
                    });
                },

                // Fungsi untuk mengonversi harga dari string ke angka
                parsePrice(price) {
                    if (typeof price === 'string') {
                        return parseInt(price.replace(/[^\d]/g, ''), 10) || 0;
                    }
                    return price;
                },

                // Total harga dari keranjang
                get totalPrice() {
                    return this.cart.reduce((total, item) => total + this.parsePrice(item.price), 0);
                },

                // Cek apakah slot sudah ada di keranjang
                slotInCart(slot) {
                    return this.cart.some(item => item.time === slot.time && item.date.toDateString() === new Date(this
                        .selectedDate).toDateString());
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
                        const indexWeek = this.getWeekIndexByDate(this.dataServer, this.currentDate);
                        this.dataWeekInServer = this.dataServer[indexWeek];
                        const index = this.getIndexData(this.currentDate);
                        this.loadTimeSlots(index);
                    }
                },

                // Berpindah minggu
                previousWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() - 7);
                    this.updateWeekDays();
                    const indexWeek = this.getWeekIndexByDate(this.dataServer, this.currentDate);
                    this.dataWeekInServer = this.dataServer[indexWeek];
                    console.log(this.dataWeekInServer);
                    console.log(this.weekDays);
                },

                nextWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() + 7);
                    this.updateWeekDays();
                    const indexWeek = this.getWeekIndexByDate(this.dataServer, this.currentDate);
                    this.dataWeekInServer = this.dataServer[indexWeek];
                    console.log(this.dataWeekInServer);
                    console.log(this.weekDays);
                    console.log(indexWeek);
                },

                // Memuat slot waktu (contoh data statis)
                getSchedule(index) {
                    const schedule = this.dataWeekInServer[index];
                    const arrayData = []
                    schedule.sessions.forEach((session, index) => {
                        if (index < 10 && index + 1 < 10) {
                            arrayData.push({
                                time: `0${index}.00 - 0${index+1}.00`,
                                duration: 60,
                                price: (session ? 'Rp.100.000' : 'Booked'),
                                available: session,
                                selected: false
                            });
                        } else if (index > 9) {
                            arrayData.push({
                                time: `${index}.00 - ${index+1}.00`,
                                duration: 60,
                                price: (session ? 'Rp.100.000' : 'Booked'),
                                available: session,
                                selected: false
                            });
                        } else {
                            arrayData.push({
                                time: `0${index}.00 - ${index+1}.00`,
                                duration: 60,
                                price: (session ? 'Rp.100.000' : 'Booked'),
                                available: session,
                                selected: false
                            });
                        }

                    });
                    this.timeSlots = arrayData;
                },
                loadTimeSlots(index) {
                    this.getSchedule(index);
                },
                isWithinRange(date) {
                    return date >= this.minDate && date <= this.maxDate;
                },
            };
        }
    </script>
    <script>
        function facilitySelection(initialSelected) {
            return {
                selected: initialSelected || [],
            }
        }

        function facilitySliceSelection(initialSelected) {
            return {
                selected: initialSelected || [],
            }
        }
    </script>
@endsection
