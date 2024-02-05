<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentacionPublicacion extends Model
{
    use HasFactory;
    protected $table = 'documentacion_publicacion';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.

    //Relación de pertenencia entre el modelo 'documentacion_publicacion' y el modelo 'documentacion'.
    public function documentaciones()
    {
        return $this->belongsTo(Documentacion::class, 'documentacion_id');
    }

    //Relación de pertenencia (belongsTo) entre la tabla 'documentacion_publicacion' y la tabla 'publicacion'.
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}