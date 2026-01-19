@extends('layouts.master')
@section('content')
    {{-- Banner --}}
    <div class="flex flex-col items-center">
        <div class=" relative bg-cover rounded-xl overflow-hidden group w-full h-banner-profile">
            <img class="w-full h-full object-cover" src="{{ asset('assets/images/album_1.svg') }}" alt="">
            <a href="/" class="absolute bottom-5 right-5 bg-red-600 rounded px-4 py-2 font-semibold text-white">Lihat
                Semua Foto</a>
        </div>
        {{-- <div class="relative" x-data="{ profileImage: '/storage/{{ $data_user->profile_photo ?? asset('assets/icons/profile.svg') }}' }"> --}}
        <div class="relative" x-data="{ profileImage: '{{ $data_user->formattedProfilePhoto }}' }">
            <div class="-mt-20 relative bg-cover rounded-full overflow-hidden group size-40 ring-4 ring-red-700">
                <img id="profileImage" class="profile-image w-full h-full object-cover" :src="profileImage"
                    alt="">
                {{-- src="{{ asset('storage/profile-photo/' . $data_user->profile_photo) }}" alt=""> --}}
                <input name="photo" type="file" id="imageUploud"
                    x-on:change="updateProfileImage($event.target.files[0])" accept="image/*" class="hidden">
            </div>
            <label for="imageUploud" class="absolute bottom-0 right-0 p-2.5 bg-red-600 rounded-full">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                        clip-rule="evenodd" />
                </svg>
            </label>
            {{-- <img class="absolute top-0 left-0 -mt-20" src="{{ asset('assets/icons/verified.svg') }}" alt=""> --}}
        </div>
    </div>

    {{-- profile --}}
    <div class="mt-8 flex flex-col items-center space-y-2">
        <h5 class=" text-2xl font-semibold">{{ $data_user->name }}</h5>
        <p class="text-base text-gray-700">{{ $data_user->email }}</p>
    </div>

    {{-- tab --}}
    {{-- <div x-data="{ activeTab: 'account', activeBookingTab: 'field' }"> --}}
    <div x-data="{ activeTab: '{{ session()->has('activeTab') ? session('activeTab') : 'account' }}', activeBookingTab: '{{ session()->has('activeBookingTab') ? session('activeBookingTab') : 'field' }}' }">
        <!-- Tab Menu for Account and History -->
        <div class="mt-8 pt-4 px-6 shadow bg-white rounded-lg">
            <div class="flex justify-evenly flex-wrap -mb-px text-sm font-semibold" role="tablist">
                <div class="text-center px-60 py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeTab === 'account' }">
                    <button @click="activeTab = 'account'" class="inline-block">Account</button>
                </div>
                <div class="border-l border-gray-400 h-7 my-auto"></div>
                <div class="text-center px-60 py-4"
                    :class="{ 'text-red-600 border-b-4 border-black': activeTab === 'history' }">
                    <button @click="activeTab = 'history'" class="inline-block">History</button>
                </div>
            </div>
        </div>

        <!-- Account Tab Content -->
        <div x-show="activeTab === 'account'" class="mt-10">
            <h2 class="font-bold text-3xl mb-4">Account</h2>

            {{-- modal --}}
            <div id="alert-1"
                class="hidden flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    Berhasil Melakukan Update
                </div>
                <button type="submit"
                    class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <div class="px-6 py-8 rounded-lg bg-gray-200 space-y-8">
                <!-- Account Details -->
                <div class="flex justify-between items-center">
                    <div>
                        <p>Nama</p>
                        <div class="relative z-0">
                            <input type="text" id="name"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="Nama" value="{{ $data_user->name }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p>Email</p>
                        <div class="relative z-0">
                            <input type="text" id="email"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="Email" value="{{ $data_user->email }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p>No Handphone</p>
                        <div class="relative z-0">
                            <input type="text" id="no_telp"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="No Handphone" value="{{ $data_user->no_telp }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p>address</p>
                        <div class="relative z-0">
                            <input type="text" id="address"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="address" value="{{ $data_user->address }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p>date_of_birth</p>
                        <div class="relative z-0">
                            <input type="date" id="date_of_birth"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="date_of_birth" value="{{ $data_user->date_of_birth }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="space-y2">
                        <p>team</p>
                        <div class="relative z-0">
                            <input type="text" id="team"
                                class="font-semibold text-xl block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer"
                                placeholder="team" value="{{ $data_user->team }}" />
                        </div>
                    </div>
                    <button onclick="updateUser({{ $data_user->id }})"
                        class="py-3 px-6 border-2 border-red-500 items-center flex rounded-lg space-x-1 text"
                        href="/">
                        <img src="{{ asset('assets/icons/icon-change.svg') }}" alt="">
                        <p>Change</p>
                    </button>
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
                        @if ($sesi->sparing == null)
                            <x-drop-booking :booking="$booking" :sesi="$sesi" />
                        @endif
                    @endforeach
                @empty
                    <p>Tidak ada jadwal yang telah dipesan</p>
                @endforelse
            </div>
            <div x-show="activeBookingTab === 'sparing'" class="mt-8 space-y-10">
                @foreach ($sparings as $sparing)
                    @if ($sparing->request->isEmpty())
                        <x-drop-sparing-no-request :sparing="$sparing" />
                    @endif
                @endforeach
                @forelse ($request_sparing as $req_sparing)
                    <x-drop-sparing :sparing="$req_sparing" />
                @empty
                    <p>Tidak ada pengajuan sparing</p>
                @endforelse

                {{-- @foreach ($sparing->request as $req_sparing)
                            <x-drop-sparing :sparing="$req_sparing" />
                        @endforeach --}}
                {{-- @dd($sparing->request, $sparing->request->isEmpty() ? 'null' : 'ok') --}}
                {{-- @dd($sparing->request == [] ? 'nukk' : 'ok') --}}
                {{-- @forelse ($request_sparing as $req_sparing)
                            <x-drop-sparing :sparing="$req_sparing" />
                        @empty
                            <p>Tidak ada pengajuan sparing</p>
                        @endforelse --}}
            </div>
            <div x-show="activeBookingTab === 'finish'" class="mt-8 space-y-10">
                @forelse ($history_booking_sparing as $history)
                    @if ($history->getTable() == 'bookings')
                        @foreach ($history->listBooking as $booking)
                            @if ($booking->date < now())
                                <x-drop-history-booking :listbooking="$booking" />
                            @endif
                        @endforeach
                    @else
                        <x-drop-history-sparing :sparing="$history" />
                    @endif
                @empty
                    <p>Tidak ada riwayat pesanan atau sparing</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Error Modal -->
    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
        class=" hidden block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Toggle modal
    </button>
    @if (session()->has('error'))
        <div id="popup-modal" tabindex="-1"
            class="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ session('error') }}
                        </h3>
                        <button data-modal-hide="popup-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('script')
    <script>
        function updateUser(id) {
            const userId = id;
            const name = document.querySelector('#name').value;
            const email = document.querySelector('#email').value;
            const no_telp = document.querySelector('#no_telp').value;
            const address = document.querySelector('#address').value;
            const date_of_birth = document.querySelector('#date_of_birth').value;
            const team = document.querySelector('#team').value;
            axios.put('/profile-user', {
                id: userId,
                name: name,
                email: email,
                no_telp: no_telp,
                address: address,
                date_of_birth: date_of_birth,
                team: team
            }).then((response) => {

                document.getElementById('alert-1').classList.remove('hidden');
            }).catch((error) => {
                console.error(error);
            })
        }

        function updateProfileImage(file) {
            const formData = new FormData();
            formData.append('photo', file);
            axios.post('/profile-user/image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.profileImage = response.data.photo;
                    document.getElementById('profileImage').src = response.data.photo;
                })
                .catch(error => {
                    console.error('Error uploading profile image:', error);
                });
        }
    </script>
@endpush
