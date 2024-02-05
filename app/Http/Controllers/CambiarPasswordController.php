<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CambiarPasswordController extends Controller
{
    //

    public function showChangePasswordForm()
    {
        
        return view('usuarios.cambiarContrasena');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'contrasenia_actual' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/',
            'contrasenia_nueva' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/|confirmed',
        ],
        [
            'contrasenia_actual.required' => 'El campo Contraseña Actual es obligatorio.',
            'contrasenia_actual.regex' => 'La Contraseña Actual no coincide.',

            'contrasenia_nueva.required' => 'El campo Contraseña Nueva es obligatorio.',
            'contrasenia_nueva.regex' => 'La Contraseña Nueva debe tener entre 8 y 15 caracteres, al menos un número, al menos una minúscula, al menos una mayúscula y al menos un caracter especial.',
            'contrasenia_nueva.confirmed' => 'Las contraseñas nuevas deben de coincidir.',
        ]);
 
        $user = Auth::user();

        if (!Hash::check($request->contrasenia_actual, $user->password)) {
            return redirect()->back()->withErrors(['contrasenia_actual' => 'La contraseña actual no coincide.']);
        }

        $user->password = Hash::make($request->contrasenia_nueva);
        $user->save();

        return redirect()->back()->with('success_cambio_contrasenia', '¡Contraseña cambiada exitosamente!');
    }
}
