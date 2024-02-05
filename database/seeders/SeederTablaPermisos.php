<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Con esto se va a llenar la tabla de permisos
        $permisos = [
            //tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            //tabla usuarios
             'ver-usuarios',
             'crear-usuarios',
             'editar-usuarios',
             'borrar-usuarios',

             //tablas Procesos
             'ver-procesos',
             'calificar-procesos',
             'crear-procesos',
             'editar-procesos',
             'borrar-procesos',
        ];

        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
