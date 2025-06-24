<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id_producto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_producto', 'id_categoria', 'nombre', 'descripcion',
     'precio', 'cantidad', 'id_marca', 'mililitros', 'imagen', 'activo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;

    /**
     * Filtra productos por marca y categoría.
     *
     * @param array $filtros ['marcas' => [], 'categorias' => [], 'precio_min' => 0, 'precio_max' => 9999]
     * @return array
     */
    public function filtrar(array $filtros = [], string $busqueda = '')
    {
        // JOIN para que vengan los datos de marcas y categorías
        $this->select('productos.*, marcas.nombre_marca AS marca, categorias.nombre AS categoria')
            ->join('marcas', 'marcas.id_marca = productos.id_marca')
            ->join('categorias', 'categorias.id_categoria = productos.id_categoria');

        // Filtro por marca
        if (!empty($filtros['marcas']) && is_array($filtros['marcas'])) {
            $this->whereIn('productos.id_marca', $filtros['marcas']);
        }

        // Filtro por categoría
        if (!empty($filtros['categorias']) && is_array($filtros['categorias'])) {
            $this->whereIn('productos.id_categoria', $filtros['categorias']);
        }

        // Filtro por estado activo (si está presente)
        if (isset($filtros['activo'])) {
            $this->where('productos.activo', $filtros['activo']);
        }

        // Filtro por búsqueda
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('productos.nombre', $busqueda)
                ->orLike('marcas.nombre_marca', $busqueda)
                ->orLike('categorias.nombre', $busqueda)
                ->groupEnd();
        }

        return $this->findAll();
    }

    /**
     * Obtiene un producto por su ID y los detalles de la marca y categoría.
     *
     * @param int $id El ID del producto.
     * @return array|null El producto con detalles de marca y categoría, o null si no se encuentra.
     */
    public function obtenerProductoConDetalles($id)
    {
        return $this->select('productos.*, marcas.nombre_marca AS marca, categorias.nombre AS categoria')
                    ->join('marcas', 'marcas.id_marca = productos.id_marca')
                    ->join('categorias', 'categorias.id_categoria = productos.id_categoria')
                    ->where('productos.id_producto', $id)
                    ->first();
    }

    /**
     * Obtiene un producto por su ID y los detalles de la marca y categoría.
     *
     * @param int $id El ID del producto.
     * @return array|null El producto con detalles de marca y categoría, o null si no se encuentra.
     */
    public function obtenerPorCategoriaActivos(int $idCategoria, int $limite = 4)
    {
        return $this->where('id_categoria', $idCategoria)
                    ->where('activo', 1)
                    ->limit($limite)
                    ->find();
    }
}


