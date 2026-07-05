@extends('layouts.mahasiswa')

@section('content')

<div class="mt-4 ml-[210px]">
    <div class="mb-6">
        <h1 class="text-lg font-bold mb-2">
            Praktikum
        </h1>
        <p class="text-sm text-gray-500">Akses seluruh kelas praktikum beserta materi dan tugas yang tersedia.</p>
        <hr class="border-gray-400 mt-4">
    </div>
</div>

<div class="mt-4 ml-[210px]">
    <div class="grid grid-cols-3 gap-6 mt-8">

        @foreach($praktikum as $item)
            <div class="rounded-2xl bg-gradient-to-r from-[#4f80d1] to-[#d6a8d6] text-white p-6">
                <h2 class="text-xl font-semibold">
                    {{ $item->nama_praktikum }}
                </h2>
                <p class="mt-3">
                    Semester {{ $item->semester }}
                </p>
                <p class="mt-2 text-white/80">
                    {{ $item->dosen->name }}
                </p>
            </div>
        @endforeach

    </div>
</div>

@endsection