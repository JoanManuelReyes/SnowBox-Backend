<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $id;
    protected $nombre;
    protected $ruc;
    protected $telefono;
    protected $correo;

    // Tabla asociada al modelo
    protected $table = 'proveedor';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'ruc',
        'telefono',
        'correo'
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    
    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

}