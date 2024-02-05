<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

class RolController extends Controller
{

    function __construct()
    {
        //Aqui se configuran los permisos que se van a usar
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only' => ['index']]);
        //store será para almacenar los datos
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Hacemos referencia al modelo de roles y vamos a usar paginate para integrar la paginación
        $roles = Role::paginate();

        $returnUrl = $request->query('return_url');
        //Hacemos que nos devulva una vista que se encuentra en la carpeta roles.index
        return view('roles.index', compact('roles','returnUrl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permission = Permission::get();
        return view('roles.crear', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Campos que vamos a validar name, etc
        $this->validate($request, [
            'name' => 'required|min:3|max:150|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u', 
            'permission' => 'required'],
            [

            'name.required' => 'El campo Nombre del Rol es obligatorio.',
            'name.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El campo Nombre no puede exceder los 150 caracteres.',
            'name.regex' => 'Los caracteres especiales y numéricos no son válidos.',
            
            'permission.required' => 'Los permisos son requeridos'
            ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
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
        //
        $role = Role::find($id);
        $permission = Permission::get();
        // Referencia a "role_has_permissions" que se encuentra en la base de datos
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

            // Genera el breadcrumb de edición de roles
        Breadcrumbs::for('editarRol', function ($trail) use ($role) {
            $trail->parent('roles'); // Asegúrate de que 'roles' coincida con el nombre de la ruta para la lista de roles
            $trail->push('Editar Rol', route('roles.edit', $role->id)); // 'roles.edit' es el nombre de la ruta para editar roles
        });

        return view('roles.editar', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $this->validate($request, [
            'name' => 'required|min:3|max:150|regex:/^[A-Za-zÑñÁÉÍÓÚáéíóú]+$/u', 
            'permission' => 'required'
        ],
    [
        'name.required' => 'El campo Nombre del Rol es obligatorio.',
        'name.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
        'name.max' => 'El campo Nombre no puede exceder los 150 caracteres.',
        'name.regex' => 'Los caracteres especiales y numéricos no son válidos.',
        
        'permission.required' => 'Los permisos son requeridos'
    ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Lógica para eliminar el rol
            $role = Role::findOrFail($id);
            $role->delete();
    
            // Respuesta en caso de éxito
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            // Respuesta en caso de error
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar el rol: ' . $e->getMessage()]);
        }
    }
} 
