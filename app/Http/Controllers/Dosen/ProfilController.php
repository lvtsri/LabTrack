<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // $user->load('detailUser');
        $user->load('detailUser.kelas');

        return view('dosen.profil.index', compact('user'));
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
        ]);

        $detail = $user->detailUser()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $detail->update([
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'agama' => $validated['agama'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'email_pribadi' => $validated['email_pribadi'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        return redirect()
            ->route('dosen.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}