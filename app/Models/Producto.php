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
    protected $entradas = [];
    protected $salidas = [];
    protected $devoluciones = [];
    protected $proveedor;

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

    // Constructor gestionado por Eloquent

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
    
    // Relación con registros
    public function registros()
    {
        return $this->hasMany(Registro::class, 'producto_id');
    }

    // Métodos para calcular las entradas y salidas
    public function calcularEntradas($datos)
    {
        $agrupados = [];
        foreach ($datos as $registro) {
            if (!isset($agrupados[$registro->id])) {
                $agrupados[$registro->id] = (object)[
                    'id' => $registro->id,
                    'nombre' => $registro->nombre,
                    'descripcion' => $registro->descripcion,
                    'stock' => $registro->stock,
                    'proveedor_id' => $registro->proveedor_id,
                    'proveedor_nombre' => $registro->proveedor_nombre,
                    'entradas' => 0, // Inicializar el campo para sumar
                ];
            }
            $agrupados[$registro->id]->entradas += $registro->cantidad;
        }
        return array_values($agrupados);
    }

    public function calcularSalidas($datos)
    {
        $agrupados = [];
        foreach ($datos as $registro) {
            if (!isset($agrupados[$registro->id])) {
                $agrupados[$registro->id] = (object)[
                    'id' => $registro->id,
                    'nombre' => $registro->nombre,
                    'descripcion' => $registro->descripcion,
                    'stock' => $registro->stock,
                    'proveedor_id' => $registro->proveedor_id,
                    'proveedor_nombre' => $registro->proveedor_nombre,
                    'salidas' => 0, // Inicializar el campo para sumar
                ];
            }
            $agrupados[$registro->id]->salidas += $registro->cantidad;
        }
        return array_values($agrupados);
    }

    // Relación con registros
    public function solicitud()
    {
        return $this->hasMany(Solicitud::class, 'producto_id');
    }

    public function calcularDevoluciones($datos)
    {
        $agrupados = [];
        foreach ($datos as $registro) {
            if (!isset($agrupados[$registro->id])) {
                $agrupados[$registro->id] = (object)[
                    'id' => $registro->id,
                    'nombre' => $registro->nombre,
                    'descripcion' => $registro->descripcion,
                    'stock' => $registro->stock,
                    'proveedor_id' => $registro->proveedor_id,
                    'proveedor_nombre' => $registro->proveedor_nombre,
                    'devoluciones' => 0, // Inicializar el campo para sumar
                ];
            }
            $agrupados[$registro->id]->devoluciones += $registro->cantidad;
        }
        return array_values($agrupados);
    }

    // Método toString para mostrar el objeto Producto
    public function toString()
    {
        return "Producto: {$this->nombre} - {$this->descripcion}, Categoría: {$this->categoria}, Subcategoría: {$this->subcategoria}, Stock: {$this->stock}";
    }

    // Builder estático para construir el objeto
    public static function builder()
    {
        return new ProductoBuilder();
    }

}
