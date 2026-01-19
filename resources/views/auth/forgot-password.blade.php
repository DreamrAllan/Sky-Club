@extends('layouts.auth')
@section('content')
    {{-- form forgot password --}}
    <div class=" w-512px">
        <img class="mb-9" src="{{ asset('assets/icons/icon_auth.svg') }}" alt="">
        <div class=" space-y-4 mb-12">
            <a href="{{ route('login') }}" class="flex space-x-1">
                <img src="{{ Storage::url('images/arrow_left.svg') }}" alt=""><span>Back to login</span>
            </a>
            <h4 class="text-4xl font-bold">Forgot your password?</h4>
            <p class="text-base">Don’t worry, happens to all of us. Enter your email below to recover your password
            </p>
            @if (session()->has('errorForgot'))
                <div id="alert-2"
                    class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm font-medium">
                        {{ session()->get('errorForgot') }}
                    </div>
                    <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                        data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <form action="{{ route('forgotPassword.validate') }}" method="POST">
            @csrf
            <div class="space-y-6 mb-8">
                <div class="relative">
                    <input type="text" name="username" placeholder="username"
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                    <label for="username"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Username</label>
                </div>
                <div class="relative ">
                    <input type="text" name="no_telp" placeholder="no_telp"
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="number"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Number</label>
                </div>
            </div>
            <button type="submit" class=" bg-red-600 rounded py-2 font-semibold text-white w-full">Submit</button>
        </form>
        <div class="flex items-center mt-10">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="px-4 text-gray-400">atau masuk dengan</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>
    </div>
    {{-- Carousel --}}
    <x-auth-carousel />
@endsection
