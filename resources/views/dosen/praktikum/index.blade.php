@extends('layouts.dosen')

@section('content')

<div class="mt-4 ml-[210px]">

    {{-- HEADER --}}
    <div class="mb-8">
        <div>
            <h1 class="text-lg font-bold">
                Kelas Praktikum
            </h1>
            <p class="text-sm text-gray-500">
                Kelola seluruh kelas praktikum yang Anda ampu.
            </p>
            <hr class="border-gray-400 mt-4">
        </div>
    </div>

    <div class="flex justify-end">
        <div class="flex gap-4">
            <button class="border border-black rounded-2xl px-4 py-2 text-sm hover:bg-gray-100 transition">
                Edit Kelas
            </button>

            <button id="openModal" class="bg-[#4a62ec] text-white rounded-2xl px-4 py-2 text-sm hover:opacity-90 transition">
                + Tambah Kelas
            </button>
        </div>
    </div>

    {{-- LIST PRAKTIKUM --}}
    @if($praktikum->isEmpty())
        <div class="bg-white rounded-3xl border p-10 text-center text-gray-500">
            Belum ada kelas praktikum.
        </div>
    @else

        <div class="grid grid-cols-3 gap-6 mt-8">
            @foreach($praktikum as $item)
                <a href="{{ route('dosen.praktikum.show', $item->id_praktikum) }}" class="rounded-2xl bg-[#586ce0] text-white p-7 shadow hover:shadow-lg hover:-translate-y-1 transition">
                    <h2 class="font-semibold text-xl">
                        {{ $item->kelas->nama_kelas }}
                        -
                        {{ $item->nama_praktikum }}
                    </h2>
                    <p class="mt-3 text-white/90">
                        • Semester {{ $item->semester }}
                    </p>
                </a>
            @endforeach
        </div>
    @endif
</div>

{{-- Modal Tambah Kelas --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl w-[550px] p-8">
        <h2 class="text-xl font-bold mb-8">
            Tambah Kelas Praktikum
        </h2>

        <form action="{{ route('dosen.praktikum.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                {{-- Nama Praktikum --}}
                <div>
                    <label class="block text-sm mb-2">
                        Nama Praktikum
                    </label>
                    <input type="text" name="nama_praktikum" value="{{ old('nama_praktikum') }}" class="w-full border rounded-xl px-4 py-3 focus:border-blue-500 outline-none" required>
                </div>
                {{-- Semester --}}
                <div>
                    <label class="block text-sm mb-2">
                        Semester
                    </label>
                    <select name="semester" class="w-full border rounded-xl px-4 py-3" required>
                        <option value="">Pilih Semester</option>
                        @for($i=1;$i<=8;$i++)
                            <option value="{{ $i }}"
                                @selected(old('semester')==$i)>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-sm mb-2">
                        Kelas
                    </label>
                    <select name="kelas_id" class="w-full border rounded-xl px-4 py-3" required>
                        <option value=""> Pilih Kelas </option>

                        @foreach($kelas as $item)
                            <option
                                value="{{ $item->id_kelas }}"
                                @selected(old('kelas_id')==$item->id_kelas)>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <button type="button" id="closeModal" class="border px-6 py-2 rounded-xl hover:bg-gray-100">
                    Batal
                </button>

                <button type="submit" class="bg-[#415BE7] text-white px-8 py-2 rounded-xl hover:opacity-90">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    const modal = document.getElementById('modalTambah');
    document.getElementById('openModal').onclick = () => {
        modal.classList.remove('hidden');
    }

    document.getElementById('closeModal').onclick = () => {
        modal.classList.add('hidden');
    }

    modal.addEventListener('click', (e)=>{
        if(e.target===modal){
            modal.classList.add('hidden');
        }
    });
</script>

@endsection