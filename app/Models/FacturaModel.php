<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';

    protected $allowedFields = [
        'id_factura',
        'id_usuario',
        'medio_pago',
        'importe_total',
        'descuento',
        'fecha_hora'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function obtenerVentasPorMes()
    {
        return $this->select("MONTH(fecha_hora) as mes, COUNT(*) as cantidad")
                    ->groupBy("mes")
                    ->orderBy("mes", "ASC")
                    ->findAll();
    }

}
