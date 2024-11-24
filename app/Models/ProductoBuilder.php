<?php

namespace App\Models;

class ProductoBuilder
{
    // Atributos del producto que se construirá
    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $stock;
    protected $entradas = 0; // Directamente como suma
    protected $salidas = 0; // Directamente como suma
    protected $devoluciones = 0;
    protected $proveedorId; // Relación con el proveedor

    // Métodos para establecer cada atributo (fluidez en el builder)


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this; // Fluidez
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this; // Fluidez
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this; // Fluidez
    }

    public function setEntradas($entradas)
    {
        $this->entradas = $entradas;
        return $this; // Fluidez
    }

    public function setSalidas($salidas)
    {
        $this->salidas = $salidas;
        return $this; // Fluidez
    }

    public function setDevoluciones($devoluciones)
    {
        $this->devoluciones = $devoluciones;
        return $this; // Fluidez
    }

    public function setProveedorId($proveedorId)
    {
        $this->proveedorId = $proveedorId;
        return $this; // Fluidez
    }

    // Método para crear la instancia del Producto
    // Método para construir el modelo Producto
    public function build()
    {
        $producto = new Producto();
        $producto->id = $this->id;
        $producto->nombre = $this->nombre;
        $producto->descripcion = $this->descripcion;
        $producto->stock = $this->stock;
        $producto->entradas = $this->entradas;
        $producto->salidas = $this->salidas;
        $producto->devoluciones = $this->devoluciones;
        $producto->proveedor_id = $this->proveedorId;

        return $producto;
    }
}
