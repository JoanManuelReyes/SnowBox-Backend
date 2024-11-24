<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    // Tabla asociada al modelo
    protected $table = 'solicitud';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'producto_id',
        'tipo',
        'descripcion',
        'cantidad',
        'fecha',
        'estado'
    ];

    // Relación con el modelo Producto (muchos registros pertenecen a un producto)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con el modelo Producto (muchos registros pertenecen a un producto)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        // Convertir a objeto si no lo es
        if (is_array($attributes)) {
            $attributes = (object) $attributes;
        }

        $instance = parent::newFromBuilder($attributes, $connection);

        if (isset($attributes->tipo)) {
            $class = 'App\\Models\\' . ucfirst($attributes->tipo);
            if (class_exists($class)) {
                $instance = (new $class)->newInstance([], true);
                $instance->setRawAttributes((array) $attributes, true);
            }
        }

        return $instance;
    }
}