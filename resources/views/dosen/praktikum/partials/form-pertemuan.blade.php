<div class="space-y-4">
    <div>
        <label class="mb-1 block font-medium">Judul Pertemuan</label>
        <input type="text" name="judul" value="{{ old('judul', $pertemuan?->judul) }}" class="w-full rounded-xl border p-3" required>
    </div>

    <div>
        <label class="mb-1 block font-medium">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="w-full rounded-xl border p-3">{{ old('deskripsi', $pertemuan?->deskripsi) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="mb-1 block font-medium">Tanggal</label>
            <input type="date" name="tanggal_pertemuan" value="{{ old('tanggal_pertemuan', $pertemuan?->tanggal_pertemuan?->format('Y-m-d')) }}" class="w-full rounded-xl border p-3">
        </div>
        <div>
            <label class="mb-1 block font-medium">Jam Mulai</label>
            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $pertemuan?->jam_mulai ? \Carbon\Carbon::parse($pertemuan->jam_mulai)->format('H:i') : null) }}" class="w-full rounded-xl border p-3">
        </div>
        <div>
            <label class="mb-1 block font-medium">Jam Selesai</label>
            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $pertemuan?->jam_selesai ? \Carbon\Carbon::parse($pertemuan->jam_selesai)->format('H:i') : null) }}" class="w-full rounded-xl border p-3">
        </div>
        <div>
            <label class="mb-1 block font-medium">Deadline</label>
            <input type="datetime-local" name="deadline" value="{{ old('deadline', $pertemuan?->deadline?->format('Y-m-d\TH:i')) }}" class="w-full rounded-xl border p-3">
        </div>
    </div>

    <div>
        <label class="mb-1 block font-medium">Upload Materi Baru</label>
        <input type="file" name="materi" class="w-full rounded-xl border p-3">
    </div>

    <div>
        <label class="mb-1 block font-medium">Link Materi Baru</label>
        <input type="url" name="link_materi" value="{{ old('link_materi') }}" class="w-full rounded-xl border p-3">
    </div>

    <div>
        <label class="mb-1 block font-medium">Wajib Laporan</label>
        <select name="wajib_laporan" class="w-full rounded-xl border p-3">
            <option value="1" @selected((string) old('wajib_laporan', $pertemuan?->wajib_laporan ?? 1) === '1')>Ya</option>
            <option value="0" @selected((string) old('wajib_laporan', $pertemuan?->wajib_laporan ?? 1) === '0')>Tidak</option>
        </select>
    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <button type="button" data-close-modal class="rounded-xl border px-6 py-2 transition hover:bg-gray-100">Batal</button>
    <button type="submit" class="rounded-xl bg-[#415BE7] px-6 py-2 text-white transition hover:opacity-90">Simpan</button>
</div>
