<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/mgsi';

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Get the user by username (email or whatever field is used for login)
        $user = User::where('nombreUsuario', $request->nombreUsuario)->first();

        // Check if the user exists and is blocked
        if ($user && $user->estado) {
            return $this->sendLockedResponse();
        }

        // Check if the user exists and the password is correct
        if ($user && $this->attemptLogin($request)) {
            // Reset the login attempts and allow access
            $user->intentoSesion = 0;
            $user->save();
            return $this->sendLoginResponse($request);
        }

        // Increment the login attempts
        if ($user) {
            $user->intentoSesion += 1;
            if ($user->intentoSesion >= 3) {
                // Set the user as blocked after 4 unsuccessful attempts
                $user->estado = true;
            }
            $user->save();
        }

        // If the user does not exist or the password is incorrect, send a failed login response
        throw ValidationException::withMessages([
            $this->username() => [trans('Nombre de Usuario o Contraseña no valido')],
        ]);
    }

    /**
     * Get the locked response for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLockedResponse()
    {
        return redirect()->route('usuarioBloqueado');
    }
}
