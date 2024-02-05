<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documentacion;
use App\Models\User;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'respuesta';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.
    protected $primaryKey = 'id';//Especifica el nombre de la columna que sirve como clave primaria en la tabla.


    protected $fillable = [
        'documentacion_id', 
        'users_id', 
        'archivo_path'];

    //Relación de pertenencia entre el modelo 'respuesta' y el modelo 'documentacion'.
    public function documentacion()
    {
        return $this->belongsTo(Documentacion::class, 'documentacion_id');
    }

    //Relación de pertenencia entre el modelo 'respuesta' y el modelo 'users'.
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    //Relación entre el modelo 'respuesta' y el modelo 'calificacion.
    public function calificacion()
    {
        return $this->hasOne(Calificacion::class, 'respuesta_id');
    }
}