<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'institution' => ['nullable', 'string', 'max:255'],
            'nip_nim' => ['nullable', 'string', 'max:50'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'institution' => $request->institution,
            'nip_nim' => $request->nip_nim,
            'approval_status' => 'pending', // Set status pending untuk approval
        ]);

        // Assign role menggunakan Spatie (by role object or name)
        $role = Role::findById($request->role_id);
        $user->assignRole($role);

        event(new Registered($user));

        // TIDAK langsung login, redirect ke halaman informasi
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan admin. Anda akan menerima notifikasi email setelah akun disetujui.');
    }
}
