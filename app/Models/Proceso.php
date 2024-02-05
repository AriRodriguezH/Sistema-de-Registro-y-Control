<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documentacion;
use App\Models\Publicacion;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'proceso';//Especificación del nombre de la tabla en la base de datos que está asociada al modelo.

    protected $fillable = [
        'identificador',
        'nombreProceso',
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

}