@extends('layouts.mahasiswa')

@section('content')

@php
    $selectedPraktikum = request('praktikum_id');
    $selectedStatus = request('status');
    $search = request('q');
@endphp

<div class="mt-4 ml-[210px] max-w-[1460px]">
    <h1 class="mb-2 text-lg font-bold text-black">
        Arsip
    </h1>

    <p class="text-sm text-gray-500">
        Semua laporan yang telah Anda kumpulkan tersimpan di sini.
    </p>

    <hr class="mt-4 border-[#b8b8bd]">

    <form method="GET" action="{{ route('mahasiswa.arsip.index') }}" class="mt-8 mb-8 grid gap-3 lg:grid-cols-[280px_330px_1fr_82px]">
        <select name="praktikum_id" class="h-[40px] w-full rounded-xl border border-[#bfc0c5] bg-white px-4 text-sm font-medium text-[#8d8d8d] outline-none focus:border-[#6687ff]">
            <option value="">Kelas Praktikum</option>
            @foreach($praktikumOptions as $praktikum)
                <option value="{{ $praktikum->id_praktikum }}" @selected((string) $selectedPraktikum === (string) $praktikum->id_praktikum)>
                    {{ $praktikum->nama_praktikum }}
                </option>
            @endforeach
        </select>

        <select name="status" class="h-[40px] w-full rounded-xl border border-[#bfc0c5] bg-white px-4 text-sm font-medium text-[#8d8d8d] outline-none focus:border-[#6687ff]">
            <option value="">Status Kelas Praktikum</option>
            <option value="acc" @selected($selectedStatus === 'acc')>Selesai</option>
            <option value="belum_direview" @selected($selectedStatus === 'belum_direview')>Belum direview</option>
        </select>

        <input type="text" name="q" value="{{ $search }}" class="h-[40px] w-full rounded-xl border border-[#bfc0c5] bg-white px-6 text-base outline-none focus:border-[#6687ff]" placeholder="">

        <button type="submit" class="flex h-[40px] w-[75px] items-center justify-center rounded-xl bg-[#6688c6] text-white transition hover:bg-[#5578b8]">
            <i class="fa-solid fa-magnifying-glass text-base"></i>
        </button>
    </form>

    @forelse($arsipGroups as $title => $reports)
        @continue($reports->isEmpty())

        <h2 class="mb-4 text-base font-bold text-black">
            {{ $title }}
        </h2>

        <div class="mb-10 overflow-hidden rounded-[18px] border border-[#dedfe4] bg-white shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
            <table class="w-full table-fixed">
                <thead class="bg-[#f7f7f8]">
                    <tr class="h-[74px] text-center text-sm font-semibold text-black">
                        <th class="w-[36%]">Praktikum</th>
                        <th class="w-[16%]">Sesi</th>
                        <th class="w-[18%]">Status</th>
                        <th class="w-[18%]">Tanggal</th>
                        <th class="w-[12%]">File</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reports as $laporan)
                        <tr class="h-[82px] text-center text-sm font-semibold text-black odd:bg-white even:bg-[#f8f8f9]">
                            <td class="px-8 text-left">
                                {{ $laporan->pertemuan?->praktikum?->nama_praktikum ?? 'Tidak tersedia' }}
                            </td>
                            <td>
                                {{ $laporan->pertemuan?->sesi ?? '-' }}
                            </td>
                            <td class="{{ $laporan->status === 'acc' ? 'text-[#0fbd58]' : 'text-red-500' }}">
                                {{ $laporan->status_label }}
                            </td>
                            <td>
                                {{ $laporan->tanggal_upload?->format('d-m-Y') ?? '-' }}
                            </td>
                            <td>
                                <a
                                    href="{{ asset('storage/'.$laporan->file_laporan) }}"
                                    target="_blank"
                                    class="mx-auto inline-flex min-h-[42px] items-center justify-center gap-2 rounded-full border border-[#c1c1c6] bg-[#fbfbfc] px-5 text-[16px] font-medium text-[#222] transition hover:bg-gray-50"
                                >
                                    <i class="fa-regular fa-file text-xl"></i>
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="rounded-[18px] border border-[#dedfe4] bg-white px-8 py-12 text-center text-base font-medium text-[#8d8d8d] shadow-sm">
            Belum ada laporan yang tersimpan.
        </div>
    @endforelse

    @if(collect($arsipGroups)->every(fn ($reports) => $reports->isEmpty()))
        <div class="rounded-[18px] border border-[#dedfe4] bg-white px-8 py-12 text-center text-base font-medium text-[#8d8d8d] shadow-sm">
            Tidak ada laporan yang sesuai dengan filter.
        </div>
    @endif
</div>

@endsection
