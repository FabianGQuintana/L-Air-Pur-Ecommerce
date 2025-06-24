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
     * Muestra el catálogo de productos, con posibilidad de aplicar filtros por marca, categoría y búsqueda por nombre.
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
            'activo'     => 1, // ✅ Solo productos activos
        ];

        // Tomar término de búsqueda
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $data['busqueda'] = $busqueda;

        // Obtener productos filtrados, activos y con búsqueda
        $productos = $productosModel->filtrar($filtros, $busqueda);

        $data['productos'] = $productos;
        $data['filtros'] = $filtros;
        $data['title'] = 'Productos - L’Air Pur';
        $data['content'] = view('Pages/Catalogo', $data);

        return view('Templates/main_layout', $data);
    }


    /**
     * Muestra el detalle de un producto específico.
     *
     * @param int|string|null $id ID del producto a mostrar
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $modelo = new ProductosModel();
        $producto = $modelo->obtenerProductoConDetalles($id);

        // Validar que exista y esté activo
        if (!$producto || (isset($producto['activo']) && $producto['activo'] != 1)) {
            return redirect()->to(base_url('/'));
        }

        // Obtener el carrito de la sesión
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        $cantidadEnCarrito = isset($carrito[$id]) ? (int)$carrito[$id]['cantidad'] : 0;
        $stockVirtual = max(0, (int)$producto['cantidad'] - $cantidadEnCarrito);
        $producto['cantidad'] = $stockVirtual;

        return view('Pages/DetalleProducto', [
            'producto' => $producto,
            'title' => 'Producto - L’Air Pur',
            'mostrar_popup' => true,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
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
     * Procesa y guarda los datos enviados desde el formulario para crear un nuevo producto.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $reglas = [
            'nombre' => 'required|min_length[3]',
            'categoria' => 'required|is_not_unique[categorias.id_categoria]',
            'descripcion' => 'required|min_length[15]',
            'precio' => 'required|decimal|greater_than[0]',
            'cantidad' => 'required|integer|greater_than[0]',
            'mililitros' => 'required|integer|greater_than[0]',
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
                'greater_than' => 'El precio debe ser mayor a cero.',
            ],
            'cantidad' => [
                'required' => 'La cantidad es obligatoria.',
                'integer' => 'La cantidad debe ser un número entero.',
                'greater_than' => 'La cantidad debe ser mayor a cero.',
            ],
            'mililitros' => [
                'required' => 'Los mililitros son obligatorios.',
                'integer' => 'Los mililitros deben ser un número entero.',
                'greater_than' => 'Los mililitros deben ser mayores a cero.',
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
     * Muestra el formulario para editar un producto existente.
     *
     * @param int|string|null $id ID del producto a editar
     * @return ResponseInterface
     */
    public function edit($id = null)
    {   
        $productosModel = new ProductosModel();
        $producto = $productosModel->find($id);

        $marcasModel = new MarcasModel();
        $data['marcas'] = $marcasModel->findAll();

        $categoriasModel = new CategoriasModel();
        $data['categorias'] = $categoriasModel->findAll();

        $data['producto'] = $producto;
        $data['title'] = 'Editar producto - L’Air Pur';
        $data['content'] = view('Components/Form_EditProducto', $data);

        return view('Templates/admin_layout', $data);
    }

    /**
     * Procesa y guarda los cambios realizados a un producto existente.
     *
     * @param int|string|null $id ID del producto a actualizar
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $reglas = [
            'nombre' => 'required|min_length[3]',
            'categoria' => 'required',
            'descripcion' => 'required|min_length[15]',
            'precio' => 'required|decimal',
            'cantidad' => 'required|integer',
            'mililitros' => 'required|integer',
            'marca' => 'required',
        ];

        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $reglas['imagen'] = 'is_image[imagen]|max_size[imagen,2048]';
        }

        $mensajes = [
            'nombre' => [
                'required' => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            ],
            'categoria' => [
                'required' => 'La categoría es obligatoria.',
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
            ],
            'imagen' => [
                'is_image' => 'El archivo debe ser una imagen válida.',
                'max_size' => 'La imagen no debe superar los 2MB.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
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
            'activo',
        ]);

        $activo = ($post['cantidad'] > 0) ? $post['activo'] : 0;

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getName();
            $imagen->move('assets/img', $nombreImagen);
        } else {
            $productoActual = (new ProductosModel())->find($id);
            $nombreImagen = $productoActual['imagen'] ?? 'default.png';
        }

        $productosModel = new ProductosModel();
        $productosModel->update($id, [
            'nombre' => trim($post['nombre']),
            'id_categoria' => $post['categoria'],
            'descripcion' => trim($post['descripcion']),
            'precio' => $post['precio'],
            'cantidad' => $post['cantidad'],
            'mililitros' => $post['mililitros'],
            'id_marca' => $post['marca'],
            'imagen' => $nombreImagen,
            'activo' => $activo,
        ]);

        return redirect()->to('Productos/' . $id . '/edit')
                        ->with('message', 'Producto actualizado satisfactoriamente.');
    }

    /**
     * Realiza un "borrado lógico" del producto, desactivándolo.
     *
     * @param int|string|null $id ID del producto a eliminar
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->back()->with('error', 'ID de producto no proporcionado.');
        }

        $productosModel = new \App\Models\ProductosModel();

        // Verificamos que el producto exista
        $producto = $productosModel->find($id);
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Realizamos el "borrado lógico" actualizando el campo 'activo' a 0
        $productosModel->update($id, ['activo' => 0]);

        return redirect()->back()->with('success', 'Producto desactivado correctamente.');
    }

}
