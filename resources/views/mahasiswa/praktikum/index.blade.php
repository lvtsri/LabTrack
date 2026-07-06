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
            <a href="{{ route('mahasiswa.praktikum.show', $item->id_praktikum) }}" 
                class="block rounded-2xl bg-gradient-to-r from-[#4f80d1] to-[#d6a8d6] text-white p-6 hover:shadow-lg hover:-translate-y-1 transition">
                <h2 class="text-xl font-semibold">
                    {{ $item->nama_praktikum }}
                </h2>
                <p class="mt-3">
                    Semester {{ $item->semester }}
                </p>
                <p class="mt-2 text-white/80">
                    {{ $item->dosen->name }}
                </p>
            </a>
        @endforeach

    </div>
</div>

@endsection