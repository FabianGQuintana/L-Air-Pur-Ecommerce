<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleFacturaModel extends Model
{
    protected $table = 'detalle_facturas';
    protected $primaryKey = 'id_detalle_factura';

    protected $allowedFields = [
        'id_detalle_factura',
        'id_factura',
        'id_producto',
        'cantidad',
        'subtotal'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function obtenerDetallesConProducto($idFactura)
    {
        return $this->select('
                detalle_facturas.*,
                productos.nombre AS nombre_producto,
                productos.precio,
                productos.imagen,
                marcas.nombre_marca AS marca,
                categorias.nombre AS categoria
            ')
            ->join('productos', 'productos.id_producto = detalle_facturas.id_producto')
            ->join('marcas', 'marcas.id_marca = productos.id_marca')
            ->join('categorias', 'categorias.id_categoria = productos.id_categoria')
            ->where('detalle_facturas.id_factura', $idFactura)
            ->findAll();
    }

    public function obtenerDetallesConProductos(int $idFactura): array
    {
        $detalles = $this->select('detalle_facturas.cantidad, detalle_facturas.subtotal, productos.nombre AS nombre_producto, productos.precio AS precio_unitario')
                        ->join('productos', 'productos.id_producto = detalle_facturas.id_producto')
                        ->where('detalle_facturas.id_factura', $idFactura)
                        ->findAll();

        return $detalles ?: [];
    }
}
