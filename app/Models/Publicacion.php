<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Documentacion;
use App\Models\User;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicacion';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.

    protected $fillable = [
        'anioRegistro',
        'users_id',
        'proceso_id',
    ];

    /**relación documentaciones en el modelo de publicaciones para obtener
     *  las documentaciones asociadas a una publicación */

     //Relación de muchos a muchos entre la tabla 'publicacion' y la tabla 'documentacion', se especifica el nombre de la tabla pivot 'documentacion_publicacion' y los nombres de las claves foraneas en ambas tablas.
     public function documentacion()
     {
         return $this->belongsToMany(Documentacion::class, 'documentacion_publicacion', 'publicacion_id', 'documentacion_id');
     }

    public function documentaciones()
    {
        return $this->hasMany(Documentacion::class);
    }

    //Relación entre la tabla 'publicacion' y la tabla 'respuestas' a través de la tabla 'documentacion'.
    public function respuestas()
    {
        return $this->hasManyThrough(Respuesta::class, Documentacion::class);
    }

    //Relación de pertenencia entre la tabla 'publicacion' y la tabla 'users'.
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }
}