<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Publicacion;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Proceso;
use Illuminate\Support\Facades\File;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use PDF;

class UsuarioController extends Controller
{

    function __construct()
    {
        //Aqui se configuran los permisos que se van a usar
        $this->middleware('permission:ver-usuarios|crear-usuarios|editar-usuarios|borrar-usuarios', ['only' => ['index']]);
        //store será para almacenar los datos
        $this->middleware('permission:crear-usuarios', ['only' => ['create', 'store']]);
        //update será para actualiza los datos
        $this->middleware('permission:editar-usuarios', ['only' => ['edit', 'update']]);
        //destroy será para eliminar los datos
        $this->middleware('permission:borrar-usuarios', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //iniciamos con la paginación y ocultamos el usuario logeado de los demás
        $usuarios = User::where('id', '!=', Auth::id())->paginate();

        $returnUrl = $request->query('return_url');

        //pasamos el arreglo que va a tener todos los usuarios, igual la vista que estará en la carpeta usuarios.index
        return view('usuarios.index', compact('usuarios', 'returnUrl', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtienención de todos los roles de la base de datos utilizando el modelo Role.
        // El método pluck('name','name') se utiliza para obtener una lista de nombres de roles, el valor y la etiqueta son el nombre del rol. 
        //El método all() se utiliza para obtener todos los resultados como un array.
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Creación de las validaciones
        $this->validate(
            $request,
            [
                'nombre' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú\s]+$/u',
                'apellidoP' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u',
                'apellidoM' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u',
                'nombreUsuario' => 'required|min:3|max:255|unique:users|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u',
                'estado' => 'required',
                'intentoSesion' => 'required',
                //pedimos que sea un email valido y que no este duplicado
                'email' => 'required|email|unique:users,email',
                //pedimos que confirme su contraseña
                'password' => 'required|same:confirm-password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/',
                'roles' => 'required'
            ],
            [
                //Mensajes de error personalizados
                'nombre.required' => 'El campo Nombre es obligatorio.',
                'nombre.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
                'nombre.max' => 'El campo Nombre no puede exceder los 255 caracteres.',
                'nombre.regex' => 'Los caracteres especiales y numéricos no son válidos.',

                'apellidoP.required' => 'El campo Apellido Paterno es obligatorio.',
                'apellidoP.min' => 'El campo Apellido Paterno debe tener al menos 3 caracteres.',
                'apellidoP.max' => 'El campo Apellido Paterno no puede exceder los 255 caracteres.',
                'apellidoP.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'apellidoM.required' => 'El Apellido Materno es obligatorio.',
                'apellidoM.min' => 'El Apellido Materno debe tener al menos 3 caracteres.',
                'apellidoM.max' => 'El Apellido Materno no puede exceder los 255 caracteres.',
                'apellidoM.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'nombreUsuario.required' => 'El campo Nombre de Usuario es obligatorio.',
                'nombreUsuario.min' => 'El campo Nombre de Usuario debe tener al menos 3 caracteres.',
                'nombreUsuario.max' => 'El campo Nombre de Usuario no puede exceder los 255 caracteres.',
                'nombreUsuario.unique' => 'El Nombre de Usuario ya se encuentra registrado.',
                'nombreUsuario.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'email.unique' => 'El Correo ya se encuentra registrado.',

                'intentoSesion.required' => 'El campo Nombre de Usuario es obligatorio.',

                'password.required' => 'El campo password es obligatorio.',
                'password.same' => 'Las contraseñas no coinciden, inténtelo de nuevo.',
                'password.regex' => 'La contraseña debe tener entre 8 y 15 caracteres, al menos un número, al menos una letra minúscula, al menos una letra mayúscula y al menos un caracter especial.',
            ]
        );

        /** Se obtienen todos los datos del formulario y se asignan a la variable $input */
        $input = $request->all();

        //Se utiliza la función Hash::make() para cifrar la contraseña ingresada por el usuario antes de almacenarla en la base de datos.
        $input['password'] = Hash::make($input['password']);

        // Nuevo registro en la base de datos utilizando los datos proporcionados en $input
        $user = User::create($input);

        /**Se asigna el rol seleccionado al nuevo usuario utilizando el método assignRole() del modelo User*/
        $user->assignRole($request->input('roles'));

        // Verificar si el usuario no tiene el rol de "Administrador"
        if (!$user->hasRole('Administrador')) {
            // Obtener todas las publicaciones existentes en la base de datos
            $publicaciones = Publicacion::all();

            // Recorrer cada publicación y asociarla al usuario recién creado
            foreach ($publicaciones as $publicacion) {
                // Obtener la documentación asociada a la publicación
                $documentacion = $publicacion->documentacion;

                // Asignar la documentación al usuario recién creado
                $user->documentaciones()->attach($documentacion, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //Primero captura el usuario, el rol y la relación de ambos
        $user = User::find($id);

        //Se obtienen todos los roles de la base de datos.
        $roles = Role::pluck('name', 'name')->all();

        //Se obtienen los roles asociados al usuario en edición utilizando la relación definida en el modelo User. 
        //Se utiliza el método pluck('nombre','nombre') para obtener una lista de nombres de roles asociados al usuario, donde el valor y la etiqueta son el nombre del rol.
        $userRole = $user->roles->pluck('nombre', 'nombre')->all();

        Breadcrumbs::for('editarUsuario', function ($trail) use ($user) {
            $trail->parent('usuarios');
            $trail->push('Editar usuario', route('usuarios.edit', $user->id)); // Proporciona el ID del usuario
        });

        /*Despues retorna la vista de editar pasando las variables $user, $roles y $userRole
         permitiendo acceder a los datos del usuario, la lista de roles y los roles asociados al usuario en la vista de edición.*/
        return view('usuarios.editar', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $this->validate(
            $request,
            [
                'nombre' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú\s]+$/u',
                'apellidoP' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u',
                'apellidoM' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u',
                'nombreUsuario' => 'required|min:3|max:255|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u|unique:users,nombreUsuario,' . $id,
                //pedimos que sea un email valido y que no este duplicado
                'email' => 'required|email|unique:users,email,' . $id,
                //pedimos que confirme su contraseña
                'password' => 'same:confirm-password',
                'roles' => 'required'
            ],
            [
                //Mensajes de error personalizados
                'nombre.required' => 'El campo Nombre es obligatorio.',
                'nombre.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
                'nombre.max' => 'El campo Nombre no puede exceder los 255 caracteres.',
                'nombre.regex' => 'Los caracteres especiales y numéricos no son válidos.',

                'apellidoP.required' => 'El campo Apellido Paterno es obligatorio.',
                'apellidoP.min' => 'El campo Apellido Paterno debe tener al menos 3 caracteres.',
                'apellidoP.max' => 'El campo Apellido Paterno no puede exceder los 255 caracteres.',
                'apellidoP.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'apellidoM.required' => 'El Apellido Materno es obligatorio.',
                'apellidoM.min' => 'El Apellido Materno debe tener al menos 3 caracteres.',
                'apellidoM.max' => 'El Apellido Materno no puede exceder los 255 caracteres.',
                'apellidoM.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'nombreUsuario.required' => 'El campo Nombre de Usuario es obligatorio.',
                'nombreUsuario.min' => 'El campo Nombre de Usuario debe tener al menos 3 caracteres.',
                'nombreUsuario.max' => 'El campo Nombre de Usuario no puede exceder los 255 caracteres.',
                'nombreUsuario.unique' => 'El Nombre de Usuario ya se encuentra registrado.',
                'nombreUsuario.regex' => 'Los carácteres especiales, numéricos y espacios no son válidos.',

                'email.unique' => 'El Correo ya se encuentra registrado.',

                'password.same' => 'Las contraseñas no coinciden, inténtelo de nuevo.',
            ]
        );

        $input = $request->all();

        /** Verificar si se ha proporcionado una nueva contraseña. Si es así, se realiza el hash de la contraseña
         *  y se actualiza el campo 'password' en el array $input. 
         * Si no se ha proporcionado una contraseña, se elimina el campo 'password' del array $input utilizando Arr::except(). */
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        //Se obtiene el usuario existente
        $user = User::find($id);
        $user->update($input);

        //Se eliminan los roles anteriores del usuario en la tabla 'model_has_roles' 
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        //Se asignan los nuevos roles seleccionados al usuario 
        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index')->with('success', '¡Datos guardados exitosamente!');
    }

    /**Vista del USUARIO BLOQUEADO */
    public function verPerfil()
    {
        $user = Auth::user();

        // Genera el breadcrumb para la página de visualización de perfil
        Breadcrumbs::for('verPerfil', function ($trail) use ($user) {
            $trail->parent('home'); // Asegúrate de que 'home' coincida con el nombre del breadcrumb para la página de inicio
            $trail->push('Perfil', route('UsuarioController.verPerfil')); // 'usuarios.verPerfil' es el nombre de la ruta para ver el perfil
        });

        return view('usuarios.verPerfil', compact('user'));
    }

    /**Vista del USUARIO BLOQUEADO */
    public function usuarioBloqueado()
    {
        return view('usuarios.usuarioBloqueado');
    }

    /**
     * Método para obtener los datos necesarios para la gráfica de porcentaje de cumplimiento.
     */
    public function obtenerDatosGraficaCumplimientoTodosProcesos()
    {
        $procesos = Proceso::all();

        $datosGrafica = [];
        $hayDatos = false;

        foreach ($procesos as $proceso) {
            $publicaciones = $proceso->publicaciones()->with('documentacion.calificaciones')->get();

            if ($publicaciones->isEmpty()) {
                continue; // Salta al siguiente proceso si no hay publicaciones
            }
    
            $hayDatos = true; // Indica que hay al menos un proceso con publicaciones
    
            $porcentajesPorAnio = [];

            foreach ($publicaciones as $publicacion) {
                $porcentajeTotal = 0;
                $calificacionesCompletas = 0;
                $calificacionesTotales = 0;

                foreach ($publicacion->documentacion as $documentacion) {
                    $calificaciones = $documentacion->calificaciones;
                    $calificacionesTotales += $calificaciones->count();
                    $calificacionesCompletas += $calificaciones->sum('porcentajeCumplimiento');
                }

                if ($calificacionesTotales > 0) {
                    $porcentajeTotal = ($calificacionesCompletas / $calificacionesTotales);
                }

                $porcentajesPorAnio[$publicacion->anioRegistro] = [
                    'porcentajeTotal' => round($porcentajeTotal, 3),
                    'semestre1' => 0,
                    'semestre2' => 0,
                ];

                foreach ($publicacion->documentacion as $documentacion) {
                    if ($documentacion->semestre === 1) {
                        $porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] += $documentacion->calificaciones->sum('porcentajeCumplimiento');
                    } elseif ($documentacion->semestre === 2) {
                        $porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] += $documentacion->calificaciones->sum('porcentajeCumplimiento');
                    }
                }

                $porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] = $porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] > 0 ? ($porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] / $calificacionesTotales) : 0;
                $porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] = $porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] > 0 ? ($porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] / $calificacionesTotales) : 0;
            }

            $datosGrafica[] = [
                'identificador' => $proceso->identificador,
                'porcentajes' => $porcentajesPorAnio,
                'anio' => $publicacion->anioRegistro, // Agrega esta línea para incluir 'anio'
                'semestre' => $documentacion->semestre,
            ];
        }
      
    if (!$hayDatos) {
        return ['message' => 'Sin datos para mostrar la gráfica'];
    }


        return $datosGrafica;
    }


    /**Gráficas de dona */
    public function calcularPorcentajeCumplimiento()
    {
        $identificadores = Proceso::pluck('identificador');

        $resultados = [];

        foreach ($identificadores as $identificador) {
            $anios = Publicacion::where('proceso_id', function ($query) use ($identificador) {
                $query->select('id')->from('proceso')->where('identificador', $identificador);
            })
                ->distinct()
                ->pluck('anioRegistro');

            foreach ($anios as $anio) {
                $porcentajesSemestrales = $this->calcularPorcentajesSemestrales($identificador, $anio);

                foreach ($porcentajesSemestrales as $semestre => $porcentaje) {
                    $resultados[] = [
                        'identificador' => $identificador,
                        'anio' => $anio,
                        'semestre' => $semestre,
                        'porcentajeCumplimiento' => $porcentaje,
                    ];
                }
            }
        }

        return $resultados;
    }

    private function calcularPorcentajesSemestrales($identificador, $anio)
    {
        $publicacion = Publicacion::where('proceso_id', function ($query) use ($identificador) {
            $query->select('id')->from('proceso')->where('identificador', $identificador);
        })
            ->where('anioRegistro', $anio)
            ->first();

        if (!$publicacion) {
            return []; // Puedes manejar el caso en que no haya publicación para el identificador y año.
        }

        $documentaciones = $publicacion->documentacion;

        if ($documentaciones->isEmpty()) {
            return []; // Puedes manejar el caso en que no haya documentaciones para la publicación.
        }

        $porcentajesSemestrales = [];

        foreach ($documentaciones as $documentacion) {
            $calificaciones = $documentacion->calificaciones;

            if ($calificaciones->isEmpty()) {
                continue; // Puedes manejar el caso en que no haya calificaciones para una documentación específica.
            }

            // Calcula el promedio de porcentajes de cumplimiento para cada documentación
            $porcentajePromedio = $calificaciones->avg('porcentajeCumplimiento');
            $semestre = $documentacion->semestre;

            if (!isset($porcentajesSemestrales[$semestre])) {
                $porcentajesSemestrales[$semestre] = [];
            }

            $porcentajesSemestrales[$semestre][] = $porcentajePromedio;
        }

        foreach ($porcentajesSemestrales as $semestre => $porcentajes) {
            $porcentajesSemestrales[$semestre] = count($porcentajes) > 0 ? array_sum($porcentajes) / count($porcentajes) : 0;
        }

        return $porcentajesSemestrales;
    }


    /**
     * Método para mostrar la gráfica de porcentaje de cumplimiento.
     */
    public function mostrarGraficaCumplimiento()
    {
        //Obtención de los datos de la gráfica
        $datosGrafica = $this->obtenerDatosGraficaCumplimientoTodosProcesos();
        $resultados = $this->calcularPorcentajeCumplimiento();
        //dd($datosGrafica);
        // Obtener todos los años únicos que se utilizarán como etiquetas en el eje x 
         // Verificar si $datosGrafica es un array antes de procesarlo
         if (isset($datosGrafica['message'])) {
            // Manejar el caso en el que no hay datos para mostrar la gráfica
            // Puedes, por ejemplo, mostrar un mensaje de error o redirigir a otra página
            return view('usuarios.graficaCumplimiento');
        }
        $years = array_unique(array_merge(...array_map(function ($data) {
            return array_keys($data['porcentajes']);
        }, $datosGrafica)));

        // Ordenar los años de forma descendente (de mayor a menor)
        sort($years);

        // Asignar colores personalizados para cada proceso
        $coloresProcesos = [
            '#008077', //A
            '#6E736D', //B
            '#6A33A1', //C
            '#CC392F', //D
            '#C4456D', //E
            '#10873E', //F
            '#FF6315', //G
            '#DEA702', //H
            '#0F19D6', //I
            '#C900A8', //J

        ];

        return view('usuarios.graficaCumplimiento', compact('datosGrafica', 'years', 'coloresProcesos','resultados'));
    }

    public function mostrarGraficaDonas()
    {
       
    $resultados = $this->calcularPorcentajeCumplimiento();
      // Obtener todos los años únicos que se utilizarán como etiquetas en el eje x
    $years = array_unique(array_column($resultados, 'anio'));

    // Ordenar los años de forma descendente (de mayor a menor)
    rsort($years);
      
        return view('usuarios.graficasDona', compact( 'years','resultados'));
    }

    /**PDF gráficas lineal */
    public function guardarImagenLinea(Request $request)
    {
        $image = $request->input('image');

        // Ruta donde se guardarán las imágenes temporales
        $rutaTemporal = public_path('capturas_temporales');

        if (!file_exists($rutaTemporal)) {
            mkdir($rutaTemporal, 0777, true);
        }

        // Genera un nombre de archivo único con la extensión ".jpg"
        $nombreArchivo = 'captura_' . uniqid() . '.jpg';
        $rutaCompleta = $rutaTemporal . '/' . $nombreArchivo;

        // Elimina el encabezado de los datos base64
        $image = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $image);

        // Decodifica los datos base64 en una imagen
        $imagen = base64_decode($image);

        // Guarda la imagen en el servidor en formato JPEG
        if (file_put_contents($rutaCompleta, $imagen)) {
            return response()->json(['success' => true, 'nombreImagen' => $nombreArchivo]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function generateCumplimientoPDFLinea($nombreImagen)
    {
        $datosGrafica = $this->obtenerDatosGraficaCumplimientoTodosProcesos();

        // Ruta de la imagen capturada
        $rutaImagen = public_path('capturas_temporales/' . $nombreImagen);

        $viewData = [
            'datosGrafica' => $datosGrafica,
            'rutaImagen' => $rutaImagen, // Pasa la ruta de la imagen

        ];

        // Usar la opción "options" para configurar los estilos del PDF
        $pdf = PDF::loadView('usuarios.reporteGeneralProcesosLineal', $viewData, [
            'options' => [
                'page-size' => 'A4', // Tamaño de página A4
                'margin-top' => '20mm', // Margen superior
                'margin-bottom' => '20mm', // Margen inferior
            ],
        ]);

        return $pdf->download('cumplimiento_reporte_general.pdf');
    }

    public function eliminarImagenLinea(Request $request)
    {
        $nombreImagen = $request->input('nombreImagen');

        // Ruta completa de la imagen a eliminar
        $rutaImagen = public_path('capturas_temporales/' . $nombreImagen);

        // Verifica si la imagen existe y la elimína
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        return response()->json(['success' => true]);
    }

    /**PDF gráficas donas */

    public function guardarImagenes2(Request $request)
{
    $images = $request->input('images');

    $rutaTemporal = public_path('capturas_temporales');
    if (!file_exists($rutaTemporal)) {
        mkdir($rutaTemporal, 0777, true);
    }

    $nombresImagenes = [];

    foreach ($images as $index => $image) {
        // Obtén el identificador y el año asociado a la imagen
        $identificador = $request->input("identificador_$index");
        $anio = $request->input("anio_$index");

        // Construye el nombre del archivo con el identificador y el año
        $nombreArchivo = "captura_{$identificador}_{$anio}_{$index}.jpg";
        $rutaCompleta = $rutaTemporal . '/' . $nombreArchivo;

        $image = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $image);
        $imagen = base64_decode($image);

        if (file_put_contents($rutaCompleta, $imagen)) {
            $nombresImagenes[] = $nombreArchivo;
        }
    }

    return response()->json(['success' => true, 'nombresImagenes' => $nombresImagenes]);
}


public function generateCumplimientoPDF($nombresImagenes)
{
    $datosGrafica = $this->obtenerDatosGraficaCumplimientoTodosProcesos();
    $resultados = $this->calcularPorcentajeCumplimiento();


    // Ruta de las imágenes capturadas
    $rutasImagenes = [];
    $nombresImagenesArray = explode(',', $nombresImagenes);
    foreach ($nombresImagenesArray as $nombreImagen) {
        $rutasImagenes[] = public_path('capturas_temporales/' . $nombreImagen);
    }

    $viewData = [
        'datosGrafica' => $datosGrafica,
        'resultados'=>$resultados,
        'rutasImagenes' => $rutasImagenes, // Pasa las rutas de las imágenes
    ];

    $pdf = PDF::loadView('usuarios.reporteGeneralProcesos', $viewData, [
        'options' => [
            'page-size' => 'A4',
            'margin-top' => '20mm',
            'margin-bottom' => '20mm',
        ],
    ]);

    return $pdf->download('reporte_general.pdf');
}

public function eliminarImagenes2(Request $request)
{
    $rutaTemporal = public_path('capturas_temporales');

    // Elimina todas las imágenes en la carpeta temporal
    foreach (glob("$rutaTemporal/*") as $archivo) {
        unlink($archivo);
    }
 
    return response()->json(['success' => true]);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}