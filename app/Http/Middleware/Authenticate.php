<?php

// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Ruta a la que el usuario debería ser redirigido cuando no estén autenticados.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Manej de la solicitud entrante
     * 
     */
    public function handle($request, Closure $next, ...$guards)
    {
        /*Verificación si la solicitud debe pasar directamente sin autenticación 
        (según shouldPassThrough) */
        if ($this->shouldPassThrough($request)) {
            return $next($request);//Se pasa la solicitud al siguiente Middleware en la cadena
        }

        return parent::handle($request, $next, ...$guards);//Se devuelve su resultado
    }

    /**
     * Verificación si la solicitud debe pasar sin autenticación.
     */
    protected function shouldPassThrough($request)
{
    //  //rutas permitidas para pasar sin autenticación.
    $allowedRoutes = ['usuarioBloqueado', 'login']; 

    return in_array($request->route()->getName(), $allowedRoutes);//Obtención del nombre de la ruta actual
}

}

