<?php

namespace App\Controllers;

use App\Models\ProductosModel;

class Pages extends BaseController
{
    public function index()
{
    
    $productoModel = new \App\Models\ProductosModel();

    // Consultas con límite de 4 productos por categoría
    $productosDiseñador = $productoModel->where('id_categoria', 3)->limit(4)->find();
    $productosNicho     = $productoModel->where('id_categoria', 1)->limit(4)->find();
    $productosArabes    = $productoModel->where('id_categoria', 2)->limit(4)->find();

    // Cargar la página de inicio con los productos por sección
    return view('Templates/main_layout', [
        'title' => 'Inicio - L’Air Pur',
        'content' => view('Pages/PaginaPrincipal', [
            'destacados' => $productosDiseñador,
            'exclusivos' => $productosNicho,
            'arabes'     => $productosArabes,
        ])
    ]);
}

    
    public function QuienesSomos()
    {
        // Cargar la página "Quiénes Somos"
        return view('Templates/main_layout', [
            'title' => 'Quiénes Somos - L’Air Pur',
            'content' => view('Pages/QuienesSomos')
        ]);
    }

    public function Comercializacion()
    {
        // Cargar la página "Comercializacion"
        return view('Templates/main_layout', [
            'title' => 'Comercializacion - L’Air Pur',
            'content' => view('Pages/Comercializacion')
        ]);
    }
    
    public function TerminosYCondiciones()
    {
        // Cargar la página de "Términos y Condiciones"
        return view('Templates/main_layout', [
            'title' => 'Términos y Condiciones - L’Air Pur',
            'content' => view('Pages/TerminosYCondiciones')
        ]);
    }

    public function EnConstruccion()
    {
        // Cargar la página de "En Construccion"
        return view('Templates/main_layout', [
            'title' => 'En Construcción - L’Air Pur',
            'content' => view('errors/En_Construccion')
        ]);
    }

    public function Auth(){
        return view('Templates/main_layout',[
            'title' => 'Login - L’Air Pur',
            'content' => view('Pages/Auth/Login')
        ]);
    }

    public function PerfilUsuario()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        if (!$usuario) {
            return redirect()->to('/Auth/Login');
        }

        // === CARRITO ACTUAL DESDE SESIÓN ===
        $carrito = $session->get('carrito') ?? [];
        $productosModel = new \App\Models\ProductosModel();

        $itemsCarrito = [];
        $totalCarrito = 0;

        foreach ($carrito as $idProducto => $item) {
            $producto = $productosModel->obtenerProductoConDetalles($idProducto);
            if ($producto) {
                $subtotal = $producto['precio'] * $item['cantidad'];
                $totalCarrito += $subtotal;

                $itemsCarrito[] = [
                    'id' => $idProducto,
                    'nombre' => $producto['nombre'],
                    'marca' => $producto['marca'],
                    'categoria' => $producto['categoria'],
                    'precio' => $producto['precio'],
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $subtotal,
                    'imagen' => $producto['imagen'],
                ];
            }
        }

        // === HISTORIAL DE COMPRAS ===
        $facturaModel = new \App\Models\FacturaModel();
        $detalleModel = new \App\Models\DetalleFacturaModel();

        // Buscar facturas del usuario
        $facturas = $facturaModel->where('id_usuario', $usuario['id_usuario'])
                                ->orderBy('fecha', 'DESC')
                                ->findAll();

        // Agregar detalles a cada factura
        foreach ($facturas as &$factura) {
            $factura['detalles'] = $detalleModel->obtenerDetallesConProducto($factura['id_factura']);
        }

        // === CARGAR VISTA ===
        $data = [
            'title' => 'Perfil de Usuario - L’Air Pur',
            'content' => view('Pages/PerfilUsuario', [
                'usuario' => $usuario,
                'itemsCarrito' => $itemsCarrito,
                'totalCarrito' => $totalCarrito,
                'facturas' => $facturas
            ])
        ];

        return view('Templates/main_layout', $data);
    }



    


}