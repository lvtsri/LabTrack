@extends('layouts.mahasiswa')

@section('content')

<div class="mt-4 ml-[210px]">

    <div class="mb-6">
        <h1 class="text-lg font-bold mb-2">
            Praktikum
        </h1>

        <p class="text-sm text-gray-500">
            Akses seluruh kelas praktikum beserta materi dan tugas yang tersedia.
        </p>

        <hr class="border-gray-400 mt-4">
    </div>

    @if($praktikum->isEmpty())

        <div class="bg-white rounded-3xl border p-10 text-center text-gray-500">

            Belum ada praktikum untuk kelas Anda.

        </div>

    @else

        <div class="grid grid-cols-2 gap-6">

            @foreach($praktikum as $item)

            <div class="bg-white rounded-3xl border p-8 shadow-sm">

                <h2 class="font-bold text-lg">
                    {{ $item->nama_praktikum }}
                </h2>

                <p class="text-gray-500 mt-2">
                    {{ $item->kelas->nama_kelas }}
                </p>

                <p class="text-gray-500">
                    Dosen :
                    {{ $item->dosen->name }}
                </p>

                <p class="text-gray-500">
                    Semester {{ $item->semester }}
                </p>

                <div class="mt-6">

                    <a
                        href="#"
                        class="bg-[#415BE7] text-white px-5 py-2 rounded-xl">

                        Lihat Detail

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    @endif

</div>

@endsection