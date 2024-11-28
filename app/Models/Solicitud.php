<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $id;
    protected EquipoLogistica $equipologistica;
    protected Producto $producto;
    protected $tipo;
    protected $descripcion;
    protected $cantidad;
    protected $fecha;
    protected $estado;


    
    // Tabla asociada al modelo
    protected $table = 'solicitud';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'producto_id',
        'tipo',
        'descripcion',
        'cantidad',
        'fecha',
        'estado'
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

    public function getEquipoLogistica()
    {
        return $this->equipologistica;
    }

    public function setEquipoLogistica(EquipoLogistica $equipologistica)
    {
        $this->equipologistica = $equipologistica;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}