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

class AdminController extends BaseController
{
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

    public function nuevo()
    {
        return view('Templates/admin_layout', [
            'title' => 'Crear Administrador',
            'content' => view('Pages/FormNuevoAdmin')
        ]);
    }

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

    public function eliminar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarioModel->update($id, ['activo' => 0]);

        return redirect()->to(base_url('UsuarioController'))
            ->with('success', 'Usuario desactivado correctamente.');
    }

    public function reactivar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarioModel->update($id, ['activo' => 1]);

        return redirect()->to(base_url('UsuarioController'))
            ->with('success', 'Usuario reactivado correctamente.');
    }

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

    public function listarCompras()
    {
        $facturaModel = new FacturaModel();
        $usuarioModel = new UsuarioModel();

        $facturas = $facturaModel->select('facturas.*, usuarios.nombre, usuarios.apellido, usuarios.email')
            ->join('usuarios', 'usuarios.id_usuario = facturas.id_usuario')
            ->orderBy('facturas.fecha_hora', 'DESC')
            ->findAll();

        $data['facturas'] = $facturas;
        $data['title'] = 'Compras Realizadas';
        $data['content'] = view('Pages/AdminCompras', $data);

        return view('Templates/admin_layout', $data);
    }

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

    private function capitalizarNombreCompleto(string $texto): string
    {
        return preg_replace_callback('/\b[\p{L}\'\-]+/u', function ($coincidencia) {
            return mb_convert_case($coincidencia[0], MB_CASE_TITLE, "UTF-8");
        }, mb_strtolower($texto, 'UTF-8'));
    }

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

}
