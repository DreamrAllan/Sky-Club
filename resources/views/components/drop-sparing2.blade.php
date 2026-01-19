<div x-data="{ open: false, cancelSparingModal: false }" class="min-h-full bg-gray-200 shadow rounded-lg">
    <div class=" bg-white rounded-lg py-8 px-6 flex justify-between items-center">
        <div class="bg-cover rounded-xl overflow-hidden group w-20 h-20">
            <img class="w-full h-full object-cover"
                src="{{ asset('storage/field/images/' . $sparing->listBooking->field->photos->first()->photo) }}"
                alt="">
        </div>
        <div class="flex items-center gap-6 ">
            <p class="font-bold text-xl">{{ $sparing->listBooking->field->name }}</p>
            <div class="border-l border-gray-400 h-7 my-auto"></div>
            <p class="font-bold">{{ $sparing->createdBy->team }}</p>
            {{-- <p class="font-bold">Real Madrid vs Manchester United</p> --}}
            <div class="border-l border-gray-400 h-7 my-auto"></div>
            <div>
                <p class="font-xs ">{{ $sparing->listBooking->formatted_date }}</p>
                <p class="font-semibold">{{ $sparing->listBooking->formatted_session }}</p>
            </div>
        </div>
        <div
            class="
                @switch($sparing->status)
                    @case('accepted')
                        bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300
                        @break
                    @case('waiting')
                        bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300
                        @break
                    @case('rejected')
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                        @break
                    @default
                        bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300
                @endswitch
        ">
            {{ $sparing->status }}
        </div>
        <div>
            <button @click="open = !open" class="size-12 p-2.5 border border-black rounded-lg">
                <img x-show="!open" src="{{ asset('assets/icons/icon-angle-right.svg') }}" alt="">
                <img x-show="open" src="{{ asset('assets/icons/icon-angle-down.svg') }}" alt="">
            </button>
        </div>
    </div>
    <div x-show="open" class="py-7 mx-6 " class="p-4 text-gray-500 overflow-hidden">
        <div class="flex justify-between items-center">
            <div class="flex gap-10">
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Tanggal Pemesanan</h6>
                        <p>{{ $sparing->listBooking->booking->formatted_order_date }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Alamat</h6>
                        <p>{{ $sparing->createdBy->address ?? '-' }}</p>
                    </div>
                </div>
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Pemesan</h6>
                        <p>{{ $sparing->createdBy->name }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">No. Telepon</h6>
                        <p>{{ $sparing->createdBy->no_telp }}</p>
                    </div>
                </div>
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Username</h6>
                        <p>{{ $sparing->createdBy->username }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Email</h6>
                        <p>{{ $sparing->createdBy->email }}</p>
                    </div>
                </div>
            </div>
            <div class="border-l border-gray-400 h-32 my-auto"></div>
            {{-- <div class="flex gap-10">
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Tanggal Pengajuan</h6>
                        <p>{{ $req_sparing->created_at }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Alamat</h6>
                        <p>{{ $req_sparing->user->address ?? '-' }}</p>
                    </div>
                </div>
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Penantang</h6>
                        <p>{{ $req_sparing->user->name }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">No. Telepon</h6>
                        <p>{{ $req_sparing->user->no_telp }}</p>
                    </div>
                </div>
                <div class=" space-y-7">
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Username</h6>
                        <p>{{ $req_sparing->user->username }}</p>
                    </div>
                    <div class=" space-y-1">
                        <h6 class="font-semibold text-sm">Email</h6>
                        <p>{{ $req_sparing->user->email }}</p>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="flex space-x-28 items-center mt-8 justify-self-center">
            <div class="bg-cover rounded-full overflow-hidden group size-16">
                <img class="w-full h-full object-cover" src="{{ $sparing->createdBy->formattedProfilePhoto }}"
                    alt="">
            </div>
            {{-- @if ($req_sparing->status_request != 'accepted' && $req_sparing->id_user !== Auth::id())
                <div>
                    <form action="{{ route('sparing.accept', $req_sparing) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="my-3 px-6 py-3 bg-yellow-200 text-red-700 font-bold rounded-lg">Konfirmasi</button>
                    </form>
                </div>
                <div>
                    <button @click="cancelSparingModal = true"
                        class="my-3 px-6 py-3 bg-red-700 text-white font-bold rounded-lg">Batalkan</button>
                </div>
            @else
                <p>VS</p>
            @endif
            <div class="bg-cover rounded-full overflow-hidden group size-16">
                <img class="w-full h-full object-cover" src="{{ $req_sparing->user->formatted_profile_photo }}"
                    alt="">
            </div> --}}
        </div>
    </div>

    <!-- Cancel Modal -->
    {{-- <div x-show="cancelSparingModal" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-20">
        <div class="bg-white p-6 rounded-lg justify-center flex flex-col text-center">
            <h2 class="text-xl font-bold mb-4 font-2xl">Yakin ingin batalkan pesanan?</h2>
            <p>Konfirmasi Pembatalan Pemesanan Anda</p>
            <div class="mt-4 flex justify-center">
                <button @click="cancelSparingModal = false"
                    class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Kembali</button>
                <form action="{{ route('sparing.reject', $req_sparing) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="px-4 py-2 bg-red-700 text-white rounded-lg">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div> --}}
</div>
