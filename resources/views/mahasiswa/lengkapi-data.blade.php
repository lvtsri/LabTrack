@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-white px-10">
    <div class="w-full max-w-5xl flex items-center justify-between gap-20">

        <div class="w-1/2">
            <div class="bg-[#dfe7f1] rounded-[40px] h-[600px] flex items-center justify-center p-10">
                <img src="https://about-analysis.com/wp-content/uploads/2022/01/Data-report-bro-1024x1024.png"
                    alt="Data Illustration"
                    class="w-full max-w-[550px]">
            </div>
        </div>

        <div class="w-1/2">
            <div class="mb-10 mt-10">
                <h1 class="text-2xl font-bold text-center mb-5">
                    Lengkapi Data Akademik
                </h1>
                <p class="text-center text-gray-700 text-sm leading-relaxed">
                    Isi data wajib berikut sebelum mengakses dashboard praktikum.
                </p>
            </div>

            <form method="POST" action="{{ route('mahasiswa.lengkapi-data.store') }}">
                @csrf

                <div class="space-y-7">
                    <div>
                        <div class="relative">
                            <i class="fa-regular fa-id-card absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>
                            <input
                                name="nim"
                                type="text"
                                value="{{ old('nim', $user->detailUser?->nim) }}"
                                required
                                placeholder="NIM"
                                class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                        </div>
                        @error('nim')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="relative">
                            <i class="fa-solid fa-graduation-cap absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>
                            <select
                                name="program_studi"
                                required
                                class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">
                                <option value="">Pilih Program Studi</option>
                                <option value="Teknik Informatika" @selected(old('program_studi', $user->detailUser?->program_studi) === 'Teknik Informatika')>
                                    Teknik Informatika
                                </option>
                                <option value="Rekayasa Keamanan Siber" @selected(old('program_studi', $user->detailUser?->program_studi) === 'Rekayasa Keamanan Siber')>
                                    Rekayasa Keamanan Siber
                                </option>
                                <option value="Teknologi Rekayasa Mutlimedia" @selected(old('program_studi', $user->detailUser?->program_studi) === 'Teknologi Rekayasa Mutlimedia')>
                                    Teknologi Rekayasa Mutlimedia
                                </option>
                                <option value="Akuntansi Lembaga Keuangan Syariah" @selected(old('program_studi', $user->detailUser?->program_studi) === 'Akuntansi Lembaga Keuangan Syariah')>
                                    Akuntansi Lembaga Keuangan Syariah
                                </option>
                                <option value="Rekayasa Perangkat Lunak" @selected(old('program_studi', $user->detailUser?->program_studi) === 'Rekayasa Perangkat Lunak')>
                                    Rekayasa Perangkat Lunak
                                </option>
                            </select>
                        </div>
                        @error('program_studi')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-users absolute left-6 top-1/2 -translate-y-1/2 text-gray-600 text-xl"></i>

                        <select
                            name="kelas_id"
                            required
                            class="w-full border border-black rounded-full py-3 pl-16 pr-6 text-sm outline-none focus:border-blue-500">

                            <option value="">Pilih Kelas</option>

                            @foreach ($kelas as $item)
                                <option
                                    value="{{ $item->id_kelas }}"
                                    @selected(old('kelas_id', $user->detailUser?->kelas_id) == $item->id_kelas)>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    @error('kelas_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-black text-white py-3 rounded-full text-sm font-semibold mt-6 hover:bg-[#4171BD] transition">
                    Simpan dan Lanjutkan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection