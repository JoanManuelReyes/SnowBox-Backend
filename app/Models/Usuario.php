<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Tabla asociada al modelo
    protected $table = 'usuario';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_completo',
        'dni',
        'contrasenia',
        'telefono',
        'estado'
    ];

    // Relación con solicitud
    public function solicitud()
    {
        return $this->hasMany(Solicitud::class, 'usuario_id');
    }
}