<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'profile']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip_nim', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Filter by status - removed because users table doesn't have soft deletes
        // if ($request->filled('status')) {
        //     if ($request->status === 'active') {
        //         $query->whereNull('deleted_at');
        //     }
        // }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $user = null; // For create form, user is null
        return view('users.create', compact('roles', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'nullable|string|max:50|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',

            // Profile fields
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'] ?? null,
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        // Assign roles
        $user->assignRole($validated['roles']);

        // Create profile if any profile data is provided
        if ($request->filled(['institution', 'department', 'position', 'academic_degree', 'specialization'])) {
            UserProfile::create([
                'user_id' => $user->id,
                'faculty' => $validated['institution'] ?? null, // Map institution to faculty
                'department' => $validated['department'] ?? null,
                'position' => $validated['position'] ?? null,
                'academic_degree' => $validated['academic_degree'] ?? null,
                'expertise' => $validated['specialization'] ?? null, // Map specialization to expertise
            ]);
        }

        return redirect()->route('users.show', $user)
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'profile', 'permissions']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load(['roles', 'profile']);
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',

            // Profile fields
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:255',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Sync roles
        $user->syncRoles($validated['roles']);

        // Update or create profile
        if ($user->profile) {
            $user->profile->update([
                'faculty' => $validated['institution'] ?? null, // Map institution to faculty
                'department' => $validated['department'] ?? null,
                'position' => $validated['position'] ?? null,
                'academic_degree' => $validated['academic_degree'] ?? null,
                'expertise' => $validated['specialization'] ?? null, // Map specialization to expertise
            ]);
        } else {
            UserProfile::create([
                'user_id' => $user->id,
                'faculty' => $validated['institution'] ?? null, // Map institution to faculty
                'department' => $validated['department'] ?? null,
                'position' => $validated['position'] ?? null,
                'academic_degree' => $validated['academic_degree'] ?? null,
                'expertise' => $validated['specialization'] ?? null, // Map specialization to expertise
            ]);
        }

        return redirect()->route('users.show', $user)
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
