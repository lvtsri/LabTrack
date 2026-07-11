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
                {{ $praktikumAktif }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Total Laporan Dikumpulkan
            </p>

            <h2 class="text-3xl font-bold text-center">
                {{ $totalLaporanDikumpulkan }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-8 border">
            <p class="text-sm mb-4">
                Laporan Belum Dikumpulkan
            </p>

            <h2 class="text-3xl font-bold text-center">
                {{ $laporanBelumDikumpulkan }}
            </h2>
        </div>

    </div>

    {{-- PRAKTIKUM --}}
    <div class="mb-14">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">
                Praktikum - Terakhir Dibuka
            </h2>

            <a href="/mahasiswa/praktikum" class="text-sm font-semibold text-blue-400 hover:text-black">
                Lihat lainnya
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6">

            @forelse ($praktikumTerbaru as $praktikum)
                <a
                    href="{{ route('mahasiswa.praktikum.show', $praktikum->id_praktikum) }}"
                    class="block bg-[#586ce0] rounded-2xl p-6 text-white h-[140px] hover:shadow-lg hover:-translate-y-1 transition"
                >
                    <h3 class="text-base font-semibold mb-6 line-clamp-2">
                        {{ $praktikum->nama_praktikum }}
                    </h3>

                    <p class="text-sm text-white/80">
                        Dosen : {{ $praktikum->dosen?->name ?? 'Dosen belum tersedia' }}
                    </p>
                </a>
            @empty
                <div class="col-span-3 bg-white rounded-2xl p-8 border text-center text-gray-400">
                    Belum ada praktikum aktif.
                </div>
            @endforelse

        </div>

    </div>

    <div>

        <h2 class="text-lg font-bold mb-4">
            Deadline Mendatang
        </h2>

        <div class="bg-white rounded-2xl p-6 py-2 border">

            @forelse ($deadlineMendatang as $deadline)
                @php
                    $deadlineDate = \Carbon\Carbon::parse($deadline->deadline)->locale('id');
                    $badgeColors = ['bg-pink-200', 'bg-orange-200', 'bg-orange-200', 'bg-green-200'];
                @endphp

                <div class="flex items-center gap-5 py-4 border-b last:border-0">

                    <div class="w-8 h-8 rounded-lg {{ $badgeColors[$loop->index] ?? 'bg-blue-200' }}">

                    </div>

                    <div>
                        <h3 class="text-base font-semibold">
                            {{ $deadline->praktikum?->nama_praktikum ?? 'Praktikum tidak tersedia' }}
                        </h3>

                        <p class="text-sm text-gray-400 mt-1">
                            {{ $deadlineDate->isToday() ? 'Hari ini' : $deadlineDate->translatedFormat('j F Y') }}
                            - {{ $deadlineDate->format('H.i') }}
                        </p>
                    </div>

                </div>

            @empty
                <div class="py-8 text-center text-gray-400">
                    Tidak ada deadline mendatang.
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection
