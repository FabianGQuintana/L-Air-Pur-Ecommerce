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
        // Agrego los JOIN para que vengan los datos de marcas y categorías
        $this->select('productos.*, marcas.nombre_marca AS marca, categorias.nombre AS categoria')
            ->join('marcas', 'marcas.id_marca = productos.id_marca')
            ->join('categorias', 'categorias.id_categoria = productos.id_categoria');

        // Aplico los filtros si están presentes
        if (!empty($filtros['marcas']) && is_array($filtros['marcas'])) {
            $this->whereIn('productos.id_marca', $filtros['marcas']);
        }

        if (!empty($filtros['categorias']) && is_array($filtros['categorias'])) {
            $this->whereIn('productos.id_categoria', $filtros['categorias']);
        }

        // Aplico la búsqueda si está presente
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('productos.nombre', $busqueda)
                ->orLike('marcas.nombre_marca', $busqueda)
                ->orLike('categorias.nombre', $busqueda)
                ->groupEnd();
        }

        return $this->findAll();
    }


    public function obtenerProductoConDetalles($id)
    {
        return $this->select('productos.*, marcas.nombre_marca AS marca, categorias.nombre AS categoria')
                    ->join('marcas', 'marcas.id_marca = productos.id_marca')
                    ->join('categorias', 'categorias.id_categoria = productos.id_categoria')
                    ->where('productos.id_producto', $id)
                    ->first();
    }

    //Limitadores de productos en cards por secciones
    public function obtenerDestacados(){

    return $this->where('categoria', 'Diseñador')
                ->limit(4)
                ->findAll();
    }

    public function obtenerExclusivos(){

        return $this->where('categoria','Nicho')
                    ->limit(4)
                    ->findAll();

    }

        public function obtenerArabes(){

        return $this->where('categoria','Arabes')
                    ->limit(4)
                    ->findAll();

    }
}


