@extends('layouts.mahasiswa')

@section('content')

<div class="mt-4 ml-[210px]">

    <h1 class="text-lg font-bold mb-4">
        Dashboard
    </h1>
    <hr class="border-gray-400 my-6">

    {{-- CARD RINGKASAN --}}
    <div class="grid grid-cols-3 gap-6 mb-14">

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Jumlah Praktikum Aktif
            </p>

            <h2 class="text-3xl font-bold text-center">
                5
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Total Laporan Dikumpulkan
            </p>

            <h2 class="text-3xl font-bold text-center">
                16
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Laporan Belum Dikumpulkan
            </p>

            <h2 class="text-3xl font-bold text-center">
                3
            </h2>
        </div>

    </div>

    {{-- PRAKTIKUM --}}
    <div class="mb-14">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">
                Praktikum - Terakhir Dibuka
            </h2>

            <a href="/mahasiswa/praktikum" class="text-sm text-blue-400 hover:text-black">
                Lihat lainnya
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6">

            @for ($i = 0; $i < 3; $i++)

            <div class="bg-gradient-to-br from-[#4171BD] to-purple-300 rounded-2xl p-6 text-white h-[140px]">

                <h3 class="text-base font-semibold mb-6">
                    Praktikum Pemrograman Berbasis Framework
                </h3>

                <p class=" text-sm text-white/80">
                    Fajar Mahardika, S.Kom., M.Kom.
                </p>

            </div>

            @endfor

        </div>

    </div>

    {{-- DEADLINE --}}
    @php
        $deadlines = [
            [
                'judul' => 'Praktikum Pemrograman Framework',
                'tanggal' => 'Hari ini - 23.59'
            ],
            [
                'judul' => 'Praktikum Basis Data',
                'tanggal' => '18 April 2026 - 23.59'
            ],
            [
                'judul' => 'Praktikum Mobile',
                'tanggal' => '19 April 2026 - 23.59'
            ],
        ];
    @endphp

    <div>

        <h2 class="text-lg font-bold mb-4">
            Deadline Mendatang
        </h2>

        <div class="bg-white rounded-2xl p-6 py-2 border">

            @foreach ($deadlines as $deadline)

            <div class="flex items-center gap-5 py-4 border-b last:border-0">

                <div class="w-8 h-8 rounded-lg bg-pink-200">

                </div>

                <div>
                    <h3 class="text-base font-semibold">
                        {{ $deadline['judul'] }}
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        {{ $deadline['tanggal'] }}
                    </p>
                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

@endsection