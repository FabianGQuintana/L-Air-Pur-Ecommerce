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
}
