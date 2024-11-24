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
    public function calcularEntradas()
    {
        return $this->registros()
            ->where('tipo', 'Entrada')
            ->sum('cantidad');
    }

    public function calcularSalidas()
    {
        return $this->registros()
            ->where('tipo', 'Salida')
            ->sum('cantidad');
    }

    // Relación con registros
    public function solicitud()
    {
        return $this->hasMany(Solicitud::class, 'producto_id');
    }

    public function calcularDevoluciones()
    {
        return $this->solicitud()
            ->where('tipo', 'Devolucion')
            ->sum('cantidad');
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
