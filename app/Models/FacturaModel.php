<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';

    protected $allowedFields = ['id_usuario', 'fecha', 'total'];
    protected $useTimestamps = false;
}
