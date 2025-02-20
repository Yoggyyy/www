<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validación mejorada
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthday' => ['required', 'date', 'before:today']
        ]);

        // Creación del usuario con rol por defecto
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthday' => $data['birthday'],
            // Aseguramos que el rol sea 'member' por defecto
            'rol' => 'member'
        ]);

        // Autenticamos al usuario
        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Registro completado con éxito!');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación mejorada
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Intento de autenticación con remember me
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home')
                ->with('success', '¡Bienvenido de nuevo!');
        }

        // Si la autenticación falla
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Has cerrado sesión correctamente');
    }

    public function showAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function deleteAccount()
    {
        /** @var User */
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect()->route('home')->with('success', 'Tu cuenta ha sido eliminada correctamente');
    }
}
