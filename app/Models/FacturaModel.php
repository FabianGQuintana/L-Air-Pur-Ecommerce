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
        'importe_total',
        'cantidad_productos',
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

    public function obtenerFacturasConUsuario()
    {
        return $this->select('facturas.*, usuarios.nombre, usuarios.apellido, usuarios.email')
                    ->join('usuarios', 'usuarios.id_usuario = facturas.id_usuario')
                    ->orderBy('facturas.fecha_hora', 'DESC')
                    ->findAll();
    }

    public function obtenerUltimaFactura(int $idUsuario): ?array
    {
        return $this->where('id_usuario', $idUsuario)
                    ->orderBy('id_factura', 'DESC')
                    ->first();
    }
}
