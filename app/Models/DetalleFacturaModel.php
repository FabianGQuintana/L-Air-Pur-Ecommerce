<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleFacturaModel extends Model
{
    protected $table      = 'detalle_facturas';
    protected $primaryKey = 'id_detalle_factura';

    protected $allowedFields = ['id_factura', 'id_producto', 'cantidad', 'precio_unitario'];

    public function obtenerDetallesConProducto($idFactura)
    {
        return $this->select('
                    detalle_facturas.*,
                    productos.nombre AS nombre_producto,
                    productos.imagen,
                    categorias.nombre AS categoria,
                    marcas.nombre AS marca
                ')
                ->join('productos', 'productos.id_producto = detalle_facturas.id_producto')
                ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left')
                ->join('marcas', 'marcas.id_marca = productos.id_marca', 'left')
                ->where('detalle_facturas.id_factura', $idFactura)
                ->findAll();
    }
}
