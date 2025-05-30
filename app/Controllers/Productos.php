<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MarcasModel;
use App\Models\CategoriasModel;
use App\Models\ProductosModel;

class Productos extends BaseController
{
    protected $helpers = ['form'];

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
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

        $productos = $productosModel->filtrar($filtros);

        $data['productos'] = $productos;
        $data['filtros'] = $filtros; // para que la vista sepa qué checkboxes marcar
        $data['title'] = 'Productos - L’Air Pur';
        $data['content'] = view('Pages/Catalogo', $data);

        return view('Templates/main_layout', $data);
    }


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $modelo = new ProductosModel();
        $producto = $modelo->obtenerProductoConDetalles($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Producto no encontrado");
        }
        
        $data['producto'] = $producto;
        $data['title'] = 'Producto - L’Air Pur';
        $data['content'] = view('Pages/DetalleProducto', $data);

        return view('Templates/main_layout', $data);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        $marcasModel = new MarcasModel();
        $data['marcas'] = $marcasModel->findAll();
        $categoriasModel = new CategoriasModel();
        $data['categorias'] = $categoriasModel->findAll();

        $data['title'] = 'Nuevo producto - L’Air Pur';
        $data['content'] = view('Components/Form_Producto', $data);

        return view('Templates/admin_layout', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $reglas = [
            'nombre' => 'required|min_length[3]',
            'categoria' => 'required|is_not_unique[categorias.id_categoria]',
            'descripcion' => 'required|min_length[15]',
            'precio' => 'required|decimal',
            'cantidad' => 'required|integer',
            'mililitros' => 'required|integer',
            'marca' => 'required|is_not_unique[marcas.id_marca]',
            'imagen' => ['rules' => 'uploaded[imagen]|is_image[imagen]|max_size[imagen,2048]'],
        ];

        $mensajes = [
            'nombre' => [
                'required' => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            ],
            'categoria' => [
                'required' => 'La categoría es obligatoria.',
                'is_not_unique' => 'La categoría seleccionada no es válida.',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 15 caracteres.',
            ],
            'precio' => [
                'required' => 'El precio es obligatorio.',
                'decimal' => 'El precio debe ser un número decimal válido.',
            ],
            'cantidad' => [
                'required' => 'La cantidad es obligatoria.',
                'integer' => 'La cantidad debe ser un número entero.',
            ],
            'mililitros' => [
                'required' => 'Los mililitros son obligatorios.',
                'integer' => 'Los mililitros deben ser un número entero.',
            ],
            'marca' => [
                'required' => 'La marca es obligatoria.',
                'is_not_unique' => 'La marca seleccionada no es válida.',
            ],
            'imagen' => [
                'uploaded' => 'La imagen es obligatoria.',
                'is_image' => 'El archivo debe ser una imagen válida.',
                'max_size' => 'La imagen no debe superar los 2MB.',
            ],
        ];

        if (!$this->validate($reglas,$mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $this->request->getPost([
            'nombre',
            'categoria',
            'descripcion',
            'precio',
            'cantidad',
            'mililitros',
            'marca',
        ]);

        $imagen = $this->request->getFile('imagen');
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            // Generar nombre único para la imagen
            $nombreImagen = $imagen->getName();
            // Mover la imagen a la carpeta 'public/uploads/'
            $imagen->move('assets/img', $nombreImagen);
        } else {
            // Si no se sube la imagen o hay un error, asignar un valor por defecto
            $nombreImagen = 'default.png';  // Si no se sube una imagen, se puede poner una imagen por defecto
        }

        $productosModel = new ProductosModel();
        $productosModel->insert([
            'nombre' => trim($post['nombre']),
            'id_categoria' => $post['categoria'],
            'descripcion' => trim($post['descripcion']),
            'precio' => $post['precio'],
            'cantidad' => $post['cantidad'],
            'mililitros' => $post['mililitros'],
            'id_marca' => $post['marca'],
            'imagen' => $nombreImagen,
        ]);

        return redirect()->to('Productos/new')->with('message', 'Producto creado satisfactoriamente.');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
