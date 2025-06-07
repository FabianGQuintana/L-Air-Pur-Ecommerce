<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'id_factura';

    protected $allowedFields = [
        'id_factura',
        'id_usuario',
        'medio_pago',
        'importe_total',
        'descuento',
        'fecha_hora'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;
}
