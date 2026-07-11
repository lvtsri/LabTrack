@extends('layouts.mahasiswa')

@section('content')

<div class="ml-[210px] max-w-[1460px]">
    @if(session('success'))
        <div class="mb-5 rounded-2xl bg-green-100 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('file_laporan'))
        <div class="mb-5 rounded-2xl bg-red-100 px-5 py-4 text-sm font-medium text-red-700">
            {{ $errors->first('file_laporan') }}
        </div>
    @endif

    <div class="rounded-[22px] bg-[#586ce0] px-8 py-7 text-white shadow-sm">
        <h1 class="text-lg font-bold leading-tight">
            {{ $praktikum->nama_praktikum }}
        </h1>
        <p class="mt-4 text-sm font-semibold">
            Kelas: {{ $praktikum->kelas?->nama_kelas ?? 'Tidak tersedia' }}
        </p>
        <p class="mt-2 text-sm">
            Pengajar: {{ $praktikum->dosen?->name ?? 'Tidak tersedia' }}
        </p>
    </div>

    @foreach ($praktikum->pertemuan as $pertemuan)
        @php
            $deadline = $pertemuan->deadline ? \Carbon\Carbon::parse($pertemuan->deadline)->locale('id') : null;
            $sudahMengumpulkan = $pertemuan->laporan->isNotEmpty();
        @endphp

        <section class="mt-7 rounded-xl border border-[#dedfe4] bg-white px-8 py-8 shadow-[0_2px_5px_rgba(0,0,0,0.18)]">
            <div class="grid gap-6 lg:grid-cols-[1fr_330px]">
                <div>
                    <h2 class="text-base font-bold leading-snug text-black">
                        Sesi {{ $pertemuan->sesi }} - {{ $pertemuan->judul }}
                    </h2>

                    @if($pertemuan->deskripsi)
                        <p class="mt-4 text-sm leading-relaxed text-[#8f8f95]">
                            {{ $pertemuan->deskripsi }}
                        </p>
                    @endif

                    <div class="mt-8 space-y-5 text-sm">
                        <div class="grid gap-3 sm:grid-cols-[78px_1fr] sm:items-center">
                            <p class="font-medium text-black">Materi:</p>

                            @if($pertemuan->materi->isEmpty())
                                <p class="text-[#9a9a9f]">Tidak tersedia</p>
                            @else
                                <div class="flex flex-wrap gap-3">
                                    @foreach($pertemuan->materi as $materi)
                                        <x-materi-chip :materi="$materi"/>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="grid gap-3 sm:grid-cols-[78px_1fr] sm:items-center">
                            <p class="font-medium text-black">Tugas:</p>

                            @if(!$pertemuan->wajib_laporan)
                                <p class="text-[#9a9a9f]">Tidak tersedia</p>
                            @elseif($sudahMengumpulkan)
                                <div class="flex flex-wrap gap-3">
                                    @foreach($pertemuan->laporan as $laporan)
                                        <a
                                            href="{{ asset('storage/'.$laporan->file_laporan) }}"
                                            target="_blank"
                                            class="inline-flex min-h-[46px] items-center gap-3 rounded-lg border border-[#8d8d8d] bg-[#fbfbfc] px-4 py-2 text-[15px] font-medium text-[#222] transition hover:bg-gray-50"
                                        >
                                            <i class="fa-solid fa-file-pdf text-lg"></i>
                                            {{ basename($laporan->file_laporan) }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[#9a9a9f]">Belum ada file laporan</p>
                            @endif
                        </div>
                    </div>

                    @if($deadline)
                        <p class="mt-7 text-sm font-medium text-[#ff545d]">
                            Deadline:
                            {{ $deadline->isToday() ? 'Hari ini' : $deadline->translatedFormat('j F Y') }}
                            {{ $deadline->format('H:i') }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-col items-end justify-between gap-10 text-right">
                    <div>
                        @if($deadline)
                            <p class="text-sm font-medium text-[#86868b]">
                                {{ $deadline->translatedFormat('l, j F Y') }}
                            </p>
                            <p class="mt-2 text-sm text-[#86868b]">
                                {{ $deadline->format('H:i') }}
                            </p>
                        @endif

                        @if($pertemuan->wajib_laporan)
                            <p class="mt-8 text-sm font-semibold {{ $sudahMengumpulkan ? 'text-[#13b981]' : 'text-[#ff545d]' }}">
                                &bull; {{ $sudahMengumpulkan ? 'Sudah dikumpulkan' : 'Belum mengumpulkan' }}
                            </p>
                        @endif
                    </div>

                    @if($pertemuan->wajib_laporan && !$sudahMengumpulkan)
                        <button
                            type="button"
                            data-upload-open
                            data-action="{{ route('mahasiswa.praktikum.laporan.store', [$praktikum->id_praktikum, $pertemuan->id_pertemuan]) }}"
                            data-title="Sesi {{ $pertemuan->sesi }} - {{ $pertemuan->judul }}"
                            class="inline-flex h-[40px] w-[180px] items-center justify-center gap-4 rounded-[18px] border-2 border-[#6687ff] bg-white text-sm font-semibold text-[#3f6df6] transition hover:bg-[#f5f7ff]"
                        >
                            <i class="fa-solid fa-arrow-up-from-bracket text-lg"></i>
                            Upload
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @endforeach

    @if($praktikum->pertemuan->isEmpty())
        <div class="mt-7 rounded-xl border border-[#dedfe4] bg-white px-8 py-10 text-center text-[#8f8f95] shadow-sm">
            Belum ada sesi praktikum.
        </div>
    @endif
</div>

<div id="uploadModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-6">
    <div class="w-full max-w-[1100px] rounded-[18px] bg-white px-12 py-10 shadow-2xl">
        <h2 class="text-center text-base font-bold text-black">
            Upload Files
        </h2>

        <p id="uploadModalTitle" class="mt-3 text-center text-sm font-medium text-[#85858a]"></p>

        <form id="uploadForm" action="" method="POST" enctype="multipart/form-data" class="mt-9">
            @csrf

            <label id="dropArea" for="file_laporan"
                class="flex min-h-[350px] cursor-pointer flex-col items-center justify-center rounded-[18px] border-2 border-dashed border-[#858585] bg-white px-6 text-center transition hover:bg-gray-50"
            >
                <input
                    id="file_laporan"
                    name="file_laporan"
                    type="file"
                    accept="application/pdf,.pdf"
                    class="hidden"
                    required
                >

                <p class="text-base font-semibold text-[#85858a]">
                    Drag and drop files here
                </p>
                <p class="mt-5 text-sm font-semibold text-[#85858a]">
                    OR
                </p>

                <span class="mt-5 inline-flex h-[50px] min-w-[250px] items-center justify-center gap-4 rounded-lg bg-[#558be1] px-8 text-base font-semibold text-white transition hover:bg-[#477bd0]">
                    <i class="fa-solid fa-arrow-up-from-bracket text-base"></i>
                    Browse File
                </span>

                <p id="selectedFileName" class="mt-6 text-sm font-medium text-[#666]">
                    PDF saja, maksimal 10 MB.
                </p>
            </label>

            <p id="fileError" class="mt-4 hidden text-sm font-medium text-[#e33d42]">
                File wajib berformat PDF.
            </p>

            <div class="mt-8 flex justify-end gap-5">
                <button
                    type="button"
                    id="closeUploadModal"
                    class="h-[40px] min-w-[175px] rounded-[16px] border-2 border-[#333] bg-white px-10 text-sm font-semibold text-black transition hover:bg-gray-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="h-[40px] min-w-[175px] rounded-[16px] bg-[#df3d43] px-10 text-sm font-bold text-white transition hover:bg-[#ca3036]"
                >
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const uploadModal = document.getElementById('uploadModal');
    const uploadForm = document.getElementById('uploadForm');
    const uploadModalTitle = document.getElementById('uploadModalTitle');
    const closeUploadModal = document.getElementById('closeUploadModal');
    const fileInput = document.getElementById('file_laporan');
    const dropArea = document.getElementById('dropArea');
    const selectedFileName = document.getElementById('selectedFileName');
    const fileError = document.getElementById('fileError');

    const openUploadModal = (button) => {
        uploadForm.action = button.dataset.action;
        uploadModalTitle.textContent = button.dataset.title;
        fileInput.value = '';
        selectedFileName.textContent = 'PDF saja, maksimal 10 MB.';
        fileError.classList.add('hidden');
        uploadModal.classList.remove('hidden');
        uploadModal.classList.add('flex');
    };

    const hideUploadModal = () => {
        uploadModal.classList.add('hidden');
        uploadModal.classList.remove('flex');
    };

    const isPdf = (file) => {
        return file && (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf'));
    };

    const setSelectedFile = (file) => {
        if (!isPdf(file)) {
            fileInput.value = '';
            selectedFileName.textContent = 'PDF saja, maksimal 10 MB.';
            fileError.classList.remove('hidden');
            return;
        }

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        selectedFileName.textContent = file.name;
        fileError.classList.add('hidden');
    };

    document.querySelectorAll('[data-upload-open]').forEach((button) => {
        button.addEventListener('click', () => openUploadModal(button));
    });

    closeUploadModal?.addEventListener('click', hideUploadModal);

    uploadModal?.addEventListener('click', (event) => {
        if (event.target === uploadModal) {
            hideUploadModal();
        }
    });

    fileInput?.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            setSelectedFile(fileInput.files[0]);
        }
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
        dropArea?.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropArea.classList.add('bg-gray-50', 'border-[#558be1]');
        });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        dropArea?.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropArea.classList.remove('bg-gray-50', 'border-[#558be1]');
        });
    });

    dropArea?.addEventListener('drop', (event) => {
        const file = event.dataTransfer.files[0];
        setSelectedFile(file);
    });

    uploadForm?.addEventListener('submit', (event) => {
        if (!isPdf(fileInput.files[0])) {
            event.preventDefault();
            fileError.classList.remove('hidden');
        }
    });
</script>

@endsection
