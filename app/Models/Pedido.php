<?php

namespace App\Models;

class Pedido extends Solicitud
{
    public function __construct() {
        parent::__construct();
        $this->setTipo("Pedido");
    }
}