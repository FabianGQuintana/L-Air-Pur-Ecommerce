<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MarcasModel;
use App\Models\CategoriasModel;
use App\Models\ProductosModel;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\UsuarioModel;

class AdminController extends BaseController
{
    public function index()
    {
        $productosModel = new ProductosModel();
        $usuariosModel = new UsuarioModel();
        $facturaModel = new FacturaModel();

        $data['totalProductos'] = $productosModel->countAll();
        $data['totalUsuarios'] = $usuariosModel->countAll();
        $data['totalOrdenes'] = $facturaModel->countAll();

        // ✅ Obtener datos del usuario desde la sesión
        $usuario = session('usuario_logueado');
        $data['adminNombre'] = $usuario['nombre'] ?? 'Administrador';
        $data['adminApellido'] = $usuario['apellido'] ?? '';

        $ventasMensuales = $facturaModel->obtenerVentasPorMes();
        $data['ventasPorMes'] = $ventasMensuales;

        $data['title'] = 'Administrador';
        $data['content'] = view('Pages/PrincipalAdm', $data);
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

        // Filtro de activo/inactivo
        $activo = $this->request->getGet('activo');
        if ($activo !== null && $activo !== '') {
            $filtros['activo'] = (int)$activo; // Convertir a entero 0 o 1
        }

        // Término de búsqueda
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $data['busqueda'] = $busqueda;

        // Productos filtrados
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
        $data['content'] = view('Components/Factura',$data);

        return view('Templates/admin_layout', $data);
    }

}