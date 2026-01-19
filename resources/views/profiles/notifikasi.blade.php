@extends('layouts.master')
@section('content')
    <div class="mt-17.5 mb-5">
        <p class="font-semibold text-base mb-4">Notifikasi</p>
        <h1 class="font-bold text-5xl mb-6">Notifikasi</h1>
        <p class="text-lg">Berikut adalah list notifikasi yang tersedia saat ini.</p>
    </div>
    <div class="w-full space-y-2.5 py-2">
        @forelse ($notifications as $notification)
            <div class="px-4 py-2 rounded-lg shadow flex justify-between items-center text-base">
                <div class="flex items-start">
                    {{-- <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox"
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                            required="">
                    </div>
                    <div class="ml-9 text-sm">
                        <label for="remember"
                            class="text-black dark:text-gray-300 font-medium">{{ $notification->data['type'] }}</label>
                    </div> --}}
                    <form action="{{ route('notification.markAsRead', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Lihat</button>
                    </form>
                </div>
                <span
                    class="{{ $notification->read_at ? 'font-normal' : 'font-bold' }}">{{ $notification->data['message'] }}</span>
                <span>{{ $notification->created_at->format('d M Y | H:i') }}</span>
            </div>
        @empty
            <p>Tidak Ada Notifikasi</p>
        @endforelse
    </div>
@endsection
