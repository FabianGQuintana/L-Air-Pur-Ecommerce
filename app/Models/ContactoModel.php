<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table = 'contacto';
    protected $primaryKey = 'id_contacto';

    protected $allowedFields = [
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'fecha_hora',
        'estado',
    ];

    protected $useTimestamps = false;

    public function obtenerTodosOrdenados()
    {
        return $this->orderBy('fecha_hora', 'DESC')->findAll();
    }
}
