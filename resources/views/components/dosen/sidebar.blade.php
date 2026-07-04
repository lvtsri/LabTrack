<div class="w-[220px] h-screen bg-white border-r flex flex-col justify-between fixed">

    <div>
        <div class="px-10 py-14">
            <h1 class="text-xl font-bold">LabTrack</h1>
        </div>

        <div class="flex flex-col gap-3 px-6">

            <a href="/dosen/dashboard" class="flex items-center gap-4 px-5 py-4 rounded-xl text-base font-semibold 
            {{ request()->is('mahasiswa/dashboard') ? 'bg-gray-100 text-black' : 'text-gray-400 hover:bg-gray-100' }}">
                <i class="fa-solid fa-house"></i>
                    <span class="text-sm">
                        Dashboard
                    </span>
            </a>

            <a href="/dosen/praktikum" class="flex items-center gap-4 px-5 py-4 rounded-xl font-semibold
            {{ request()->is('mahasiswa/praktikum*') ? 'bg-gray-100 text-black' : 'text-gray-400 hover:bg-gray-100' }}">
                <i class="fa-solid fa-book-open"></i></i>
                    <span class="text-sm">
                        Praktikum
                    </span>
            </a>

            <a href="/dosen/laporan" class="flex items-center gap-4 px-5 py-4 rounded-xl font-semibold
            {{ request()->is('mahasiswa/arsip') ? 'bg-gray-100 text-black' : 'text-gray-400 hover:bg-gray-100' }}">
                <i class="fa-solid fa-box-archive"></i>
                    <span class="text-sm">
                        Laporan
                    </span>
            </a>

            <a href="/dosen/profil" class="flex items-center gap-4 px-5 py-4 rounded-xl font-semibold
            {{ request()->is('mahasiswa/profil') ? 'bg-gray-100 text-black' : 'text-gray-400 hover:bg-gray-100' }}">
                <i class="fa-solid fa-user"></i>
                    <span class="text-sm">
                        Profil
                    </span>                
            </a>

        </div>
    </div>

    <div class="px-12 py-10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex items-center gap-3 text-red-300 font-semibold hover:text-red-500"
            >
                <i class="fa-solid fa-right-from-bracket"></i>

                <span class="text-sm">
                    Log Out
                </span>
            </button>
        </form>
    </div>

</div>