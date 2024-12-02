<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Definir los atributos protegidos
    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $stock;
    protected Proveedor $proveedor;
    protected Entrada $entradas;
    protected Salida $salidas;
    protected Devolucion $devolucion;

    // Definir los campos que pueden ser asignados masivamente
    protected $table = 'producto';
    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'subcategoria',
        'stock',
        'proveedor_id',
    ];

    public $timestamps = false;

     // Métodos Getters y Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }
    
    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function setProveedor(Proveedor $proveedor)
    {
        $this->proveedor = $proveedor;
    }
    
    public function getEntradas()
    {
        return $this->entradas;
    }

    public function setEntradas(Entrada $entradas)
    {
        $this->entradas = $entradas;
    }

    public function getSalidas()
    {
        return $this->salidas;
    }

    public function setSalidas(Salida $salidas)
    {
        $this->salidas = $salidas;
    }
    
    public function getDevoluciones()
    {
        return $this->devoluciones;
    }

    public function setDevoluciones(Devolucion $devoluciones)
    {
        $this->devoluciones = $devoluciones;
    }
    
    // Métodos para calcular las entradas y salidas
    public function calcularEntradas($datos)
    {
        $resultado = [];

        foreach ($datos as $entrada) {
            $productoId = $entrada['producto_id'];

            if (!isset($resultado[$productoId])) {
                $resultado[$productoId] = [
                    'cantidad' => 0,
                    'tipo' => $entrada['tipo'],
                    'producto_id' => $productoId
                ];
            }

            $resultado[$productoId]['cantidad'] += $entrada['cantidad'];
        }

        return array_values($resultado);
    }

    public function calcularSalidas($datos)
    {
        $resultado = [];

        foreach ($datos as $salida) {
            $productoId = $salida['producto_id'];

            if (!isset($resultado[$productoId])) {
                $resultado[$productoId] = [
                    'cantidad' => 0,
                    'tipo' => $salida['tipo'],
                    'producto_id' => $productoId
                ];
            }

            $resultado[$productoId]['cantidad'] += $salida['cantidad'];
        }

        return array_values($resultado);
    }

    public function calcularDevoluciones($datos)
    {
        $resultado = [];

        foreach ($datos as $devolucion) {
            $productoId = $devolucion['producto_id'];

            if (!isset($resultado[$productoId])) {
                $resultado[$productoId] = [
                    'cantidad' => 0,
                    'tipo' => $devolucion['tipo'],
                    'producto_id' => $productoId
                ];
            }

            $resultado[$productoId]['cantidad'] += $devolucion['cantidad'];
        }

        return array_values($resultado);
    }

    // Builder estático para construir el objeto
    public static function builder()
    {
        return new Builder();
    }

}
