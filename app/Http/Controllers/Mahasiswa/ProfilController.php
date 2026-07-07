<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // $user->load('detailUser');
        $user->load('detailUser.kelas');

        return view('mahasiswa.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'agama' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'email_pribadi' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        $detail = $user->detailUser()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        if ($request->hasFile('foto_profil')) {

            // hapus foto lama
            if ($detail->foto_profil) {
                Storage::disk('public')->delete($detail->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto-profil', 'public');

            $validated['foto_profil'] = $path;
        }

        $detail->update([
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'agama' => $validated['agama'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'email_pribadi' => $validated['email_pribadi'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'foto_profil' => $validated['foto_profil'] ?? $detail->foto_profil,
        ]);

        return redirect()
            ->route('mahasiswa.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}