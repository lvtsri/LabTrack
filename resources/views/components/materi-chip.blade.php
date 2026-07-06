<a
    href="{{ $materi->url }}"
    target="_blank"
    class="inline-flex min-h-[46px] items-center gap-3 rounded-lg border border-[#8d8d8d] bg-[#fbfbfc]
        px-4 py-2 text-[15px] font-medium text-[#222] transition hover:bg-gray-50">

    <i class="fa-solid {{ $materi->icon }} text-lg"></i>

    {{ $materi->nama_materi }}

</a>
