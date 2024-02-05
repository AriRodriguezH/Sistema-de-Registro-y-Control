<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\Documentacion;
use App\Models\Publicacion;
use App\Models\DocumentacionPublicacion;
use App\Models\DocumentacionUsuario;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Método para obtener los datos necesarios para la gráfica de porcentaje de cumplimiento.
     */
    public function obtenerDatosGraficaCumplimientoTodosProcesos()
    {
        $procesos = Proceso::all();

        $datosGrafica = [];

        foreach ($procesos as $proceso) {
            $publicaciones = $proceso->publicaciones()->with('documentacion.calificaciones')->get();

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
                    'porcentajeTotal' => round($porcentajeTotal, 2),
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

                $porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] = $porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] > 0 ? round($porcentajesPorAnio[$publicacion->anioRegistro]['semestre1'] / $calificacionesTotales, 2) : 0;
                $porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] = $porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] > 0 ? round($porcentajesPorAnio[$publicacion->anioRegistro]['semestre2'] / $calificacionesTotales, 2) : 0;
            }

            // Calcular porcentaje de cada semestre por año para el identificador específico
                $calificacionesCompletasIdentificador = 0;
                $calificacionesTotalesIdentificador = 0;

                foreach ($porcentajesPorAnio as $porcentajePorAnio) {
                    $calificacionesCompletasIdentificador += $porcentajePorAnio['semestre1'] + $porcentajePorAnio['semestre2'];
                    $calificacionesTotalesIdentificador += 2; // Considerando que hay dos semestres por año
                }

            $porcentajeIdentificador = $calificacionesTotalesIdentificador > 0 ? round($calificacionesCompletasIdentificador / $calificacionesTotalesIdentificador, 2) : 0;

            $datosGrafica[] = [
                'identificador' => $proceso->identificador,
                'porcentajes' => $porcentajesPorAnio,
                'porcentajeIdentificador' => $porcentajeIdentificador,
            ];
        }

        return $datosGrafica;
    }

  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Obtención de los datos de la gráfica
        $datosGrafica = $this->obtenerDatosGraficaCumplimientoTodosProcesos();
        //dd($resultados);
        // Obtener todos los años únicos que se utilizarán como etiquetas en el eje x 
        $years = array_unique(array_merge(...array_map(function ($data) {
            return array_keys($data['porcentajes']);
        }, $datosGrafica)));

        // Ordenar los años de forma descendente (de mayor a menor)
        sort($years);

        // Asignar colores personalizados para cada proceso
        $coloresProcesos = [
            '#008077',
            '#6E736D',
            '#6A33A1',
            '#CC392F',
            '#C4456D',
            '#10873E',
            '#FF6315',
            '#E6AD02',
            '#0F19D6',
            '#C900A8',

        ];

        return view('home', compact('datosGrafica', 'years', 'coloresProcesos'));
    }

}