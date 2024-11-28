<?php

namespace App\Models;

class Salida extends Registro
{
    public function __construct() {
        parent::__construct();
        $this->setTipo("Salida");
    }
}