<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creación del Usuario SuperAdmin
        $usuario= User::create([
            'nombre'=>'Ariadna',
            'apellidoP'=>'Rodríguez',
            'apellidoM'=>'Hernández',
            'nombreUsuario'=>'AriadnaRH',
            'estado'=>false,
            'intentoSesion'=>'0',
            'email'=>'admins@gmail.com',
            'password'=>bcrypt('Michis0308?')
        ]);

        $usuario2= User::create([
            'nombre'=>'Jorge',
            'apellidoP'=>'Mendez',
            'apellidoM'=>'Hernández',
            'nombreUsuario'=>'JorgeRH',
            'estado'=>false,
            'intentoSesion'=>'0',
            'email'=>'jorge@gmail.com',
            'password'=>bcrypt('Michis0308?')
        ]);

        $usuario3= User::create([
            'nombre'=>'Milian',
            'apellidoP'=>'Rodríguez',
            'apellidoM'=>'Rodríguez',
            'nombreUsuario'=>'MilianRR',
            'estado'=>false,
            'intentoSesion'=>'0',
            'email'=>'Milian@gmail.com',
            'password'=>bcrypt('Michis0308?')
        ]);


        // Asignación del rol "Administrador" al usuario en caso de que no se haya creado algun rol
        $rolAdmin = Role::create(['name' => 'Administrador']);
        $permisosAdmin = Permission::pluck('id', 'id')->all();
        $rolAdmin->syncPermissions($permisosAdmin);

        // Asignación del rol "usuario general" al usuario
        $rolUsuarioGeneral = Role::create(['name' => 'Usuario General']);
        $permisosUsuarioGeneral = Permission::whereIn('name', ['ver-procesos'])->pluck('id');
        $rolUsuarioGeneral->syncPermissions($permisosUsuarioGeneral);

        $usuario->assignRole([$rolAdmin]);
        $usuario2->assignRole([$rolUsuarioGeneral]);
        $usuario3->assignRole([$rolUsuarioGeneral]);

        /**Si ya se tiene un Rol hecho previamente sería 
         * 
         * $usuario->assignRole('Administrador');
         * 
        */
    }
}
