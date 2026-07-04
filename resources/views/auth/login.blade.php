@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-white px-10">
    <div class="w-full max-w-5xl flex items-center justify-between gap-20">
        {{-- LEFT --}}
        <div class="w-1/2">

            {{-- TITLE --}}
            <div class="mb-16 mt-10">
                <h1 class="text-2xl font-bold text-center mb-5">
                    Welcome Back!
                </h1>

                <p class="text-center text-gray-700 text-sm leading-relaxed">
                    Akses informasi praktikum dan arsip laporan Anda dalam satu platform terintegrasi.
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-7">
                    {{-- USERNAME --}}
                    <div>
                        <div class="relative">
                            <i class="fa-regular fa-user absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500"
                                required autofocus autocomplete="username" placeholder="Email PNC">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-xl"></i>
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">                 
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror   
                    </div>
                </div>

                {{-- FORGOT PASSWORD --}}
                @if (Route::has('password.request'))
                    <div class="flex justify-end mt-5">
                        <a href="{{ route('password.request') }}"
                            class="text-sm hover:underline hover:text-blue-600">
                            Lupa password?
                        </a>
                    </div>
                @endif

                {{-- BUTTON --}}
                <button type="submit" class="w-full bg-black text-white py-3 rounded-full text-sm font-semibold mt-6 hover:bg-[#4171BD] transition"> Login </button>
            </form>

            {{-- REGISTER --}}
            <div class="mt-32 text-center text-sm">
                <span class="text-gray-700"> Belum memiliki akun? </span>
                <a href="{{ route('register') }}" class="font-bold hover:underline hover:text-blue-600"> Register </a>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="w-1/2">
            <div class="bg-[#dfe7f1] rounded-[40px] h-[600px] flex items-center justify-center p-10">
                <img src="https://about-analysis.com/wp-content/uploads/2022/01/Data-report-bro-1024x1024.png"
                alt="Login Illustration"
                class="w-full max-w-[550px]">
            </div>
        </div>
    </div>
</div>

@endsection