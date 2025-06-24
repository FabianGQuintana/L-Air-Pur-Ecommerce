<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultasModel extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';

    protected $allowedFields = [
        'id_usuario',
        'fecha_hora',
        'asunto',
        'mensaje',
        'estado',
    ];

    protected $useTimestamps = false;

    public function obtenerConUsuarios()
    {
        return $this->select('consultas.*, usuarios.nombre AS nombre_usuario, usuarios.email AS email_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario')
                    ->orderBy('consultas.fecha_hora', 'DESC')
                    ->findAll();
    }
}
