<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Documentacion;
use App\Models\Calificacion;
use App\Models\Publicacion;
use App\Models\Respuesta;
use App\Models\DocumentacionUsuario;
use App\Models\DocumentacionPublicacion;
use ZipArchive;
use Illuminate\Support\Str;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use PDF;
use Illuminate\Support\Facades\Storage;



class ProcesoA extends Controller
{
    function __construct()
    {
        //Aqui se configuran los permisos que se van a usar
        $this->middleware('permission:ver-procesos|crear-procesos|editar-procesos|calificar-procesos|borrar-procesos', ['only' => ['index']]);
        //store será para almacenar los datos
        $this->middleware('permission:crear-procesos', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-procesos', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-procesos', ['only' => ['destroy']]);
        $this->middleware('permission:calificar-procesos', ['only' => ['calificar']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $proceso = DB::table('proceso')->select('identificador', 'nombreProceso')->where('id', 1)->first();

        //obtiención del usuario actualmente autenticado.
        $user = Auth::user();

        if ($user->hasRole('Administrador')) {
            // Usuario con rol de administrador
            $publicaciones = Publicacion::with('documentacion')
                ->get();
        } else {

            // Usuario no administrador
            /**Se utiliza whereHas para realizar una consulta con restricciones en las relaciones */
            $publicaciones = Publicacion::whereHas('documentacion', function ($query) use ($user) {
                $query->whereHas('usuarios', function ($query) use ($user) {
                    $query->where('users_id', $user->id);
                });
            })
                ->with('documentacion')
                ->get();
        }

        // Ordenar las publicaciones por anioRegistro de mayor a menor
        $publicaciones = $publicaciones->sortByDesc('anioRegistro');

        $returnUrl = $request->query('return_url');

        return view('procesoA.index', compact('proceso', 'publicaciones', 'returnUrl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoProcesoId = 1;

        return view('procesoA.crear', compact('tipoProcesoId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validación
        $this->validate(
            $request,
            [
                'anioRegistro' => 'required|date_format:Y',
                'semestre_0' => 'required|size:1|in:1,2|regex:/^[0-9]+$/i',
                'semestre_1' => 'required|size:1|in:1,2|regex:/^[0-9]+$/i',
                'descripcion_0' => 'required|string|min:10|max:100|regex:/^[A-Za-zÑñ\s\-]+$/',
                'descripcion_1' => 'required|string|min:10|max:100|regex:/^[A-Za-zÑñ\s\-]+$/',
            ],
            [
                //Mensajes de error personalizados
                'anioRegistro.required' => 'El campo Año es obligatorio.',
                'anioRegistro.date_format' => 'El campo Año solo admite el año.',

                'semestre_0.required' => 'El campo semestre es obligatorio.',
                'semestre_0.size' => 'El campo semestre solo admite un número.',
                'semestre_0.in' => 'El campo semestre solo admite un 1 o un 2.',
                'semestre_0.regex' => 'El campo semestre solo admite valores numéricos sin espacios.',

                'semestre_1.required' => 'El campo semestre es obligatorio.',
                'semestre_1.size' => 'El campo semestre solo admite un número.',
                'semestre_1.in' => 'El campo semestre solo admite un 1 o un 2.',
                'semestre_1.regex' => 'El campo semestre solo admite valores numéricos sin espacios.',

                'descripcion_0.required' => 'El campo descripción es obligatorio.',
                'descripcion_0.string' => 'El campo descripción debe de ser tipo texto.',
                'descripcion_0.min' => 'El campo descripción debe de tener minimo 10 letras.',
                'descripcion_0.max' => 'El campo descripción debe de tener maximo 100 letras.',
                'descripcion_0.regex' => 'El campo descripción solo admite letras mayúsculas, minúsculas, espacios y "-".',

                'descripcion_1.required' => 'El campo descripción es obligatorio.',
                'descripcion_1.string' => 'El campo descripción debe de ser tipo texto.',
                'descripcion_1.min' => 'El campo descripción debe de tener minimo 10 letras.',
                'descripcion_1.max' => 'El campo descripción debe de tener maximo 100 letras.',
                'descripcion_1.regex' => 'El campo descripción solo admite letras mayúsculas, minúsculas, espacios y "-".',

            ]
        );


        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener el rol de administrador
        $adminRole = Role::where('name', 'administrador')->first();

        // Obtener los usuarios que no tienen el rol de administrador
        $usuarios = User::whereDoesntHave('roles', function ($query) use ($adminRole) {
            $query->where('id', $adminRole->id);
        })->get();

        // Obtener el año de la publicación desde la solicitud
        $año = $request->input('anioRegistro');

        // Verificar si ya existe una publicación para el año especificado en el mismo proceso
        $existePublicacion = Publicacion::where('proceso_id', 1)
            ->where('anioRegistro', $año)
            ->exists();

        if ($existePublicacion) {
            return redirect()->back()->withErrors(['anioRegistro' => 'Ya existe una publicación para el año ' . $año . ' en este proceso.']);
        }

        // Crea una nueva instancia de Publicacion
        $publicacion = new Publicacion();
        $publicacion->users_id = $userId;
        $publicacion->proceso_id = 1;
        $publicacion->anioRegistro = $año;
        $publicacion->save();

        // Obtener el proceso actualmente seleccionado
        $proceso = 'procesoA';

        // Crear las dos documentaciones y asignarlas a cada usuario
        for ($i = 0; $i < 2; $i++) {
            $documentacion = new Documentacion();
            $semestre = $request->input('semestre_' . $i);
            $descripcion = $request->input('descripcion_' . $i);
            $documentacion->semestre = $semestre;
            $documentacion->descripcion = $descripcion;
            $documentacion->users_id = $userId;
            $documentacion->save();

            // Asignar la documentación a los usuarios que no son administradoconcres
            foreach ($usuarios as $usuario) {
                $DocumentacionUsuario = new DocumentacionUsuario();
                $DocumentacionUsuario->documentacion_id = $documentacion->id;
                $DocumentacionUsuario->users_id = $usuario->id;
                $DocumentacionUsuario->save();
            }

            // Asignar la relación a la tabla pivote documentacion_publicacion
            $publicacion->documentacion()->attach($documentacion->id);

            // Subir archivos si se proporcionan
            if ($request->hasFile('archivos_' . $i)) {
                $archivos = $request->file('archivos_' . $i);
                $archivoPaths = [];

                foreach ($archivos as $archivo) {
                    if ($archivo->isValid()) {
                        $extension = $archivo->getClientOriginalExtension();
                        if (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                            $archivoNombre = $archivo->getClientOriginalName();
                            $archivoNombreUnico = $proceso . '_' . $año . '_' . Str::random(10) . '_' . $archivoNombre; // Generar un nombre único
                            $archivoPath = $archivo->storeAs('archivos', $archivoNombreUnico, 'public'); // Guardar el archivo con el nuevo nombre
                            $archivoPaths[] = $archivoPath; // Agregar el path del archivo a la lista de paths
                        }
                    }
                }

                if (!empty($archivoPaths)) {
                    $documentacion->archivo_path = implode('|', $archivoPaths);
                    $documentacion->save();
                }
            }
        }
        // Recuperar la documentación asociada a la publicación
        $documentaciones = $publicacion->documentacion;

        return redirect()->route('procesoA.index', compact('documentaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $tipoProcesoId = 1;

        $user = Auth::user(); // Se obtiene el usuario autenticado.
        $publicacion = $user->publicaciones()->where('id', $id)->first(); // Se busca la publicación del usuario con el ID proporcionado.

        if (!$publicacion) {
            // Si no se encuentra la publicación, se redirige de vuelta y se muestra un mensaje de error.
            return redirect()->back()->with('error', 'No tienes permiso para editar esta publicación y documentación.');
        }

        Breadcrumbs::for('editarPublicacionA', function ($trail) use ($publicacion) {
            $trail->parent('procesoA');
            $trail->push('Editar proceso', route('procesoA.edit', $publicacion->id));
        });

        $documentacion = $publicacion->documentacion; // Se obtiene la documentación asociada a la publicación.

        return view('procesoA.editar', compact('publicacion', 'documentacion', 'tipoProcesoId')); //Se utiliza la función compact para pasar las variables publicacion, documentacion y tipoProcesoId a la vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación
        $this->validate(
            $request,
            [
                'anioRegistro' => 'required|date_format:Y',
            ],
            [
                // Mensajes de error personalizados
                'anioRegistro.required' => 'El campo Año es obligatorio.',
                'anioRegistro.date_format' => 'El campo Año solo admite el año.',
            ]
        );

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener la publicación del usuario actual
        $publicacion = $user->publicaciones()->where('id', $id)->first();

        // Verificar si la publicación existe y si pertenece al usuario actual
        if (!$publicacion) {
            return redirect()->back()->with('error', 'No tienes permiso para editar esta publicación y documentación.');
        }

        // Obtener el ID del proceso actualmente seleccionado
        $procesoId = 1;

        // Obtener el año de la publicación desde la solicitud
        $año = $request->input('anioRegistro');

        // Verificar si ya existe una publicación para el año especificado en el mismo proceso
        $existePublicacion = Publicacion::where('proceso_id', $procesoId)
            ->where('anioRegistro', $año)
            ->where('id', '<>', $id) // Excluir la publicación actual que se está actualizando
            ->exists();

        if ($existePublicacion) {
            return redirect()->back()->withErrors(['anioRegistro' => 'Ya existe una publicación para el año ' . $año . ' en este proceso.']);
        }

        // Actualizar los campos de la publicación
        $publicacion->anioRegistro = $request->input('anioRegistro');
        // Actualizar otros campos de la publicación según tus necesidades
        $publicacion->save();

        // Obtener el proceso actualmente seleccionado
        $proceso = 'procesoA';

        // Actualizar la documentación asociada a la publicación
        foreach ($publicacion->documentacion as $documento) {
            $semestre = $request->input('semestre_' . $documento->id);
            $descripcion = $request->input('descripcion_' . $documento->id);

            // Verificar si se enviaron datos de documentación para este documento específico
            if ($semestre && $descripcion) {
                // Actualizar los campos de la documentación
                $documento->semestre = $semestre;
                $documento->descripcion = $descripcion;
                // Actualizar otros campos de la documentación según tus necesidades
                $documento->save();
            }

            // Guardar los archivos adjuntos
            if ($request->hasFile('archivos_' . $documento->id)) {
                $archivos = $request->file('archivos_' . $documento->id);
                $archivoPaths = [];

                foreach ($archivos as $archivo) {
                    if ($archivo->isValid()) {
                        $extension = $archivo->getClientOriginalExtension();
                        if (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                            $archivoNombre = $archivo->getClientOriginalName();
                            $archivoNombreUnico = $proceso . '_' . $publicacion->anioRegistro . '_' . Str::random(10) . '_' . $archivoNombre; // Generar un nombre único con nombre original
                            $archivoPath = $archivo->storeAs('archivos', $archivoNombreUnico, 'public'); // Guardar el archivo con el nuevo nombre
                            $archivoPaths[] = $archivoPath; // Agregar el path del archivo a la lista de paths
                        }
                    }
                }

                // Asociar las rutas de archivos con la documentación específica
                $documento->archivo_path = implode('|', $archivoPaths);
                $documento->save();
            }
        }

        return redirect()->route('procesoA.index')->with('success_edit', 'La publicación y documentación se han actualizado correctamente.');
    }

    /**
     * Sección RESPONDER
     */

    public function responder($id, $documentacionId)
    {
        // Obtener la publicación y documentación correspondiente al ID
        $publicacion = Publicacion::findOrFail($id);
        $documentacion = Documentacion::findOrFail($documentacionId);

        // Verificar si el usuario actual tiene permiso para responder a la publicación
        $user = Auth::user();
        if ($user->hasRole('Administrador')) {
            $error = 'Los usuarios con rol de administrador no pueden responder a esta publicación.';
            return redirect()->back()->with('error', 'Los usuarios con rol de administrador no pueden responder a esta publicación.');
        }

        // Obtener la respuesta existente, si existe
        $respuesta = Respuesta::where('documentacion_id', $documentacion->id)
            ->where('users_id', $user->id)
            ->first();

        // Obtener los archivos adjuntos de la documentación
        $archivosAdjuntos = [];
        if ($documentacion->archivo_path) {
            $archivosAdjuntos = explode('|', $documentacion->archivo_path);
        }


        Breadcrumbs::for('responderProcesoA', function ($trail) use ($id, $documentacionId) {
            $publicacion = Publicacion::findOrFail($id);
            $documentacion = Documentacion::findOrFail($documentacionId);

            $semestre = $documentacion->semestre;
            $anio = $publicacion->anioRegistro;

            $trail->parent('procesoA');
            $trail->push('Responder publicación', route('procesoA.responder', ['id' => $id, 'documentacionId' => $documentacionId])); // 'procesoA.responder' es el nombre de la ruta para responder a una publicación

            $trail->push('Año: ' . $anio);
            $trail->push('Semestre: ' . $semestre);
        });


        return view('procesoA.responder', compact('publicacion', 'documentacion', 'respuesta', 'archivosAdjuntos'));
    }

    public function guardarRespuesta(Request $request, $documentacionId)
    {
        // Obtener la documentación asociada al ID
        $documentacion = Documentacion::findOrFail($documentacionId);

        // Verificar si el usuario actual tiene permiso para responder a la documentación
        $user = Auth::user();
        if ($user->hasRole('Administrador')) {
            return redirect()->back()->with('error', 'Los usuarios con rol de administrador no pueden responder a esta documentación.');
        }

        // Validar y guardar los archivos adjuntos
        if ($request->hasFile('archivo')) {
            // Obtener los archivos adjuntos del formulario
            $archivos = $request->file('archivo');
            $archivoPaths = []; // Variable para almacenar los paths de los archivos guardados

            foreach ($archivos as $archivo) {
                $archivoNombreOriginal = $archivo->getClientOriginalName(); // Obtener el nombre original del archivo
                $archivoExtension = $archivo->getClientOriginalExtension(); // Obtener la extensión del archivo

                // Validar tipos de archivo permitidos
                if (in_array($archivoExtension, ['pdf', 'doc', 'docx', 'xlsx'])) {
                    $archivoNombreUnico = uniqid() . '_' . Str::slug(pathinfo($archivoNombreOriginal, PATHINFO_FILENAME)) . '.' . $archivoExtension; // Generar un nombre único basado en el tiempo y el nombre original

                    $archivoPath = $archivo->storeAs('archivos', $archivoNombreUnico, 'public'); // Guardar el archivo en la carpeta 'archivos' con el nombre único
                    $archivoPaths[] = $archivoPath; // Agregar el path del archivo a la lista de paths
                }
            }

            // Crear una nueva instancia de Respuesta y asignar los campos
            $respuesta = new Respuesta();
            $respuesta->archivo_path = implode('|', $archivoPaths); // Convertir la lista de paths en un string separado por '|'
            $respuesta->documentacion_id = $documentacion->id;
            $respuesta->users_id = $user->id;
            $respuesta->save();
        }
        return redirect()->back()->with('success2', 'El archivo se ha almacenado correctamente.');
    }


    public function descargarArchivos($id)
    {
        $respuesta = Respuesta::findOrFail($id); // Obtener la instancia de Respuesta correspondiente al ID proporcionado
        $archivos = explode('|', $respuesta->archivo_path); // Convertir el campo archivo_path en un array de rutas de archivos separados por '|'

        if (count($archivos) === 1) {
            // Descargar archivo individual si solo hay un archivo
            $archivoPath = $archivos[0]; // Obtener la ruta del archivo
            $archivoNombre = basename($archivoPath); // Obtener el nombre del archivo usando la ruta
            return response()->download(storage_path('app/public/' . $archivoPath), $archivoNombre); // Descargar el archivo
        } else {
            // Descargar archivos en formato ZIP si hay más de un archivo
            $zip = new ZipArchive(); // Crear una nueva instancia de ZipArchive
            $zipNombre = 'archivos_' . $id . '.zip'; // Nombre del archivo ZIP con el ID de la respuesta
            $zipPath = storage_path('app/public/' . $zipNombre); // Ruta del archivo ZIP


            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($archivos as $archivoPath) {
                    $archivoNombre = basename($archivoPath); // Obtener el nombre del archivo usando la ruta
                    $archivoFullPath = storage_path('app/public/' . $archivoPath); // Obtener la ruta completa del archivo
                    if (file_exists($archivoFullPath)) {
                        $zip->addFile($archivoFullPath, $archivoNombre); // Agregar el archivo al archivo ZIP
                    }
                }
                $zip->close(); // Cerrar el archivo ZIP
                return response()->download($zipPath, $zipNombre); // Descargar el archivo ZIP
            } else {
                // Manejar el caso en el que no se pudo crear el archivo ZIP
                return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
            }
        }
    }

    public function actualizarRespuesta(Request $request, $id)
    {
        // Verificar si el usuario actual tiene permiso para responder a la documentación
        $user = Auth::user();
        if ($user->hasRole('Administrador')) {
            return redirect()->back()->with('error', 'Los usuarios con rol de administrador no pueden responder a esta documentación.');
        }

        // Obtener la respuesta del archivo
        $respuesta = Respuesta::findOrFail($id);

        // Validar y guardar los nuevos archivos adjuntos
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');
            $archivoPaths = [];

            foreach ($archivos as $archivo) {
                $archivoNombreOriginal = $archivo->getClientOriginalName(); // Obtener el nombre original del archivo
                $archivoExtension = $archivo->getClientOriginalExtension(); // Obtener la extensión del archivo

                // Validar tipos de archivo permitidos
                if (in_array($archivoExtension, ['pdf', 'doc', 'docx', 'xlsx'])) {
                    $archivoNombreUnico = uniqid() . '_' . Str::slug(pathinfo($archivoNombreOriginal, PATHINFO_FILENAME)) . '.' . $archivoExtension; // Generar un nombre único basado en el tiempo y el nombre original

                    $archivoPath = $archivo->storeAs('archivos', $archivoNombreUnico, 'public'); // Guardar el archivo en la carpeta 'archivos' con el nombre único
                    $archivoPaths[] = $archivoPath;
                }
            }

            // Actualizar el campo archivo_path en la instancia de Respuesta
            $respuesta->archivo_path = implode('|', $archivoPaths);
            $respuesta->save();

            return redirect()->back()->with('success1', 'Los archivos se han actualizado correctamente.');
        }

        return redirect()->back()->with('error', 'No se ha seleccionado un nuevo archivo.');
    }




    // Método para mostrar el formulario de calificación de una actividad
    public function calificar($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        // Obtener las documentaciones asociadas a la publicación
        $documentaciones = $publicacion->documentacion;

        Breadcrumbs::for('calificarProcesoA', function ($trail) use ($publicacion) {
            $trail->parent('procesoA');
            $trail->push('Calificar publicación ' . $publicacion->anioRegistro, route('procesoA.calificar', $publicacion->id));
        });

        return view('procesoA.calificar', compact('publicacion', 'documentaciones'));
    }

    // Método para guardar la calificación de una actividad
    public function calificarRespuesta(Request $request)
    {
        // Validación
        $this->validate(
            $request,
            [
                'porcentajeCumplimiento' => 'required|numeric|min:0|max:100',
                'cumplimiento' => 'required|string',
                'estadoDocumentacion' => 'required|string',
                'comentario' => 'nullable|string', // Permitir comentario en blanco o con saltos de línea
                'respuesta_id' => 'required|integer',
                'users_id' => 'required|integer',
            ],
            [
                // Mensajes de error personalizados
                'porcentajeCumplimiento.required' => 'El campo Porcentaje de cumplimiento es obligatorio.',
                'porcentajeCumplimiento.date_format' => 'El campo Porcentaje de cumplimiento solo admite números.',
                'porcentajeCumplimiento.date_format' => 'El campo Porcentaje de cumplimiento solo admite números del 0 al 100.',

                'cumplimiento.required' => 'El campo Cumplimiento es obligatorio.',
                'cumplimiento.required' => 'El campo Cumplimiento debe de ser de tipo texto.',

                'estadoDocumentacion.required' => 'El campo Estado de la Documentación es obligatorio.',
                'estadoDocumentacion.required' => 'El campo Estado de la Documentación debe de ser de tipo texto.',

            ]
        );


        // Obtener los datos del formulario
        $respuesta_id = $request->input('respuesta_id');
        $users_id = $request->input('users_id');
        $comentario = $request->input('comentario') ?? 'Sin Comentarios'; // Asignar una cadena si el comentario es nulo
        $cumplimiento = $request->input('cumplimiento');
        $porcentajeCumplimiento = $request->input('porcentajeCumplimiento');
        $estadoDocumentacion = $request->input('estadoDocumentacion');


        // Crear un nuevo registro de calificación en la tabla "calificacion"

        $calificacion = new Calificacion();
        $calificacion->comentario = $comentario;
        $calificacion->cumplimiento = $cumplimiento;
        $calificacion->porcentajeCumplimiento = $porcentajeCumplimiento;
        $calificacion->estadoDocumentacion = $estadoDocumentacion;
        $calificacion->respuesta_id = $respuesta_id;
        $calificacion->users_id = $users_id;
        $calificacion->save();



        return redirect()->back()->with('success_Calificacion', 'Respuesta calificada exitosamente');
    }


    public function actualizarCalificacion(Request $request, $calificacionId)
    {
        $calificacion = Calificacion::findOrFail($calificacionId);

        $this->validate(
            $request,
            [
                'porcentajeCumplimiento' => 'required|numeric|min:0|max:100',
                'cumplimiento' => 'required|string',
                'estadoDocumentacion' => 'required|string',
                'comentario' => 'nullable|string', // Permitir comentario en blanco o con saltos de línea
            ],
            [
                'porcentajeCumplimiento.required' => 'El campo Porcentaje de cumplimiento es obligatorio.',
                'porcentajeCumplimiento.numeric' => 'El campo Porcentaje de cumplimiento solo admite números.',
                'porcentajeCumplimiento.min' => 'El campo Porcentaje de cumplimiento debe ser al menos :min.',
                'porcentajeCumplimiento.max' => 'El campo Porcentaje de cumplimiento no debe ser mayor que :max.',

                'cumplimiento.required' => 'El campo Cumplimiento es obligatorio.',
                'cumplimiento.string' => 'El campo Cumplimiento debe ser de tipo texto.',

                'estadoDocumentacion.required' => 'El campo Estado de la Documentación es obligatorio.',
                'estadoDocumentacion.string' => 'El campo Estado de la Documentación debe ser de tipo texto.',
            ]
        );

        $calificacion->comentario = $request->input('comentario') ?? 'Sin Comentarios'; // Si el comentario es nulo, asigna una cadena 
        $calificacion->cumplimiento = $request->input('cumplimiento');
        $calificacion->porcentajeCumplimiento = $request->input('porcentajeCumplimiento');
        $calificacion->estadoDocumentacion = $request->input('estadoDocumentacion');
        $calificacion->save();

        return redirect()->back()->with('success_Actualizar_Cal', 'La calificación ha sido actualizada correctamente.');
    }


    public function graficaDocumentacionCompletaPorAnio()
    {
        // Obtener todas las publicaciones con sus documentaciones asociadas
        $publicaciones = Publicacion::where('proceso_id', 1)->with('documentacion.calificaciones')->get();

        //Arreglos para almacenar la información 
        $anioCompletas = [];
        $anioIncompletas = [];
        $porcentajeCompletas = [];
        $datosGraficaBar = [];

        // Recorrer las publicaciones para contar las documentaciones completas e incompletas por año
        foreach ($publicaciones as $publicacion) {
            $anio = $publicacion->anioRegistro;

            // Contar las documentaciones completas e incompletas de la publicación actual
            $completas = $publicacion->documentacion->filter(function ($documentacion) {
                return $documentacion->calificaciones->where('estadoDocumentacion', 'Concluido')->count() > 0;
            });

            $incompletas = $publicacion->documentacion->filter(function ($documentacion) {
                return $documentacion->calificaciones->where('estadoDocumentacion', 'Faltante')->count() > 0;
            });

            // Calcular el porcentaje de completas respecto al total
            $totalDocumentaciones = count($completas) + count($incompletas);
            $porcentajeCompletas[$anio] = ($totalDocumentaciones > 0) ? (count($completas) / $totalDocumentaciones) * 100 : 0;

            // Agregar el conteo al arreglo correspondiente
            $anioCompletas[$anio] = count($completas);
            $anioIncompletas[$anio] = count($incompletas);
        }

        foreach ($publicaciones as $publicacion) {
            $anio = $publicacion->anioRegistro;

            /**Obtener todas las respuestas de las documentaciones asociadas a la publicación,
             * y para cada documentación, cargar sus calificaciones.
             */
            $respuestas = Respuesta::whereHas('documentacion', function ($query) use ($publicacion) {
                $query->whereHas('publicaciones', function ($query) use ($publicacion) {
                    $query->where('id', $publicacion->id);
                });
            }) //Cargar las calificaciones relacionadas con cada respuesta
                ->with('calificacion')->get();

            /** Calculo del cumplimiento promedio del primer y segundo semestre de las respuestas obtenidas
             * se realiza utilizando el método avg para obtener el promedio de los valores de las respuestas que corresponden al primer y segundo semestre. */
            $cumplimientoPrimerSemestre = $respuestas->where('documentacion.semestre', 1)->avg('calificacion.porcentajeCumplimiento');
            $cumplimientoSegundoSemestre = $respuestas->where('documentacion.semestre', 2)->avg('calificacion.porcentajeCumplimiento');

            // Agregar los datos al arreglo correspondiente
            $datosGraficaBar[$anio] = [
                'primerSemestre' => $cumplimientoPrimerSemestre,
                'segundoSemestre' => $cumplimientoSegundoSemestre,
            ];
        }
        // Depuración: Verificar los datos finales para la gráfica de barras
        //dd($datosGraficaBar);

        return view('procesoA.graficasA', compact('anioCompletas', 'anioIncompletas', 'porcentajeCompletas', 'datosGraficaBar'));
    }

    public function guardarImagenes(Request $request)
    {
        $image1 = $request->input('image1');
        $image2 = $request->input('image2');

        // Ruta donde se guardarán las imágenes temporales
        $rutaTemporal = public_path('capturas_temporales');

        if (!file_exists($rutaTemporal)) {
            mkdir($rutaTemporal, 0777, true);
        }

        // Genera nombres de archivo únicos con la extensión ".jpg"
        $nombreArchivo1 = 'captura_' . uniqid() . '.jpg';
        $nombreArchivo2 = 'captura_' . uniqid() . '.jpg';

        $rutaCompleta1 = $rutaTemporal . '/' . $nombreArchivo1;
        $rutaCompleta2 = $rutaTemporal . '/' . $nombreArchivo2;

        // Elimina el encabezado de los datos base64
        $image1 = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $image1);
        $image2 = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $image2);

        // Decodifica los datos base64 en imágenes
        $imagen1 = base64_decode($image1);
        $imagen2 = base64_decode($image2);

        // Guarda las imágenes en el servidor en formato JPEG
        if (file_put_contents($rutaCompleta1, $imagen1) && file_put_contents($rutaCompleta2, $imagen2)) {
            return response()->json(['success' => true, 'nombreImagen1' => $nombreArchivo1, 'nombreImagen2' => $nombreArchivo2]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function generaPDF($nombreImagen1, $nombreImagen2)
    {
        $proceso = DB::table('proceso')->select('identificador', 'nombreProceso')->where('id', 1)->first();

        $datos = $this->graficaDocumentacionCompletaPorAnio();

        // Calcular el porcentaje de documentaciones completas por año
        $porcentajeCompletas = [];

        $promedioCumplimientoPrimerSemestre = [];
        $promedioCumplimientoSegundoSemestre = [];

        foreach ($datos['anioCompletas'] as $anio => $completas) {
            $total = $completas + $datos['anioIncompletas'][$anio];
            $porcentajeCompletas[$anio] = ($total > 0) ? ($completas / $total) * 100 : 0;
        }

        foreach ($datos['datosGraficaBar'] as $anio => $valores) {
            $promedioCumplimientoPrimerSemestre[$anio] = $valores['primerSemestre'];
            $promedioCumplimientoSegundoSemestre[$anio] = $valores['segundoSemestre'];
        }

        // Rutas de las imágenes capturadas
        $rutaImagen1 = public_path('capturas_temporales/' . $nombreImagen1);
        $rutaImagen2 = public_path('capturas_temporales/' . $nombreImagen2);


        // variables en un array asociativo
        $viewData = [
            'proceso' => $proceso,
            'anioCompletas' => $datos['anioCompletas'],
            'anioIncompletas' => $datos['anioIncompletas'],
            'porcentajeCompletas' => $porcentajeCompletas,
            'promedioCumplimientoPrimerSemestre' => $promedioCumplimientoPrimerSemestre,
            'promedioCumplimientoSegundoSemestre' => $promedioCumplimientoSegundoSemestre,
            'rutaImagen1' => $rutaImagen1, // Pasa la ruta de la primera imagen
            'rutaImagen2' => $rutaImagen2, // Pasa la ruta de la segunda imagen

        ];

        $pdf = PDF::loadView('usuarios.reporteProceso', $viewData);
        // dd($viewData, $pdf);

        return $pdf->download('Reporte_Proceso_A.pdf');
    }

    public function eliminarImagenes(Request $request)
    {
        $nombreImagen1 = $request->input('nombreImagen1');
        $nombreImagen2 = $request->input('nombreImagen2');

        // Ruta completa de las imágenes a eliminar
        $rutaImagen1 = public_path('capturas_temporales/' . $nombreImagen1);
        $rutaImagen2 = public_path('capturas_temporales/' . $nombreImagen2);

        // Verifica si las imágenes existen y las elimína
        if (file_exists($rutaImagen1)) {
            unlink($rutaImagen1);
        }

        if (file_exists($rutaImagen2)) {
            unlink($rutaImagen2);
        }

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $publicacion = Publicacion::findOrFail($id);

            // Obtén todas las documentaciones relacionadas con la publicación
            $documentaciones = $publicacion->documentacion;

            // Elimina las relaciones en la tabla documentacion_publicacion
            DocumentacionPublicacion::where('publicacion_id', $publicacion->id)->delete();

            // Itera sobre las documentaciones y realiza la eliminación completa
            foreach ($documentaciones as $documentacion) {
                // Elimina asignaciones de documentación a usuarios en documentacion_usuario
                DocumentacionUsuario::where('documentacion_id', $documentacion->id)->delete();

                // Elimina la documentación de la base de datos
                $documentacion->delete();

                // Si hay un archivo adjunto, elimínalo del almacenamiento
                if ($documentacion->archivo_path) {
                    Storage::delete($documentacion->archivo_path);
                }
            }

            // Finalmente, elimina la publicación
            $publicacion->delete();

            return redirect()->route('procesoA.index')->with('success', 'La publicación y sus relaciones han sido eliminadas con éxito.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('procesoA.index')->with('error', 'Ha ocurrido un error al eliminar la publicación.');
        }
    }
}