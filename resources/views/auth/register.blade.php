@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-white px-10">

    <div class="w-full max-w-5xl flex items-center justify-between gap-20">

        {{-- LEFT - IMAGE --}}
        <div class="w-1/2">
            <div class="bg-[#dfe7f1] rounded-[40px] h-[600px] flex items-center justify-center p-10">

                <img src="https://about-analysis.com/wp-content/uploads/2022/01/Data-report-bro-1024x1024.png"
                alt="Login Illustration"
                class="w-full max-w-[550px]">

            </div>
        </div>

        {{-- RIGHT - FORM --}}
        <div class="w-1/2">
            {{-- TITLE --}}
            <div class="mb-10 mt-10">
                <h1 class="text-2xl font-bold text-center mb-5">
                    Let's Get Started!
                </h1>
                <p class="text-center text-gray-700 text-sm leading-relaxed">
                    Mulai perjalanan praktikum Anda untuk pengalaman pengelolaan praktikum yang lebih terorganisir.
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-7">
                    {{-- USERNAME --}}
                    <div class="relative">
                        <i class="fa-regular fa-user absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Username"
                            class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" spellcheck="false" placeholder="Email PNC"
                            class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-xl"></i>
                        <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Password"
                            class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-xl"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Konfirmasi Password"
                            class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                    </div>
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="w-full bg-black text-white py-3 rounded-full text-sm font-semibold mt-6 hover:bg-[#4171BD] transition"> 
                    Register 
                </button>
            </form>

            {{-- LOGIN LINK --}}
            <div class="mt-16 text-center text-sm">
                <span class="text-gray-700"> Sudah memiliki akun? </span>
                <a href="{{ route('login') }}" class="font-bold hover:underline hover:text-blue-600"> Login </a>
            </div>
        </div>
    </div>
</div>

@endsection