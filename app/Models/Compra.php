<?php

namespace App\Models;

class Compra extends Solicitud
{
    public function __construct() {
        parent::__construct();
        $this->setTipo("Compra");
    }

    public $timestamps = false;
}