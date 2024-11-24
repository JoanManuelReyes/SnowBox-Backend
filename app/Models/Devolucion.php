<?php

namespace App\Models;

class Devolucion extends Solicitud
{
    // Definir el tipo por defecto
    protected $attributes = [
        'tipo' => 'Devolución',
    ];
}