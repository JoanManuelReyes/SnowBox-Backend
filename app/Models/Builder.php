<?php

namespace App\Models;

class Builder
{
    protected Producto $producto;
        
    public function __construct(){
        $this->producto = new Producto();
    }

    public function id($id) {
        $this->producto->id = $id;
        return $this;
    }

    public function nombre($nombre) {
        $this->producto->nombre = $nombre;
        return $this;
    }
    
    public function descripcion($descripcion) {
        $this->producto->descripcion = $descripcion;
        return $this;
    }

    public function stock($stock) {
        $this->producto->stock = $stock;
        return $this;
    }

    public function proveedor_id($proveedor_id) {
        $this->producto->proveedor_id = $proveedor_id;
        return $this;
    }

    public function entradas($entradas) {
        $this->producto->entradas = $entradas;
        return $this;
    }

    public function salidas($salidas) {
        $this->producto->salidas = $salidas;
        return $this;
    }

    public function devoluciones($devoluciones) {
        $this->producto->devoluciones = $devoluciones;
        return $this;
    }

    public function build() {
        return $this->producto;
    }
}
