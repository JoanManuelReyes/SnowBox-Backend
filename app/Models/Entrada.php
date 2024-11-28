<?php

namespace App\Models;

class Entrada extends Registro
{
    public function __construct() {
        parent::__construct();
        $this->setTipo("Entrada");
    }
}