<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documentacion;
use App\Models\Calificacion;
use App\Models\Publicacion;
use App\Models\Respuesta;
use App\Models\DocumentacionUsuario;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class DataTableController extends Controller
{
    /** Método para obtener una lista de usuarios en formato JSON */
    public function getUsuarios(Request $request)
    {
        // Consulta para obtener los usuarios junto con sus roles
        $usuarios = User::with('roles');

        // Complemento DataTables: formateamos los resultados y los devolvemos en formato JSON
        return datatables()
            ->eloquent($usuarios)  // Utilizamos la consulta preparada
            ->addColumn('roles', function ($user) {
                // Creamos una columna virtual 'roles' para mostrar los roles del usuario
                return $user->roles->pluck('name')->implode(', ');
            })
            ->addColumn('estado', function ($user) {
                // Creamos una columna virtual 'estado' para mostrar 'Activo' o 'Bloqueado'
                return ($user->estado == 0) ? 'Activo' : 'Bloqueado';
            })
            ->filter(function ($query) use ($request) {
                // Filtramos los resultados según los parámetros de búsqueda
                if ($request->has('search') && !empty($request->input('search.value'))) {
                    $searchValue = $request->input('search.value');

                    // Aplicamos filtros a las diferentes columnas y relaciones de la tabla
                    $query->where('nombre', 'LIKE', "%$searchValue%")
                        ->orWhere('apellidoP', 'LIKE', "%$searchValue%")
                        ->orWhere('apellidoM', 'LIKE', "%$searchValue%")
                        ->orWhere('nombreUsuario', 'LIKE', "%$searchValue%")
                        ->orWhere('email', 'LIKE', "%$searchValue%")
                        ->orWhereHas('roles', function ($query) use ($searchValue) {
                            $query->where('name', 'LIKE', "%$searchValue%");
                        })
                        ->orWhere(function ($query) use ($searchValue) {
                            // Manejo especial para buscar en la columna 'estado'
                            if ($searchValue === 'Activo' || $searchValue === 'Bloqueado') {
                                $estadoValue = ($searchValue === 'Activo') ? 0 : 1;
                                $query->where('estado', $estadoValue);
                            }
                        });
                }
            })
            ->toJson(); // Devolvemos los resultados en formato JSON
    }



    /**Método se utiliza para obtener una lista de roles en formato JSON */
    public function getRoles()
    {
        $roles = DB::table('roles')->get();

        return datatables()->of($roles)->toJson();
    }


    /** Método para obtener una lista de documentaciones en formato JSON */
    public function getDocumentaciones(Request $request)
    {
        $publicacionId = $request->input('publicacion_id');
        $documentaciones = Documentacion::where('publicacion_id', $publicacionId)->with(['usuarios', 'respuestas.calificacion']);

        /** Se verifica si existe un parámetro de búsqueda llamado "search" en la solicitud y si su valor no está vacío */
        if ($request->has('search') && !empty($request->input('search.value'))) {
            /** Se obtiene el valor del parámetro de búsqueda del campo "value" */
            $searchValue = $request->input('search.value');

            $documentaciones->where(function ($query) use ($searchValue) {
                $query->where('semestre', 'LIKE', "%$searchValue%")
                    ->orWhere('descripcion', 'LIKE', "%$searchValue%");
            });
        }

        /** Complemento DataTables para formatear los resultados de la consulta en formato JSON y se devuelve como respuesta */
        return DataTables::of($documentaciones)->toJson();
    }
}
