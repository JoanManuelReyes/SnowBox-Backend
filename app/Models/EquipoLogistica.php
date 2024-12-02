<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipoLogistica extends Model
{
    protected $id;
    protected $nombre_completo;
    protected $dni;
    protected $contrasenia;
    protected $telefono;
    protected $estado;
    // Tabla asociada al modelo
    protected $table = 'equipologistica';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_completo',
        'dni',
        'contrasenia',
        'telefono',
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

    public function getNombre_Completo()
    {
        return $this->nombre_completo;
    }

    public function setNombre_Completo($nombre_completo)
    {
        $this->nombre_completo = $nombre_completo;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
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