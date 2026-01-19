@php
    use Carbon\Carbon;
@endphp
<div x-data="{
    open: false,
    cancelBookingModal: false,
    scheduleModal: false,
    sparingModal: false,
    proofTransfer: false
}" class="min-h-full bg-gray-200 shadow rounded-lg">
    <div class=" bg-white rounded-lg py-8 px-6 flex justify-between items-center">
        <div class="bg-cover rounded-xl overflow-hidden group w-20 h-20">
            <img class="w-full h-full object-cover"
                src="{{ asset('storage/field/images/' . $sesi->field->photos->first()->photo) }}" alt="">
        </div>
        <div class="flex items-center gap-6 ">
            <p class="font-bold text-xl">{{ $sesi->field->name }}</p>
            <div class="border-l border-gray-400 h-8 my-auto"></div>
            <div>
                {{-- <p class="font-xs ">22 September 2024</p> --}}
                <p class="font-xs ">{{ $sesi->formatted_date }}</p>
                <p class="font-semibold">{{ $sesi->formatted_session }}</p>
            </div>
            <div class="border-l border-gray-400 h-8 my-auto"></div>
            <p class="font-semibold">{{ $sesi->field->formatted_price }}</p>
            {{-- <p class="font-semibold">Rp 1.000.000</p> --}}
        </div>
        {{-- <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Red</span>
            <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Green</span>
            <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Yellow</span> --}}
        <div
            class="
            @if ($sesi->status_request) @switch($sesi->status_request)
                    @case('reschedule')
                        bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300
                        @break
                    @case('request-reschedule')
                    @case('request-cancel')
                        bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300
                        @break
                    @case('cancel')
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                        @break
                    @default
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                @endswitch
            @else
                @switch($booking->status)
                    @case('accept')
                        bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300
                        @break
                    @case('pending')
                        bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300
                        @break
                    @case('failed')
                    @case('canceled')
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                        @break
                    @default
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                @endswitch @endif
            ">
            {{ $sesi->formattedStatusRequest ?? $booking->formatted_status }}
        </div>
        <div>
            <button @click="open = !open" class="size-12 p-2.5 border border-black rounded-lg">
                <img x-show="!open" src="{{ asset('assets/icons/icon-angle-right.svg') }}" alt="">
                <img x-show="open" src="{{ asset('assets/icons/icon-angle-down.svg') }}" alt="">
            </button>
        </div>
    </div>
    <div x-show="open" class="py-7 mx-6 flex justify-between">
        <div class="grid grid-cols-3 gap-14">
            <div class=" space-y-7">
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">Tanggal Pemesanan</h6>
                    <p>{{ $booking->formatted_order_date }}</p>
                </div>
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">Alamat</h6>
                    <p>{{ $booking->rentedBy->address ?? '-' }}</p>
                </div>
                <div>
                    @if ($booking->status == 'accept' && $sesi->status_request == null)
                        <a href="{{ route('schedule.reschedule', $sesi->id) }}" @click="scheduleModal = true"
                            class="my-3 px-6 py-3 bg-red-700 text-white font-bold rounded-lg">Ubah Jadwal</a>
                    @endif
                </div>
            </div>
            <div class=" space-y-7">
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">Pemesanan</h6>
                    <p>{{ $booking->rentedBy->name }}</p>
                </div>
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">No. Telepon</h6>
                    <p>{{ $booking->rentedBy->no_telp }}</p>
                </div>

                {{-- <div  @click="isWithinRange(day.date) && selectDate(day.date)" :class="{
                    'bg-red-500 text-white': isSelected(day.date),
                    'text-gray-400': !isWithinRange(day.date),
                    }"
                    class="cursor-pointer text-center w-16 p-2 rounded-md">
                    <div class="text-xs font-medium" x-text="day.name"></div>
                    <div class="text-sm font-semibold"
                        x-text="day.date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })">
                    </div>
                </div> --}}

                <div>
                    @if ($booking->status == 'accept' && $sesi->status_request == null)
                        <a @click="cancelBookingModal = true"
                            class="my-3 px-6 py-3 bg-red-700 text-white font-bold rounded-lg">Batalkan</a>
                    @endif
                </div>
            </div>
            <div class=" space-y-7">
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">Username</h6>
                    <p>{{ $booking->rentedBy->username }}</p>
                </div>
                <div class=" space-y-1">
                    <h6 class="font-semibold text-sm">Email</h6>
                    <p>{{ $booking->rentedBy->email }}</p>
                </div>
                <div>
                    @if (!$sesi->sparing && $booking->status == 'accept' && $sesi->status_request == null)
                        <button @click="sparingModal = true"
                            class="my-3 px-6 py-3 bg-red-700 text-white font-bold rounded-lg">Jadikan Sparing</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <h4 class=" font-bold font-sm">Bukti Transfer</h4>
            <button @click="proofTransfer = true" class="bg-cover rounded-xl overflow-hidden group w-79 h-45">
                <img class="w-full h-full object-cover"
                    src="{{ route('booking.paymentImage', basename($booking->uploud_payment)) }}" alt="">
            </button>
        </div>
    </div>

    <!-- Proof Transfer Modal -->
    <div x-show="proofTransfer" @click.away="proofTransfer = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.stop class="bg-white p-2 rounded-lg justify-center flex flex-col text-center">
            <div class="bg-cover rounded-lg overflow-hidden group w-79 h-45">
                <img class="w-full h-full object-cover"
                    src="{{ route('booking.paymentImage', basename($booking->uploud_payment)) }}" alt="">
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div x-show="cancelBookingModal" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-20">
        <div class="bg-white p-6 rounded-lg justify-center flex flex-col text-center">
            <h2 class="text-xl font-bold mb-4 font-2xl">Yakin ingin batalkan pesanan?</h2>
            <p>Konfirmasi Pembatalan Pemesanan Anda</p>
            <div class="mt-4 flex justify-center">
                <button @click="cancelBookingModal = false"
                    class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Kembali</button>
                <form action="{{ route('schedule.cancel', $sesi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded-lg">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Schedule Modal -->
    {{-- <div x-show="scheduleModal" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-20">
        <form action="" method="POST" class="bg-white p-4 rounded-lg w-80">
            @csrf
            <div>
                <label for="nama_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Tim</label>
                <input type="text" id="nama_tim"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukan nama tim" required />
            </div>
            <div>
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                    Singkat</label>
                <input type="text" id="deskripsi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukan deskripsi singkat" required />
            </div>
            <div class="mt-4 flex justify-end">
                <button @click="scheduleModal = false" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div> --}}

    <!-- Sparing Modal -->
    <div x-show="sparingModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <form action="{{ route('sparing.store') }}" method="POST" class="bg-white p-4 rounded-lg w-80">
            @csrf
            <div class="mb-6">
                <label for="nama_tim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Tim</label>
                <input type="text" id="nama_tim" name="team_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukan nama tim" value="{{ Auth::user()->team ?? '' }}" />
            </div>
            <div class="mb-6">
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                    Singkat</label>
                <input type="text" id="deskripsi" name="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukan deskripsi singkat" value="" />
            </div>
            <div class="flex justify-end">
                <button @click="sparingModal = false" type="button"
                    class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Cancel</button>
                <input type="hidden" name="id_list_booking" value="{{ $sesi->id }}">
                <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- @push('scripts')
    <script>
        function canCancel() {
            return
        }
    </script>
@endpush --}}
