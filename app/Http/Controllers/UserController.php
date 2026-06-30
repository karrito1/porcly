<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeUserCreation($request);

        return view('users.index', [
            'users' => User::with('roles')->latest()->get(),
            'roles' => Role::all(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorizeUserCreation($request);

        return view('users.create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeUserCreation($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'exists:roles,name'],
        ], [
            'name.required' => 'Ingresa el nombre completo.',
            'name.max' => 'El nombre no puede superar 255 caracteres.',
            'email.required' => 'Ingresa el correo electrónico.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.lowercase' => 'Usa letras minúsculas en el correo electrónico.',
            'email.max' => 'El correo no puede superar 255 caracteres.',
            'email.unique' => 'Ya existe una cuenta registrada con este correo.',
            'password.required' => 'Ingresa una contraseña.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'role.exists' => 'El rol seleccionado no es válido.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->authorizeUserCreation($request);

        return view('users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::all(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeUserCreation($request);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'is_active' => ['boolean'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Ingresa el nombre completo.',
            'name.max' => 'El nombre no puede superar 255 caracteres.',
            'email.required' => 'Ingresa el correo electrónico.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.lowercase' => 'Usa letras minúsculas en el correo electrónico.',
            'email.max' => 'El correo no puede superar 255 caracteres.',
            'email.unique' => 'Ya existe una cuenta registrada con este correo.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'role.exists' => 'El rol seleccionado no es válido.',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        if ($request->has('role')) {
            $user->syncRoles($validated['role'] ? [$validated['role']] : []);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorizeUserCreation($request);

        if ($user->id === $request->user()->id) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado del sistema.');
    }

    private function authorizeUserCreation(Request $request): void
    {
        abort_unless($request->user()?->can('users.create'), 403);
    }
}
