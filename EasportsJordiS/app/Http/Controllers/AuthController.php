<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'max:255']
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthday' => $data['birthday']
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            //Guarda en memoria la ruta anterior a la cual no tenia acceso antes identificarse
            //Asi al inciar va directo a la pagina que no podia acceder por no estar iden
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Correo incorrecto']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    // Actualizar perfil de usuario
    public function updateProfile(Request $request)
    {
        //Como no es tipado fuerte le especifico el tipo de out que espera
        /** @var User */
        $user = Auth::user();

        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'unique:users,email'] . Auth::id(),
            'birthday' => ['date', 'nullable'],
        ]);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Actualizar datos con fill y save
        $user->fill([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'birthday' => $request->birthday ?? $user->birthday,
        ]);

        $user->save(); 

        return response()->json(['message' => 'Perfil actualizado correctamente', 'user' => $user]);
    }



    // Cambiar contraseña del usuario
    public function changePassword(Request $request)
    {
        //Como no es tipado fuerte le especifico el tipo de out que espera
        /** @var User */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($user && Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['message' => 'Contraseña actualizada correctamente']);
        }

        return response()->json(['error' => 'Contraseña actual incorrecta o usuario no autenticado'], 403);
    }


    // Eliminar cuenta del usuario
    public function deleteAccount()
    {
        //Como no es tipado fuerte le especifico el tipo de out que espera
        /** @var User */
        $user = Auth::user();

        if ($user) {
            // Cerrar sesión antes de eliminar
            Auth::logout();
            // Eliminar cuenta
            $user->delete();

            return response()->json(['message' => 'Cuenta eliminada correctamente']);
        }

        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }
}
