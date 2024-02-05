<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Respuesta;
use App\Models\User;

class Calificacion extends Model
{
    use HasFactory;
    protected $table = 'calificacion';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.
    protected $primaryKey = 'id';//Especifica el nombre de la columna que sirve como clave primaria en la tabla.

    protected $fillable = [
        'comentario',
        'cumplimiento',
        'porcentajeCumplimiento',
        'estadoDocumentacion',
        'respuesta_id',
        'users_id',
    ];

    //Definición de la relación entre el modelo calificación y respuesta.
    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuesta_id');
    }

    //Definición de la relación entre el modelo calificación y usuario.
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}