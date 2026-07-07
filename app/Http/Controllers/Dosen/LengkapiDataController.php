<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LengkapiDataController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user()->load('detailUser');

        if ($user->hasCompletedAcademicData()) {
            return redirect()->route('dosen.dashboard');
        }

        return view('dosen.lengkapi-data', compact('user'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nip' => 'required|string|max:30',
        ]);

        $user->detailUser()->updateOrCreate(
            ['user_id'=>$user->id],
            $validated
        );

        return redirect()->route('dosen.dashboard');
    }
}