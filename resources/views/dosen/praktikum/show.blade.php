@extends('layouts.dosen')

@section('content')

<div class="ml-[210px] max-w-[1460px]">
    @if(session('success'))
        <div class="mb-5 rounded-2xl bg-green-100 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="mb-2 rounded-2xl bg-red-100 px-5 py-4 text-sm font-medium text-red-700">
            {{ $errors->first() }}
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

    <div class="mt-7 flex justify-end gap-3">
        <button id="openEditPraktikum" class="inline-flex items-center gap-3 rounded-xl bg-[#586ce0] px-7 py-3 text-sm font-semibold text-white transition hover:bg-[#4e73b3]">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit
        </button>
        <button id="openTambahSesi" class="inline-flex items-center gap-3 rounded-xl bg-[#586ce0] px-7 py-3 text-sm font-semibold text-white transition hover:bg-[#4e73b3]">
            <i class="fa-solid fa-plus"></i>
            Tambah Sesi
        </button>
    </div>

    <div class="mt-7 space-y-5">
        @forelse($praktikum->pertemuan as $pertemuan)
            @php
                $tanggal = $pertemuan->tanggal_pertemuan?->locale('id');
                $deadline = $pertemuan->deadline?->locale('id');
                $statusClass = match($pertemuan->status) {
                    'berlangsung' => 'bg-[#b7f7d4] text-black',
                    'terjadwal' => 'bg-[#dce9f9] text-black',
                    'selesai' => 'bg-[#dedede] text-black',
                    default => 'bg-gray-100 text-gray-500',
                };
                $statusLabel = match($pertemuan->status) {
                    'berlangsung' => 'Sedang dimulai',
                    'terjadwal' => 'Terjadwal',
                    'selesai' => 'Selesai',
                    default => 'Draft',
                };
            @endphp

            <section class="rounded-xl border border-[#dedfe4] bg-white px-8 py-7 shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
                <div class="grid gap-6 lg:grid-cols-[1fr_330px]">
                    <a href="{{ route('dosen.pertemuan.show', [$praktikum->id_praktikum, $pertemuan->id_pertemuan]) }}" class="block">
                        <h2 class="text-base font-bold leading-snug text-black">
                            Sesi {{ $pertemuan->sesi }} - {{ $pertemuan->judul }}
                        </h2>
                        
                        @if($pertemuan->deskripsi)
                            <p class="mt-4 text-sm leading-relaxed text-[#8f8f95]">
                                {{ $pertemuan->deskripsi }}
                            </p>
                        @endif

                        <div class="mt-5 space-y-4 text-sm">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="font-medium text-black">Materi:</span>
                                @forelse($pertemuan->materi as $materi)
                                    <span class="inline-flex min-h-[46px] items-center gap-3 rounded-lg border border-[#8d8d8d] bg-[#fbfbfc] px-4 py-2 text-sm font-medium text-[#222]">
                                        <i class="fa-solid {{ $materi->icon }} text-sm"></i>
                                        {{ $materi->nama_materi }}
                                    </span>
                                @empty
                                    <span class="text-[#9a9a9f]">Tidak tersedia</span>
                                @endforelse
                            </div>

                            <p class="{{ $pertemuan->wajib_laporan ? 'text-black' : 'text-[#9a9a9f]' }}">
                                Wajib Laprak:
                                @if($pertemuan->wajib_laporan)
                                    <i class="fa-solid fa-square-check text-[#0fbd58]"></i>
                                @else
                                    <i class="fa-solid fa-xmark text-[#ff7b87]"></i>
                                @endif
                            </p>

                            @if($pertemuan->wajib_laporan)
                                <p class="font-semibold text-[#078c4d]">
                                    Laporan masuk: [ {{ $pertemuan->laporan->count() }} / {{ $jumlahMahasiswa }} ] mahasiswa
                                </p>
                            @endif
                        </div>
                    </a>

                    <div class="flex flex-col items-end justify-between gap-7 text-right">
                        <div>
                            @if($tanggal)
                                <p class="text-sm font-medium text-[#86868b]">
                                    {{ $tanggal->translatedFormat('l, j F Y') }}
                                </p>
                                <p class="mt-2 text-sm text-[#86868b]">
                                    {{ $pertemuan->jam_mulai ? \Carbon\Carbon::parse($pertemuan->jam_mulai)->format('H:i') : '-' }}
                                    -
                                    {{ $pertemuan->jam_selesai ? \Carbon\Carbon::parse($pertemuan->jam_selesai)->format('H:i') : '-' }}
                                </p>
                            @endif

                            <span class="mt-4 inline-flex min-w-[126px] justify-center rounded-xl px-5 py-2 text-sm {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="flex flex-col items-end gap-4">
                            @if($deadline)
                                <p class="text-sm font-medium text-[#ff545d]">
                                    Deadline: {{ $deadline->translatedFormat('j F Y') }} {{ $deadline->format('H:i') }}
                                </p>
                            @endif

                            <button
                                type="button"
                                class="openEditPertemuan rounded-xl border border-[#5d82c2] px-6 py-2 text-sm font-semibold text-[#4e73b3] hover:bg-[#f4f7ff]"
                                data-modal="editPertemuan{{ $pertemuan->id_pertemuan }}"
                            >
                                Edit Sesi
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <div id="editPertemuan{{ $pertemuan->id_pertemuan }}" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 px-6">
                <form method="POST" action="{{ route('dosen.pertemuan.update', [$praktikum->id_praktikum, $pertemuan->id_pertemuan]) }}" enctype="multipart/form-data" class="max-h-[90vh] w-full max-w-[850px] overflow-y-auto rounded-3xl bg-white p-8">
                    @csrf
                    @method('PUT')
                    <h2 class="mb-7 text-lg font-bold">Edit Sesi</h2>
                    @include('dosen.praktikum.partials.form-pertemuan', ['pertemuan' => $pertemuan])
                </form>
            </div>
        @empty
            <div class="rounded-xl border border-[#dedfe4] bg-white px-8 py-10 text-center text-[#8f8f95] shadow-sm">
                Belum ada sesi praktikum.
            </div>
        @endforelse
    </div>
</div>

<div id="modalEditPraktikum" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 px-6">
    <div class="w-full max-w-[550px] rounded-3xl bg-white p-8">
        <h2 class="mb-8 text-xl font-bold">Edit Kelas Praktikum</h2>
        <form action="{{ route('dosen.praktikum.update', $praktikum->id_praktikum) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm">Nama Praktikum</label>
                    <input type="text" name="nama_praktikum" value="{{ old('nama_praktikum', $praktikum->nama_praktikum) }}" class="w-full rounded-xl border px-4 py-3 outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm">Semester</label>
                    <select name="semester" class="w-full rounded-xl border px-4 py-3" required>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" @selected((int) old('semester', $praktikum->semester) === $i)>Semester {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm">Kelas</label>
                    <select name="kelas_id" class="w-full rounded-xl border px-4 py-3" required>
                        @foreach($kelas as $item)
                            <option value="{{ $item->id_kelas }}" @selected((int) old('kelas_id', $praktikum->kelas_id) === (int) $item->id_kelas)>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-10 flex justify-end gap-4">
                <button type="button" data-close-modal class="rounded-xl border px-6 py-2 hover:bg-gray-100">Batal</button>
                <button type="submit" class="rounded-xl bg-[#415BE7] px-8 py-2 text-white hover:opacity-90">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalTambahSesi" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 px-6">
    <form method="POST" action="{{ route('dosen.pertemuan.store', $praktikum->id_praktikum) }}" enctype="multipart/form-data" class="max-h-[90vh] w-full max-w-[850px] overflow-y-auto rounded-3xl bg-white p-8">
        @csrf
        <h2 class="mb-7 text-xl font-bold">Tambah Sesi</h2>
        @include('dosen.praktikum.partials.form-pertemuan', ['pertemuan' => null])
    </form>
</div>

<script>
    const openModalById = (id) => {
        const target = document.getElementById(id);
        target?.classList.remove('hidden');
        target?.classList.add('flex');
    };

    const closeModalElement = (target) => {
        target?.classList.add('hidden');
        target?.classList.remove('flex');
    };

    document.getElementById('openEditPraktikum')?.addEventListener('click', () => openModalById('modalEditPraktikum'));
    document.getElementById('openTambahSesi')?.addEventListener('click', () => openModalById('modalTambahSesi'));

    document.querySelectorAll('.openEditPertemuan').forEach((button) => {
        button.addEventListener('click', () => openModalById(button.dataset.modal));
    });

    document.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', () => closeModalElement(button.closest('.fixed')));
    });

    document.querySelectorAll('.fixed[id^="modal"], .fixed[id^="editPertemuan"]').forEach((overlay) => {
        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) {
                closeModalElement(overlay);
            }
        });
    });
</script>

@endsection
