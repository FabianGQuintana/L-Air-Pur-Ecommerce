<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MarcasModel;
use App\Models\CategoriasModel;
use App\Models\ProductosModel;

class AdminController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Administrador';
        $data['content'] = view('Pages/PrincipalAdm');
        return view('Templates/admin_layout', $data);
    }

    public function administrarProductos()
    {
        $categoriasModel = new CategoriasModel();
        $data['categorias'] = $categoriasModel->findAll();

        $marcasModel = new MarcasModel();
        $data['marcas'] = $marcasModel->findAll();

        $productosModel = new ProductosModel();

        // Tomar filtros desde GET
        $filtros = [
            'marcas'     => $this->request->getGet('marcas') ?? [],
            'categorias' => $this->request->getGet('categorias') ?? [],
        ];

        // Tomar término de búsqueda
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $data['busqueda'] = $busqueda;

        // Obtener productos filtrados y con búsqueda
        $productos = $productosModel->filtrar($filtros, $busqueda);

        $data['productos'] = $productos;
        $data['filtros'] = $filtros;
        $data['title'] = 'Adm Productos';
        $data['content'] = view('Pages/AdminProductos', $data);

        return view('Templates/admin_layout', $data);
    }

    
}