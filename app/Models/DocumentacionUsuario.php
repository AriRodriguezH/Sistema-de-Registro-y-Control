<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentacionUsuario extends Model
{
    use HasFactory;
    protected $table = 'documentacion_usuario';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.
    protected $fillable = [
        'documentacion_id',
        'users_id',
    ];

    //Relación de pertenencia  entre el modelo 'documentacion_usuario' y el modelo 'documentacion'. 
    public function documentaciones()
    {
        return $this->belongsTo(Documentacion::class, 'documentacion_id');
    }

    //Relación de pertenencia  entre el modelo 'documentacion_usuario' y el modelo 'users'. 
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}