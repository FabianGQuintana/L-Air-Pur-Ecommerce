<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MarcasModel;
use App\Models\CategoriasModel;
use App\Models\ProductosModel;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\UsuarioModel;
use App\Models\ConsultasModel;
use App\Models\ContactoModel;

/**
 * Controlador del panel de administración.
 * Permite gestionar usuarios, productos, facturas y consultas.
 */

class AdminController extends BaseController
{
    /**
     * Página principal del panel de administrador.
     * Muestra estadísticas generales del sistema y gráficas de ventas mensuales.
     */
    public function index()
    {
        $productosModel = new ProductosModel();
        $usuariosModel = new UsuarioModel();
        $facturaModel = new FacturaModel();

        $data['totalProductos'] = $productosModel->countAll();
        $data['totalUsuarios'] = $usuariosModel->where('activo', 1)->countAllResults();
        $data['totalOrdenes'] = $facturaModel->countAll();

        // ✅ Obtener datos del usuario desde la sesión
        $usuario = session('usuario_logueado');
        $data['adminNombre'] = $usuario['nombre'] ?? 'Administrador';
        $data['adminApellido'] = $usuario['apellido'] ?? '';

        $ventasMensuales = $facturaModel->obtenerVentasPorMes();
        $data['ventasPorMes'] = $ventasMensuales;

        // Inicializar todos los meses en 0
        $meses = array_fill(1, 12, 0);

        // Rellenar con los datos reales
        foreach ($ventasMensuales as $venta) {
            $meses[(int)$venta['mes']] = (int)$venta['cantidad'];
        }

        $nombreMeses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $data['ventasPorMes'] = [];
        foreach ($meses as $numeroMes => $cantidad) {
            $data['ventasPorMes'][] = [
                'mes' => $nombreMeses[$numeroMes],
                'cantidad' => $cantidad
            ];
        }


        $usuarios = $usuariosModel->where('activo', 1)->findAll();

        $data['title'] = 'Administrador';
        $data['content'] = view('Pages/PrincipalAdm', $data);
        return view('Templates/admin_layout', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo administrador.
     */
    public function nuevo()
    {
        return view('Templates/admin_layout', [
            'title' => 'Crear Administrador',
            'content' => view('Pages/FormNuevoAdmin')
        ]);
    }

    /**
     * Guarda un nuevo usuario con rol de administrador.
     * Valida los datos ingresados antes de guardar.
     */
    public function guardar()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre'    => 'required|min_length[2]',
            'apellido'  => 'required|min_length[2]',
            'telefono'  => 'permit_empty|numeric',
            'email'     => 'required|valid_email|is_unique[usuarios.email]',
            'password'  => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $usuarioModel = new \App\Models\UsuarioModel();

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'apellido'      => $this->request->getPost('apellido'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'           => 'admin'
        ];

        $usuarioModel->insert($data);

        return redirect()->to(base_url('UsuarioController'))
            ->with('success', 'Administrador creado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un usuario.
     *
     * @param int $id ID del usuario a editar.
     */
    public function actualizar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarioExistente = $usuarioModel->find($id);

        if (!$usuarioExistente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        // Reglas de validación sin contraseña
        $rules = [
            'nombre' => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'apellido' => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'telefono' => 'permit_empty|regex_match[/^[0-9\-\s\(\)]+$/]',
            'email' => 'required|valid_email|is_unique[usuarios.email,id_usuario,{id}]',
        ];

        // Mensajes personalizados
        $messages = [
            'nombre' => [
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'regex_match' => 'El nombre solo puede contener letras.'
            ],
            'apellido' => [
                'required' => 'El apellido es obligatorio.',
                'min_length' => 'El apellido debe tener al menos 3 caracteres.',
                'regex_match' => 'El apellido solo puede contener letras.'
            ],
            'telefono' => [
                'regex_match' => 'El teléfono solo puede contener números, espacios y paréntesis.'
            ],
            'email' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Introduce un correo válido.',
                'is_unique' => 'Este correo ya está en uso por otro usuario.'
            ]
        ];

        // Reemplazar el marcador {id} en la regla de email
        $rules['email'] = str_replace('{id}', $id, $rules['email']);

        // Validación
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Validación adicional de longitud mínima de teléfono
        $telefono = $this->request->getPost('telefono');
        $soloDigitos = preg_replace('/\D/', '', $telefono);
        if (!empty($telefono) && strlen($soloDigitos) < 10) {
            $this->validator->setError('telefono', 'El número de teléfono debe tener al menos 10 dígitos reales.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Preparar datos para actualizar
        $data = [
            'nombre' => $this->capitalizarNombreCompleto($this->request->getPost('nombre')),
            'apellido' => $this->capitalizarNombreCompleto($this->request->getPost('apellido')),
            'telefono' => $telefono,
            'email' => $this->request->getPost('email'),
            'rol' => $this->request->getPost('rol'),
        ];

        $usuarioModel->update($id, $data);

        return redirect()->to('/UsuarioController')->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * Actualiza los datos de un usuario existente.
     * Aplica validaciones específicas para nombre, apellido, teléfono y email.
     *
     * @param int $id ID del usuario a actualizar.
     */
    public function editar($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        return view('Templates/admin_layout', [
            'title' => 'Editar Usuario',
            'content' => view('Pages/AdminEditarUsuarios', ['usuario' => $usuario])
        ]);
    }

    /**
     * Desactiva un usuario (borrado lógico).
     *
     * @param int $id ID del usuario a desactivar.
     */
    public function eliminar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarioModel->update($id, ['activo' => 0]);

        return redirect()->to(base_url('UsuarioController'))
            ->with('success', 'Usuario desactivado correctamente.');
    }

    /**
     * Reactiva un usuario previamente desactivado.
     *
     * @param int $id ID del usuario a reactivar.
     */
    public function reactivar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarioModel->update($id, ['activo' => 1]);

        return redirect()->to(base_url('UsuarioController'))
            ->with('success', 'Usuario reactivado correctamente.');
    }

    /**
     * Administra los productos existentes.
     * Aplica filtros por categoría, marca, estado y búsqueda por nombre.
     */
    public function administrarProductos()
    {
        $categoriasModel = new CategoriasModel();
        $data['categorias'] = $categoriasModel->findAll();

        $marcasModel = new MarcasModel();
        $data['marcas'] = $marcasModel->findAll();

        $productosModel = new ProductosModel();

        $filtros = [
            'marcas'     => $this->request->getGet('marcas') ?? [],
            'categorias' => $this->request->getGet('categorias') ?? [],
        ];

        $activo = $this->request->getGet('activo');
        if ($activo !== null && $activo !== '') {
            $filtros['activo'] = (int)$activo;
        }

        $busqueda = $this->request->getGet('busqueda') ?? '';
        $data['busqueda'] = $busqueda;

        $productos = $productosModel->filtrar($filtros, $busqueda);

        $data['productos'] = $productos;
        $data['filtros'] = $filtros;
        $data['title'] = 'Adm Productos';
        $data['content'] = view('Pages/AdminProductos', $data);

        return view('Templates/admin_layout', $data);
    }

    /**
     * Lista todas las compras (facturas) realizadas por los usuarios.
     */
    public function listarCompras()
    {
        $facturaModel = new FacturaModel();

        $facturas = $facturaModel->obtenerFacturasConUsuario();

        $data['facturas'] = $facturas;
        $data['title'] = 'Compras Realizadas';
        $data['content'] = view('Pages/AdminCompras', $data);

        return view('Templates/admin_layout', $data);
    }

    /**
     * Muestra el detalle completo de una factura específica.
     *
     * @param int $idFactura ID de la factura a visualizar.
     */
    public function verFactura($idFactura)
    {
        $facturaModel = new FacturaModel();
        $detalleModel = new DetalleFacturaModel();
        $productoModel = new ProductosModel();
        $usuarioModel = new UsuarioModel();

        $factura = $facturaModel->find($idFactura);
        if (!$factura) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Factura no encontrada");
        }

        $usuario = $usuarioModel->find($factura['id_usuario']);

        $detallesBrutos = $detalleModel->where('id_factura', $idFactura)->findAll();

        $detalles = [];
        foreach ($detallesBrutos as $item) {
            $producto = $productoModel->find($item['id_producto']);
            $detalles[] = [
                'nombre_producto' => $producto['nombre'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $producto['precio'],
                'subtotal'        => $item['subtotal']
            ];
        }

        $data['factura'] = $factura;
        $data['usuario'] = $usuario;
        $data['detalles'] = $detalles;
        $data['content'] = view('Components/Factura', $data);

        return view('Templates/admin_layout', $data);
    }

    /**
     * Capitaliza correctamente nombres y apellidos.
     *
     * @param string $texto Texto a capitalizar.
     * @return string Texto capitalizado.
     */
    private function capitalizarNombreCompleto(string $texto): string
    {
        return preg_replace_callback('/\b[\p{L}\'\-]+/u', function ($coincidencia) {
            return mb_convert_case($coincidencia[0], MB_CASE_TITLE, "UTF-8");
        }, mb_strtolower($texto, 'UTF-8'));
    }

    /**
     * Muestra todas las consultas realizadas por usuarios registrados y no registrados.
     */
    public function verConsultas()
    {
        $consultasModel = new ConsultasModel();
        $contactoModel = new ContactoModel();

        $consultas = $consultasModel->obtenerConUsuarios();
        $contactos = $contactoModel->obtenerTodosOrdenados();

        $data = view('Pages/ConsultasAdmin', [
            'consultas' => $consultas,
            'contactos' => $contactos,
        ]);

        return view('Templates/admin_layout', [
            'title' => 'Consultas de Usuarios',
            'content' => $data
        ]);
    }

    /**
     * Marca una consulta o contacto como respondido.
     *
     * @param string $tipo Tipo de consulta ('consulta' o 'contacto').
     * @param int $id ID del registro a actualizar.
     */
    public function responderConsulta($tipo, $id)
    {
        if ($tipo === 'consulta') {
            $model = new ConsultasModel();
            $model->update($id, ['estado' => 'Respondido']);
        } elseif ($tipo === 'contacto') {
            $model = new ContactoModel();
            $model->update($id, ['estado' => 'Respondido']);
        }

        return redirect()->to(base_url('/Admin/consultas'))->with('mensaje', 'Consulta actualizada.');
    }

    public function guardarCategoria()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre' => [
                'label' => 'Nombre',
                'rules' => 'required|min_length[3]|alpha_space|regex_match[/(?!^\s*$).+/]',
                'errors' => [
                    'required'     => 'El {field} es obligatorio.',
                    'min_length'   => 'El {field} debe tener al menos 3 caracteres.',
                    'alpha_space'  => 'El {field} solo puede contener letras y espacios.',
                    'regex_match'  => 'El {field} no puede estar compuesto solo por espacios.'
                ]
            ],
            'descripcion' => [
                'label' => 'Descripción',
                'rules' => 'required|min_length[15]|regex_match[/(?!^\s*$).+/]',
                'errors' => [
                    'required'     => 'La {field} es obligatoria.',
                    'min_length'   => 'La {field} debe tener al menos 15 caracteres.',
                    'regex_match'  => 'La {field} no puede estar compuesta solo por espacios.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/Admin/Productos')->withInput()->with('errors', $validation->getErrors());
        }

        $categoriaModel = new CategoriasModel();

        $data = [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $categoriaModel->insert($data);

        return redirect()->to('/Admin/Productos')->with('success', 'Categoría creada correctamente.');
    }

    public function guardarMarca()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre_marca' => [
                'label' => 'Nombre de marca',
                'rules' => 'required|min_length[3]|alpha_space|regex_match[/(?!^\s*$).+/]',
                'errors' => [
                    'required'     => 'El {field} es obligatorio.',
                    'min_length'   => 'El {field} debe tener al menos 3 caracteres.',
                    'alpha_space'  => 'El {field} solo puede contener letras y espacios.',
                    'regex_match'  => 'El {field} no puede estar compuesto solo por espacios.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/Admin/Productos')->withInput()->with('errors', $validation->getErrors());
        }

        $marcaModel = new MarcasModel();

        $data = [
            'nombre_marca' => $this->request->getPost('nombre_marca'),
        ];

        $marcaModel->insert($data);

        return redirect()->to('/Admin/Productos')->with('success', 'Marca creada correctamente.');
    }
}
