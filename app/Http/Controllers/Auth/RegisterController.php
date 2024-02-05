<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'min:3','max:255','regex:/[a-zA-Z\s\Ñ\ñ]/'],
            'apellidoP' => [ 'required','string','min:3', 'max:255','regex:/[a-zA-Z\s\Ñ\ñ]/'],
            'apellidoM' => [ 'required','string','min:3', 'max:255','regex:/[a-zA-Z\s\Ñ\ñ]/'],
            'nombreUsuario' => ['required', 'string','min:3', 'max:255','unique:users','regex:/[a-zA-Z\s\Ñ\ñ]/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/'],
        ],
        [
            //Mensajes de error personalizados
            'nombre.required' => 'El campo Nombre es obligatorio.',
            'nombre.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El campo Nombre no puede exceder los 255 caracteres.',
            'nombre.regex' => 'Los caracteres especiales  y numéricos no son válidos.',   
        
            'apellidoP.required' => 'El campo Apellido Paterno es obligatorio.',
            'apellidoP.min' => 'El campo Apellido Paterno debe tener al menos 3 caracteres.',
            'apellidoP.max' => 'El campo Apellido Paterno no puede exceder los 255 caracteres.',
            'apellidoP.regex' => 'Los carácteres especiales y numéricos no son válidos.',

            'apellidoM.required' => 'El Apellido Materno es obligatorio.',
            'apellidoM.min' => 'El Apellido Materno debe tener al menos 3 caracteres.',
            'apellidoM.max' => 'El Apellido Materno no puede exceder los 255 caracteres.',
            'apellidoM.regex' => 'Los carácteres especiales y numéricos no son válidos.',

            'nombreUsuario.required' => 'El campo Nombre de Usuario es obligatorio.',
            'nombreUsuario.min' => 'El campo Nombre de Usuario debe tener al menos 3 caracteres.',
            'nombreUsuario.max' => 'El campo Nombre de Usuario no puede exceder los 255 caracteres.',
            'nombreUsuario.unique' => 'El Nombre de Usuario ya se encuentra registrado.',
            'nombreUsuario.regex' => 'Los carácteres especiales y numéricos no son válidos.',
            
            'password.required' => 'El campo password es obligatorio.',
            'password.confirmed' => 'La contraseña debe tener entre 8 y 15 caracteres, al menos un número, al menos una minúscula, al menos una mayúscula y al menos un caracter especial.',
            'password.regex' => 'La contraseña debe tener entre 8 y 15 caracteres, al menos un número, al menos una minúscula, al menos una mayúscula y al menos un caracter especial.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre' => $data['nombre'],
            'apellidoP' => $data['apellidoP'],
            'apellidoM' => $data['apellidoM'],
            'nombreUsuario' => $data['nombreUsuario'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
