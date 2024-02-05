<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Definición de los datos a insertar en los arreglos
        $identificadores = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
        ];

        $nombreProcesos = [
            'Objetivos, requerimientos y estrategias.',
            'Identificación de los procesos y activos esenciales de la CONDUSEF',
            'Análisis de Riesgos',
            'Implementación de los controles mínimos de Seguridad de la Información',
            'Programa de gestión de vulnerabilidades',
            'Protocolo de respuesta ante incidentes de Seguridad de la Información',
            'Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres',
            'Supervisión y evaluación',
            'Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información',
            'Programa de implementación del MGSI',
        ];

        /**Bucle for para recorrer los datos y ejecutar las consultas
         *  Utiliza la función now para obtener la fecha y hora actual */
        for ($i = 0; $i < count($identificadores); $i++) {
            DB::table('proceso')->insert([
                'identificador' => $identificadores[$i],
                'nombreProceso' => $nombreProcesos[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
