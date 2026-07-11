@extends('layouts.dosen')

@section('content')

<div class="mt-4 ml-[210px] mr-8">
    @if(session('success'))
        <div class="mb-5 rounded-2xl bg-green-100 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="mb-2 text-lg font-bold text-black">
        Laporan
    </h1>
    <p class="text-sm text-gray-500">
        Tinjau dan kelola laporan praktikum mahasiswa.
    </p>
    <hr class="mt-4 border-[#b8b8bd]">

    <form method="GET" action="{{ route('dosen.laporan.index') }}" class="mt-8 mb-8 grid gap-5 lg:grid-cols-[220px_230px_180px_1fr_82px]">
        <select name="praktikum_id" class="h-[40px] rounded-xl border border-[#bfc0c5] bg-white px-5 text-sm font-medium text-[#8d8d8d] outline-none focus:border-[#6687ff]">
            <option value="">Praktikum</option>
            @foreach($praktikumOptions as $praktikum)
                <option value="{{ $praktikum->id_praktikum }}" @selected((string) request('praktikum_id') === (string) $praktikum->id_praktikum)>
                    {{ $praktikum->nama_praktikum }}
                </option>
            @endforeach
        </select>

        <select name="pertemuan_id" class="h-[40px] rounded-xl border border-[#bfc0c5] bg-white px-5 text-sm font-medium text-[#8d8d8d] outline-none focus:border-[#6687ff]">
            <option value="">Pertemuan</option>
            @foreach($pertemuanOptions as $pertemuan)
                <option value="{{ $pertemuan->id_pertemuan }}" @selected((string) request('pertemuan_id') === (string) $pertemuan->id_pertemuan)>
                    Sesi {{ $pertemuan->sesi }} - {{ $pertemuan->judul }}
                </option>
            @endforeach
        </select>

        <select name="status" class="h-[40px] rounded-xl border border-[#bfc0c5] bg-white px-5 text-sm font-medium text-[#8d8d8d] outline-none focus:border-[#6687ff]">
            <option value="">Status</option>
            <option value="belum_direview" @selected(request('status') === 'belum_direview')>Belum direview</option>
            <option value="acc" @selected(request('status') === 'acc')>Selesai</option>
        </select>

        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="h-[40px] rounded-xl border border-[#bfc0c5] bg-white px-6 text-base outline-none focus:border-[#6687ff]"
        >

        <button type="submit" class="flex h-[40px] w-[82px] items-center justify-center rounded-xl bg-[#6688c6] text-white transition hover:bg-[#5578b8]">
            <i class="fa-solid fa-magnifying-glass text-base"></i>
        </button>
    </form>

    <div class="min-h-[720px] overflow-hidden rounded-[18px] border border-[#dedfe4] bg-white shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
        <table class="w-full table-fixed">
            <thead class="bg-[#f7f7f8]">
                <tr class="h-[74px] text-center text-sm font-bold text-black">
                    <th class="w-[15%]">Nama</th>
                    <th class="w-[25%]">Praktikum</th>
                    <th class="w-[8%]">Sesi</th>
                    <th class="w-[15%]">Status</th>
                    <th class="w-[13%]">Tanggal</th>
                    <th class="w-[12%]">File</th>
                    <th class="w-[12%]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                    <tr class="h-[70px] text-center text-sm odd:bg-white even:bg-[#f8f8f9]">
                        <td>{{ $item->mahasiswa?->name ?? '-' }}</td>
                        <td>{{ $item->pertemuan?->praktikum?->nama_praktikum ?? '-' }}</td>
                        <td>{{ $item->pertemuan?->sesi ?? '-' }}</td>
                        <td class="{{ $item->status === 'acc' ? 'text-[#0fbd58]' : 'text-red-500' }}">
                            {{ $item->status_label }}
                        </td>
                        <td>{{ $item->tanggal_upload?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$item->file_laporan) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-2 px-4 py-2 text-sm">
                                <i class="fa-regular fa-file text-base"></i>
                                PDF
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('dosen.laporan.status', $item->id_laporan) }}">
                                @csrf
                                @method('PATCH')
                                @if($item->status === 'acc')
                                    <input type="hidden" name="status" value="belum_direview">
                                    <button type="submit" class="min-w-[80px] rounded-2xl border border-red-500 px-5 py-2 font-semibold text-red-500 transition hover:bg-red-50">
                                        Batal
                                    </button>
                                @else
                                    <input type="hidden" name="status" value="acc">
                                    <button type="submit" class="min-w-[80px] rounded-2xl border border-[#18c774] px-2 py-2 font-semibold text-[#0fbd58] transition hover:bg-green-50">
                                        <i class="fa-solid fa-check text-base"></i>
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-base font-medium text-[#8d8d8d]">
                            Belum ada laporan praktikum.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
