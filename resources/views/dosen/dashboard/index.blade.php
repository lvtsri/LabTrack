@extends('layouts.dosen')

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
                Total Laporan Masuk
            </p>

            <h2 class="text-3xl font-bold text-center">
                {{ $totalLaporan }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Total Laporan Belum Direview
            </p>

            <h2 class="text-3xl font-bold text-center">
                {{ $belumDireview }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Jumlah Kelas Praktikum
            </p>

            <h2 class="text-3xl font-bold text-center">
                {{ $jumlahPraktikum }}
            </h2>
        </div>

    </div>

    {{-- PRAKTIKUM --}}
    <div class="mb-14">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">
                Praktikum yang Diampu
            </h2>

            <a href="/dosen/praktikum" class="text-sm font-semibold text-blue-400 hover:text-black">
                Lihat lainnya
            </a>
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach($praktikum as $item)
            <a href="{{ route('dosen.praktikum.show', $item) }}" class="bg-[#586ce0] rounded-2xl p-6 text-white h-[125px]">
                <h3 class="text-base font-semibold">
                    {{ $item->nama_praktikum }}
                </h3>

                <p class="text-sm text-white/80">
                    Semester {{ $item->semester }} | {{ $item->kelas->nama_kelas }}
                </p>
            </a>
            @endforeach
        </div>
    </div>

    {{-- LAPORAN  --}}

    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">
                Laporan Terbaru Masuk
            </h2>

            <a href="{{ route('dosen.laporan.index') }}"
                class="text-sm text-blue-400 font-semibold hover:text-black">
                Lihat lainnya
            </a>
        </div>

        <div class="bg-white rounded-2xl border overflow-hidden">

            @forelse($laporanTerbaru as $laporan)
            <div class="flex items-center justify-between px-7 py-5 border-b last:border-0">
                {{-- kiri --}}
                <div class="flex items-center gap-4">
                    {{-- icon --}}
                    <div class="w-10 h-10 rounded-xl bg-[#F3F4F6] flex items-center justify-center">
                        <i class="fa-regular fa-file text-gray-600"></i>
                    </div>
                    {{-- isi --}}
                    <div>
                        <h3 class="font-semibold">
                            Sesi {{ $laporan->pertemuan->sesi }}
                            -
                            {{ $laporan->pertemuan->praktikum->nama_praktikum }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Pengirim :
                            {{ $laporan->mahasiswa->name }}
                            |
                            {{ $laporan->pertemuan->praktikum->kelas->nama_kelas }}
                        </p>

                        <p class="mt-1 text-sm {{ $laporan->status=='acc'
                            ? 'text-green-600'
                            : 'text-red-500' }}">

                            • {{ $laporan->status_label }}
                        </p>
                    </div>
                </div>

                {{-- kanan --}}
                <a href="{{ asset('storage/'.$laporan->file_laporan) }}"
                    target="_blank"
                    class="text-2xl text-gray-500 hover:text-[#4171BD]">

                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @empty
            <div class="py-12 text-center text-gray-500">
                Belum ada laporan yang masuk.
            </div>
            @endforelse

        </div>

    </div>

</div>

@endsection