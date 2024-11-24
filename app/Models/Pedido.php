<?php

namespace App\Models;

class Pedido extends Solicitud
{
    // Definir el tipo por defecto
    protected $attributes = [
        'tipo' => 'Pedido',
    ];
}