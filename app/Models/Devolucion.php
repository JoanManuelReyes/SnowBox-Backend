<?php

namespace App\Models;

class Devolucion extends Solicitud
{
    public function __construct() {
        parent::__construct();
        $this->setTipo("Devolución");
    }

    public $timestamps = false;
}