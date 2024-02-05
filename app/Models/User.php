<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Documentacion;
use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidoP',
        'apellidoM',
        'nombreUsuario',
        'estado',
        'intentoSesion',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**Relación documentaciones en el modelo de usuario (User) para obtener 
     * las documentaciones asociadas a un usuario */

     //Relación entre el modelo Usuario y el modelo Publicacion.
     public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'users_id');
    }
    
    /**Relación entre el modelo Usuario y el modelo DocumentacionUsuario, 'users_id' especifica la clave foránea en la tabla 'documentacion_usuario' 
     * que se usa para relacionar los registros con el usuario correspondiente.*/
    public function documentacion()
    {
        return $this->hasMany(DocumentacionUsuario::class, 'users_id');
    }

    //Relación entre el modelo Usuario y el modelo Documentacion y especificación de el nombre de la tabla intermedia y las claves foráneas utilizadas para la relación.
    public function documentaciones()
    {
        return $this->belongsToMany(Documentacion::class, 'documentacion_usuario', 'users_id', 'documentacion_id');
    }

    //Rleación entre el modelo User y el modelo Respuesta
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

}
