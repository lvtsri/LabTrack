@extends('layouts.dosen')

@section('content')

@php
    $detail = $user->detailUser;

    $jenisKelamin = match ($detail?->jenis_kelamin) {
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
        default => '-',
    };

    $tanggalLahir = $detail?->tanggal_lahir
        ? \Carbon\Carbon::parse($detail->tanggal_lahir)->translatedFormat('d F Y')
        : '-';

    $tempatTanggalLahir = $detail?->tempat_lahir
        ? $detail->tempat_lahir . ', ' . $tanggalLahir
        : $tanggalLahir;

    $fotoProfil = $detail?->foto_profil
        ? asset('storage/' . $detail->foto_profil)
        : asset('images/default-profile.jpg')
@endphp

<div class="mt-4 ml-[210px]">
    <div class="mb-6">
        <h1 class="text-lg font-bold mb-2">
            Profil
        </h1>
        <p class="text-sm text-gray-500">Kelola informasi dan data diri Anda.</p>
        <hr class="border-gray-400 mt-4">
    </div>

    <div class="bg-white rounded-3xl border shadow-sm p-12">
        {{-- TOP PROFIL --}}
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-5">
                {{-- FOTO --}}
                <div class="w-20 h-20 rounded-full bg-gray-300 overflow-hidden border flex items-center justify-center">
                    <img src="{{ $fotoProfil }}" class="w-full h-full object-cover">
                </div>

                {{-- IDENTITAS --}}
                <div>
                    <h2 class="text-base font-bold mb-1">
                        {{ $user->name }}
                    </h2>
                    <p class="text-gray-500 text-base">
                        NIP. {{ $detail?->nip ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- BUTTON EDIT --}}
            <button id="openModal" class="flex items-center gap-3 border border-blue-400 text-blue-500 px-6 py-3 rounded-2xl hover:bg-blue-50 transition">

                <i class="fa-regular fa-pen-to-square"></i>

                <span class="text-sm">
                    Edit
                </span>

            </button>

        </div>
        <hr class="border-gray-300 my-8">

        {{-- INFORMASI --}}
        <div>

            <h3 class="text-lg font-bold mb-8">
                Informasi Umum
            </h3>

            <div class="grid grid-cols-2 gap-12">

                {{-- kiri --}}
                <div class="space-y-5">
                    <div class="flex">
                        <p class="w-52 text-sm">
                            Jenis Kelamin
                        </p>
                        <p class="text-sm">
                            : {{ $jenisKelamin }}
                        </p>
                    </div>

                    <div class="flex">
                        <p class="w-52 text-sm">
                            Tempat, Tanggal Lahir
                        </p>
                        <p class="text-sm">
                            : {{ $tempatTanggalLahir }}
                        </p>
                    </div>

                    <div class="flex">
                        <p class="w-52 text-sm">
                            Agama
                        </p>
                        <p class="text-sm">
                            : {{ $detail?->agama ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- kanan --}}
                <div class="space-y-5">
                    <div class="flex">
                        <p class="w-52 text-sm">
                            Alamat
                        </p>
                        <p class="text-sm break-all">
                            : {{ $detail?->alamat ?? '-' }}
                        </p>
                    </div>

                    <div class="flex">
                        <p class="w-52 text-sm">
                            Email Pribadi
                        </p>
                        <p class="text-sm break-all">
                            : {{ $detail?->email_pribadi ?? '-' }}
                        </p>
                    </div>

                    <div class="flex">
                        <p class="w-52 text-sm">
                            No. Hp
                        </p>
                        <p class="text-sm">
                            : {{ $detail?->no_hp ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="mb-4 rounded-xl bg-red-100 text-red-700 p-4">
        <ul class="text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- MODAL EDIT PROFIL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white w-[1100px] h-[600px] rounded-3xl p-8">

        <h2 class="text-lg font-bold mb-10">
            Edit Informasi Profil
        </h2>

        <form action="{{ route('dosen.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex gap-14">

                {{-- FOTO --}}
                <div class="flex flex-col items-center">
                    <div class="w-40 h-40 rounded-2xl bg-gray-300 overflow-hidden mb-6">
                        <img id="previewFoto" src="{{ $fotoProfil }}" class="w-40 h-40 rounded-full object-cover">
                    </div>

                    <button type="button" id="btnUbahFoto" class="border text-sm px-8 py-2 rounded-2xl hover:bg-gray-100 transition">
                        Ubah Foto
                    </button>
                    <input type="file" id="fotoProfilInput" name="foto_profil" accept="image/*" class="hidden">
                </div>

                {{-- FORM --}}
                <div class="flex-1">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-7">
                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block mb-2 text-sm"> Jenis Kelamin </label>
                            <select name="jenis_kelamin" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="P" @selected(old('jenis_kelamin', $user->detailUser?->jenis_kelamin) === 'P')>
                                    Perempuan
                                </option>
                                <option value="L" @selected(old('jenis_kelamin', $user->detailUser?->jenis_kelamin) === 'L')>
                                    Laki-laki
                                </option>
                            </select>
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label class="block mb-2 text-sm"> Agama <span class="text-red-500">*</span></label>
                            <select name="agama" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" @selected(old('agama', $detail?->agama) === 'Islam')>Islam</option>
                                <option value="Kristen" @selected(old('agama', $detail?->agama) === 'Kristen')>Kristen</option>
                                <option value="Hindu" @selected(old('agama', $detail?->agama) === 'Hindu')>Hindu</option>
                                <option value="Buddha" @selected(old('agama', $detail?->agama) === 'Buddha')>Buddha</option>
                                <option value="Kong Hu Cu" @selected(old('agama', $detail?->agama) === 'Kong Hu Cu')>Kong Hu Cu</option>
                            </select>
                        </div>

                        {{-- TTL --}}
                        <div>
                            <label class="block mb-2 text-sm"> Tempat, Tanggal Lahir <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-1">
                                <input 
                                    type="text" 
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $user->detailUser?->tempat_lahir) }}"
                                    class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">                                
                                <p>,</p>
                                <input 
                                    type="date" 
                                    name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $user->detailUser?->tanggal_lahir) }}"
                                    class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block mb-2 text-sm"> Alamat </label>
                            <input 
                                type="text" 
                                name="alamat"
                                value="{{ old('alamat', $detail?->alamat) }}"
                                class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500"
                            >
                        </div>

                        {{-- Email pribadi --}}
                        <div>
                            <label class="block mb-2 text-sm"> Email Pribadi </label>
                            <input 
                                type="email" 
                                name="email_pribadi"
                                value="{{ old('email_pribadi', $detail?->email_pribadi) }}"
                                class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500"
                            >
                        </div>

                        {{-- No hp --}}
                        <div>
                            <label class="block mb-2 text-sm"> No. HP <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="no_hp"
                                value="{{ old('no_hp', $user->detailUser?->no_hp) }}"
                                class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500"
                            >
                        </div>
                    </div>

                    {{-- Batal n Simoan --}}
                    <div class="flex justify-end gap-4 mt-14">
                        <button type="button" id="closeModal" class="border text-sm px-10 py-2.5 rounded-2xl hover:bg-gray-100 transition">
                            Batal
                        </button>

                        <button type="submit" class="bg-[#415BE7]  text-sm text-white px-10 py-2.5 rounded-2xl hover:opacity-90 transition">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const editModal = document.getElementById('editModal');

    openModal?.addEventListener('click', () => {
        editModal.classList.remove('hidden');
    });

    closeModal?.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });

    editModal?.addEventListener('click', (event) => {
        if (event.target === editModal) {
            editModal.classList.add('hidden');
        }
    });

    // ubah foto
    const btn = document.getElementById('btnUbahFoto');
    const input = document.getElementById('fotoProfilInput');
    const preview = document.getElementById('previewFoto');

    btn.addEventListener('click', () => {
        input.click();
    });

    input.addEventListener('change', function () {
        if (this.files.length > 0) {
            const reader = new FileReader();
            
            reader.onload = function(e){
                preview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }

    });
</script>

@endsection