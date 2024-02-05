<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Respuesta;
use App\Models\Calificacion;
use App\Models\Publicacion;

class Documentacion extends Model
{
    use HasFactory;

    /**Definición de la tabla y su clave primaria */
    protected $table = 'documentacion';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.
    protected $primaryKey = 'id';//Especifica el nombre de la columna que sirve como clave primaria en la tabla.

    protected $fillable = [
        'semestre',
        'descripcion',
        'archivo_path',
        'users_id',
    ];

    //Relación entre la tabla documentación y la tabla respuesta.
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    //Relación entre la tabla 'documentacion' y la tabla 'calificaciones' a través de la tabla 'respuestas'.
    public function calificaciones()
    {
        return $this->hasManyThrough(Calificacion::class, Respuesta::class, 'documentacion_id', 'respuesta_id');
    }

    //Relación de la tabla 'documentacion' y la tabla 'publicaciones', se especifica el nombre de la tabla pivot 'documentacion_publicacion' y los nombres de las claves foraneas en ambas tablas.
    public function publicaciones()
    {
        return $this->belongsToMany(Publicacion::class, 'documentacion_publicacion', 'documentacion_id', 'publicacion_id');
    }


    //Relación de la tabla 'documentacion' y la tabla 'users', se especifica el nombre de la tabla pivot 'documentacion_usuario' y los nombres de las claves foraneas en ambas tablas.
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'documentacion_usuario', 'documentacion_id', 'users_id');
    }
}