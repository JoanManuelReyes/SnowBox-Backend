<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{    
    protected $id;
    protected $fecha;
    protected $tipo;
    protected $cantidad;
    protected Producto $producto;

    // Tabla asociada al modelo
    protected $table = 'registro';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'fecha',
        'cantidad',
        'tipo',
        'producto_id'
    ];

    public $timestamps = false;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto)
    {
        $this->producto = $producto;
    }
}