<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    // Tabla asociada al modelo
    protected $table = 'registro';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'fecha',
        'cantidad',
        'tipo',
        'producto_id'
    ];

    public $timestamps = false;

    // Relación con el modelo Producto (muchos registros pertenecen a un producto)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}