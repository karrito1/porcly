<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeUserCreation($request);

        return view('users.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorizeUserCreation($request);

        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeUserCreation($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    private function authorizeUserCreation(Request $request): void
    {
        abort_unless($request->user()?->can('users.create'), 403);
    }
}
