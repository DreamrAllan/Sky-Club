@extends('layouts.master')
@section('content')
    @php
        $tgl = $generateSchedules->now->format('Y-m-d');
    @endphp
    <div x-data='{activeTab: "{{ $tgl }}"}'>
        {{-- tombol tanggal --}}
        <div x-data='{ schedules: @json($schedules[0])}'>
            <template x-for="schedule in schedules" :key="schedule.date">
                <button @click="activeTab = schedule.date" :class="{ 'bg-blue-500 text-white': activeTab === schedule.date }"
                    class="px-4 py-2 m-2 rounded" x-text="schedule.date">
                    Date
                </button>
            </template>
        </div>

        {{-- tombol pilihan sesi --}}
        <p class="mb-3 text-gray-500 dark:text-gray-400" x-text="activeTab"></p>
        <div x-data='{ schedules: @json($schedules[0]) }'>
            <template x-for="schedule in schedules" :key="schedule.date">
                <div x-show="activeTab == schedule.date">
                    <template x-for="(session, index) in schedule.sessions">
                        <button class="px-4 py-2 m-2 rounded"
                            :class="{
                                'bg-blue-500 text-white': session !== false,
                                'bg-gray-500 text-gray-300 cursor-not-allowed': session === false
                            }"
                            @click="$store.cart.addItem({schedule: schedule.date, session: index+1, price:schedule.price})"
                            :disabled="session === false">
                            <span x-text="index+1"></span>
                        </button>
                    </template>
                </div>
            </template>
        </div>

        {{-- ala-ala keranjang --}}
        <template x-for='(item, index) in $store.cart.items' :key="index">
            <div id="toast-success"
                class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal" x-text="item.schedule"></div>
                <div class="ms-3 text-sm font-normal" x-text="item.session"></div>
                <div class="ms-3 text-sm font-normal" x-text="item.price"></div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-success" aria-label="Close" @click="$store.cart.removeItem(index)">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </template>

        {{-- kirim data ke server --}}
        <form action="{{ route('booking.scheduleValidate') }}" method="POST">
            @csrf
            <template x-for="(item, index) in $store.cart.items" :key="index">
                <div>
                    <input type="hidden" :name="schedule[${index}]" :value="item.schedule">
                    <input type="hidden" :name="session[${index}]" :value="item.session">
                    <input type="hidden" :name="price[${index}]" :value="item.price">
                </div>
            </template>
            <button type="submit" class="px-4 py-2 m-2 rounded bg-blue-500 text-white">Bayar</button>
        </form>
    </div>
@endsection

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: JSON.parse(sessionStorage.getItem('cartItems')) || [],
                addItem(item) {
                    this.items.push(item);
                    sessionStorage.setItem('cartItems', JSON.stringify(this.items));
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                    sessionStorage.setItem('cartItems', JSON.stringify(this.items));
                }
            });
        });
    </script>
