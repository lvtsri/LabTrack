<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $email = $request->email;
        $email = strtolower($request->email);

        if (str_ends_with($email, '.stu@pnc.ac.id')) {
            $role = 'mahasiswa';
        } elseif (
            str_ends_with($email, '@pnc.ac.id')
            && !str_contains($email, '.stu@')
        ) {
            $role = 'dosen';
        } else {
            return back()->withErrors([
                'email' => 'Gunakan email resmi PNC.'
            ]);
        }

        // dd($email, $role);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // if ($user->role === 'mahasiswa') {
        //     $user->detailUser()->create([]);
        // }
        $user->detailUser()->create([]);
        
        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'dosen') {
            return redirect()->route('dosen.lengkapi-data');
        }

        return redirect()->route('mahasiswa.lengkapi-data');
    }
}
