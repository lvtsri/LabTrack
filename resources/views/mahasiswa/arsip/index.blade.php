@extends('layouts.mahasiswa')

@section('content')

<div class="mt-4 ml-[210px]">

    <h1 class="text-lg font-bold mb-2">
        Arsip
    </h1>

    <p class="text-sm text-gray-500">
        Semua laporan yang telah Anda kumpulkan tersimpan di sini.
    </p>

    <hr class="border-gray-400 mt-4 mb-6">

    {{-- Filter --}}
    <div class="flex gap-4 mb-10">

        <select
            class="w-64 px-4 py-3 border rounded-xl bg-white text-gray-500 focus:outline-none">
            <option>Kelas Praktikum</option>
        </select>

        <select
            class="w-64 px-4 py-3 border rounded-xl bg-white text-gray-500 focus:outline-none">
            <option>Status Kelas Praktikum</option>
        </select>

        <input
            type="text"
            class="flex-1 px-4 py-3 border rounded-xl focus:outline-none"
            placeholder=""
        >

        <button
            class="w-16 rounded-xl bg-blue-500 text-white flex items-center justify-center hover:bg-blue-600">
            🔍
        </button>

    </div>

    {{-- Hari ini --}}
    <h2 class="text-base font-semibold mb-4">Hari ini</h2>

    <div class="bg-white rounded-3xl shadow-md overflow-hidden mb-10">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr class="text-center h-16">
                    <th>Praktikum</th>
                    <th>Sesi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>File</th>
                </tr>
            </thead>

            <tbody>
                <tr class="text-center h-28">
                    <td>Pemrograman Berbasis Framework</td>
                    <td>3</td>
                    <td class="text-red-500 font-medium">
                        Belum direview
                    </td>
                    <td>05-03-2026</td>

                    <td>
                        <div class="flex flex-col gap-2 items-center">
                            <button
                                class="border rounded-full px-4 py-2 flex items-center gap-2 hover:bg-gray-50">
                                📄 PDF
                            </button>
                            <button
                                class="border rounded-full px-4 py-2 flex items-center gap-2 hover:bg-gray-50">
                                📄 PDF
                            </button>

                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>

    {{-- Seminggu lalu --}}
    <h2 class="text-base font-semibold mb-4">
        Seminggu yang lalu
    </h2>

    <div class="bg-white rounded-3xl shadow-md overflow-hidden mb-10">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr class="text-center h-16">
                    <th>Praktikum</th>
                    <th>Sesi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>File</th>
                </tr>
            </thead>

            <tbody>

                @for($i = 0; $i < 3; $i++)

                <tr class="text-center h-20 border-t">
                    <td>Pemrograman Berbasis Framework</td>
                    <td>3</td>
                    <td class="text-green-500 font-medium">
                        Selesai
                    </td>
                    <td>05-03-2026</td>
                    <td>
                        <button
                            class="border rounded-full px-4 py-2 flex items-center gap-2 mx-auto hover:bg-gray-50">
                            📄 PDF
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    {{-- Sebulan lalu --}}
    <h2 class="text-base font-semibold mb-4">
        Sebulan yang lalu
    </h2>

    <div class="bg-white rounded-3xl shadow-md overflow-hidden mb-10">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr class="text-center h-16">
                    <th>Praktikum</th>
                    <th>Sesi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>File</th>
                </tr>
            </thead>

            <tbody>

                @for($i = 0; $i < 2; $i++)

                <tr class="text-center h-20 border-t">

                    <td>Pemrograman Berbasis Framework</td>
                    <td>3</td>

                    <td class="text-green-500 font-medium">
                        Selesai
                    </td>

                    <td>05-03-2026</td>

                    <td>
                        <button
                            class="border rounded-full px-4 py-2 flex items-center gap-2 mx-auto hover:bg-gray-50">
                            📄 PDF
                        </button>
                    </td>

                </tr>

                @endfor

            </tbody>

        </table>

    </div>

</div>

@endsection