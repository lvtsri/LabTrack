@extends('layouts.dosen')

@section('content')

@php
    $tanggal = $pertemuan->tanggal_pertemuan?->locale('id');
@endphp

<div class="ml-[210px] max-w-[1460px]">
    @if(session('success'))
        <div class="mb-5 rounded-2xl bg-green-100 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-[22px] bg-[#586ce0] px-8 py-7 text-white shadow-sm">
        <h1 class="text-lg font-bold leading-tight">
            {{ $praktikum->kelas?->nama_kelas }} - {{ $praktikum->nama_praktikum }}
        </h1>
        <p class="mt-4 text-base">
            Semester {{ $praktikum->semester }}
        </p>
    </div>

    <section class="mt-5 rounded-xl border border-[#dedfe4] bg-white px-8 py-7 shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
        <div class="grid gap-6 lg:grid-cols-[1fr_330px]">
            <div>
                <h2 class="text-base font-bold leading-snug text-black">
                    Sesi {{ $pertemuan->sesi }} - {{ $pertemuan->judul }}
                </h2>

                <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
                    <span class="font-medium text-black">Materi:</span>
                    @forelse($pertemuan->materi as $materi)
                        <a href="{{ $materi->url }}" target="_blank" class="inline-flex min-h-[46px] items-center gap-3 rounded-lg border border-[#8d8d8d] bg-[#fbfbfc] px-4 py-2 text-sm font-medium text-[#222] transition hover:bg-gray-50">
                            <i class="fa-solid {{ $materi->icon }} text-lg"></i>
                            {{ $materi->nama_materi }}
                        </a>
                    @empty
                        <span class="text-[#9a9a9f]">Tidak tersedia</span>
                    @endforelse
                </div>
            </div>

            <div class="text-right">
                @if($tanggal)
                    <p class="text-base font-medium text-[#86868b]">
                        {{ $tanggal->translatedFormat('l, j F Y') }}
                    </p>
                    <p class="mt-2 text-base text-[#86868b]">
                        {{ $pertemuan->jam_mulai ? \Carbon\Carbon::parse($pertemuan->jam_mulai)->format('H:i') : '-' }}
                        -
                        {{ $pertemuan->jam_selesai ? \Carbon\Carbon::parse($pertemuan->jam_selesai)->format('H:i') : '-' }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <section class="mt-7 overflow-hidden rounded-xl border border-[#dedfe4] bg-white shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
        <div class="px-8 py-8">
            <p class="text-base font-semibold text-[#078c4d]">
                Laporan masuk: [ {{ $pertemuan->laporan->count() }} / {{ $jumlahMahasiswa }} ] mahasiswa
            </p>
        </div>

        <table class="w-full table-fixed">
            <thead class="bg-[#f4f4f5]">
                <tr class="h-[74px] text-center text-base font-bold text-black">
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pertemuan->laporan as $laporan)
                    <tr class="h-[82px] text-center text-base odd:bg-white even:bg-[#f8f8f9]">
                        <td>{{ $laporan->mahasiswa?->detailUser?->nim ?? '-' }}</td>
                        <td>{{ $laporan->mahasiswa?->name ?? '-' }}</td>
                        <td class="{{ $laporan->status === 'acc' ? 'text-[#0fbd58]' : 'text-red-500' }}">
                            {{ $laporan->status_label }}
                        </td>
                        <td>{{ $laporan->tanggal_upload?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$laporan->file_laporan) }}" target="_blank" class="mx-auto inline-flex min-h-[42px] items-center justify-center gap-2 rounded-full border border-[#c1c1c6] bg-[#fbfbfc] px-5 text-sm font-medium text-[#222] transition hover:bg-gray-50">
                                <i class="fa-regular fa-file text-base"></i>
                                PDF
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('dosen.laporan.status', $laporan->id_laporan) }}">
                                @csrf
                                @method('PATCH')
                                @if($laporan->status === 'acc')
                                    <input type="hidden" name="status" value="belum_direview">
                                    <button type="submit" class="min-w-[80px] rounded-2xl border border-red-500 px-4 py-2 text-base text-red-500 transition hover:bg-red-50">
                                        Batal
                                    </button>
                                @else
                                    <input type="hidden" name="status" value="acc">
                                    <button type="submit" class="min-w-[80px] rounded-2xl border border-[#18c774] px-4 py-2 font-semibold text-[#0fbd58] transition hover:bg-green-50">
                                        <i class="fa-solid fa-check text-lg"></i>
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-[#8d8d8d]">
                            Belum ada laporan yang dikumpulkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>

@endsection
