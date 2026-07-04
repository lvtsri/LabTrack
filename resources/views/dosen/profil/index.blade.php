@extends('layouts.dosen')

@section('content')

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

                    <img src="https://i.pinimg.com/736x/b2/fe/64/b2fe649664a1029a8e2e53ef014ac366.jpg" alt="" class="w-full h-full object-cover">

                </div>

                {{-- IDENTITAS --}}
                <div>

                    <h2 class="text-base font-bold mb-1">
                        Fajar Mahardika
                    </h2>

                    <p class="text-gray-500 text-base">
                        NIP. 199508282024061003
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

                        <p class="w-40 text-sm">
                            Jenis Kelamin
                        </p>

                        <p class="text-sm">
                            : Laki-laki
                        </p>

                    </div>

                    <div class="flex">

                        <p class="w-40 text-sm">
                            Tempat, Tanggal Lahir
                        </p>

                        <p class="text-sm">
                            : Cilacap, 1 Januari 1980
                        </p>

                    </div>

                    <div class="flex">

                        <p class="w-40 text-sm">
                            Agama
                        </p>

                        <p class="text-sm">
                            : Islam
                        </p>

                    </div>

                </div>

                {{-- kanan --}}
                <div class="space-y-5">

                    <div class="flex">

                        <p class="w-40 text-sm">
                            Email Kampus
                        </p>

                        <p class="text-sm break-all">
                            : fajarmahardika.stu@pnc.ac.id
                        </p>

                    </div>

                    <div class="flex">

                        <p class="w-40 text-sm">
                            Email Pribadi
                        </p>

                        <p class="text-sm break-all">
                            : fajarmahardika@gmail.com
                        </p>

                    </div>

                    <div class="flex">

                        <p class="w-40 text-sm">
                            No. Hp
                        </p>

                        <p class="text-sm">
                            : 0123-4567-890
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

{{-- MODAL EDIT PROFIL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white w-[1100px] h-[600px] rounded-3xl p-8">

        {{-- HEADER --}}
        <h2 class="text-lg font-bold mb-10">
            Edit Informasi Profil
        </h2>
        <form action="" method="POST">  
            <div class="flex gap-14">

                {{-- FOTO --}}
                <div class="flex flex-col items-center">
                    <div class="w-40 h-40 rounded-2xl bg-gray-300 overflow-hidden mb-6">
                        <img src="https://i.pinimg.com/736x/b2/fe/64/b2fe649664a1029a8e2e53ef014ac366.jpg" class="w-full h-full object-cover">
                    </div>

                    <button class="border text-sm px-8 py-2 rounded-2xl hover:bg-gray-100 transition">
                        Ubah Foto
                    </button>
                </div>

                {{-- FORM --}}
                <div class="flex-1">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-7">

                        <div>
                            <label class="block mb-2 text-sm">
                                Nama Depan <span class="text-red-500">*</span>
                            </label>

                            <input type="text" class="w-full border-2 rounded-2xl text-sm px-5 py-2 outline-none focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Nama Belakang </label>
                            <input type="text" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select type="text" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="Perempuan">
                                    Perempuan
                                </option>

                                <option value="Laki-laki">
                                    Laki-laki
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Email Kampus </label>    
                            <input type="email" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Tempat, Tanggal Lahir <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-1">
                                <input type="text" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
                                <p>,</p>
                                <input type="date" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Email Pribadi </label>
                            <input type="email" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> Agama <span class="text-red-500">*</span></label>
                            <select type="text" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Kong Hu Cu">Kong Hu Cu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm"> No. HP <span class="text-red-500">*</span></label>
                            <input type="number" class="w-full border-2 text-sm rounded-2xl px-5 py-2 outline-none focus:border-blue-500" required>
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

@endsection