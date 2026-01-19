@extends('layouts.auth')
@section('content')
    {{-- carousel --}}
    <x-auth-carousel />
    {{-- form Register --}}
    <div class=" w-600px">
        <img class="mb-9" src="{{ asset('assets/icons/icon_auth.svg') }}" alt="">
        <div class=" space-y-4 mb-12">
            <h4 class="text-4xl font-bold">Sign up</h4>
            <p class="text-base">Let’s get you all st up so you can access your personal account.</p>
        </div>
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="space-y-6 mb-10">
                <div class="sm:flex sm:space-x-6">
                    <div class="relative w-full">
                        <input type="text" name="name" placeholder="name"
                            class="w-full block px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 mb-6 sm:mb-0
                            @error('name')
                                bg-red-50 border  focus:ring-red-500 dark:bg-gray-700 p-2.5 dark:placeholder-red-500
                            @enderror"
                            value="{{ old('name') }}" required />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ $message }}</p>
                        @enderror
                        <label for="name"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Name</label>
                    </div>
                    <div class="relative w-full">
                        <input type="text" name="username" placeholder="username"
                            class="w-full block px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600
                            @error('username')
                                bg-red-50 border placeholder-red-700 focus:ring-red-500 dark:bg-gray-700 p-2.5 dark:placeholder-red-500
                            @enderror"
                            value="{{ old('username') }}" required />
                        @error('username')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ $message }}</p>
                        @enderror
                        <label for="username"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Username</label>
                    </div>
                </div>

                <div class="sm:flex sm:space-x-6">
                    <div class="relative w-full">
                        <input type="email" name="email" placeholder="email"
                            class="w-full block px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 mb-6 sm:mb-0
                            @error('email')
                                bg-red-50 border placeholder-red-700 focus:ring-red-500 dark:bg-gray-700  p-2.5 dark:placeholder-red-500
                            @enderror"
                            value="{{ old('email') }}" required />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ $message }}</p>
                        @enderror
                        <label for="email"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Email</label>
                    </div>
                    <div class="relative w-full">
                        <input type="text" name="no_telp" placeholder="no_telp"
                            class="w-full block px-2.5 pb-2.5 pt-4 text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600
                            @error('no_telp')
                                bg-red-50 border placeholder-red-700 focus:ring-red-500 dark:bg-gray-700 p-2.5 dark:placeholder-red-500
                            @enderror"
                            value="{{ old('no_telp') }}" required />
                        @error('no_telp')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ $message }}</p>
                        @enderror
                        <label for="no_telp"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Number</label>
                    </div>
                </div>

                <div class="relative">
                    <input type="password" name="password" placeholder="password" required
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600
                        @error('password')
                                bg-red-50 border placeholder-red-700 focus:ring-red-500 dark:bg-gray-700 p-2.5 dark:placeholder-red-500
                            @enderror"
                        required />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ $message }}</p>
                    @enderror
                    <label for="password"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Password</label>
                </div>

                <div class="relative">
                    <input type="password" name="password_confirmation"
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 "
                        placeholder=" " />
                    <label for="password_confirmation"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Confirm
                        Password</label>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox"
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                            required="">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="text-gray-500 dark:text-gray-300">I agree to all the <a
                                href="/">Terms</a> and <a href="/">Privacy Policies</a></label>
                    </div>
                </div>
            </div>
            <button type="submit" class=" bg-red-600 rounded py-2 font-semibold text-white w-full">Create
                Account</button>
        </form>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center mt-4">
            Already have an account? <a href="/login"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login</a>
        </p>
        <div class="flex items-center mt-10">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="px-4 text-gray-400">Or sign up with</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>
        <div class="flex mt-10 space-x-4 ">
            <div class=" border w-full py-4 border-black rounded">
                <img class="mx-auto" src="{{ asset('assets/icons/facebook.svg') }}" alt="">
            </div>
            <div class=" border w-full py-4 border-black rounded">
                <img class="mx-auto" src="{{ asset('assets/icons/google.svg') }}" alt="">
            </div>
            <div class=" border w-full py-4 border-black rounded">
                <img class="mx-auto" src="{{ asset('assets/icons/apple.svg') }}" alt="">
            </div>
        </div>
    </div>
@endsection
