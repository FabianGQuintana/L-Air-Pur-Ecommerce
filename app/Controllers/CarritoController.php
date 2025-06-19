<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;

class CarritoController extends BaseController
{
    public function index()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');
        $carrito = $session->get('carrito') ?? [];

        $productosModel = new ProductosModel();

        $items = [];
        $total = 0;

        foreach ($carrito as $idProducto => $item) {
            // Obtenemos el producto con los detalles
            $producto = $productosModel->obtenerProductoConDetalles($idProducto);

            if ($producto) {
                $cantidadDisponible = $producto['cantidad'];
                $cantidad = min($item['cantidad'], $cantidadDisponible);
                $subtotal = $producto['precio'] * $cantidad;
                $total += $subtotal;

                $items[] = [
                    'id' => $idProducto,
                    'nombre' => $producto['nombre'],
                    'marca' => $producto['marca'],
                    'categoria' => $producto['categoria'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'imagen' => $producto['imagen'],
                    'stock' => $cantidadDisponible
                ];
            }
        }

        return view('Templates/main_layout', [
            'title' => 'Mi Carrito',
            'content' => view('Pages/CarritoCompras', [
                'usuario' => $usuario,
                'items' => $items,
                'total' => $total
            ])
        ]);
    }

    public function agregar($idProducto)
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');
        $request = \Config\Services::request();

        if (!$usuario || !isset($usuario['id_usuario'])) {
            if ($request->isAJAX()) {
                return $this->response
                    ->setStatusCode(401)
                    ->setJSON(['redirect' => base_url('/Auth/Login')]);
            } else {
                return redirect()->to('/Auth/Login');
            }
        }

        $cantidad = (int) $this->request->getPost('cantidad');

        if ($cantidad < 1) {
            return $this->response
                ->setStatusCode(400)
                ->setBody('Cantidad inválida');
        }

        $productoModel = new ProductosModel();
        $producto = $productoModel->find($idProducto);

        if (!$producto || (isset($producto['activo']) && $producto['activo'] != 1)) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Producto no disponible');
        }

        if (!$session->has('carrito')) {
            $session->set('carrito', []);
        }

        $carrito = $session->get('carrito');

        $cantidadExistente = isset($carrito[$idProducto]) ? (int) $carrito[$idProducto]['cantidad'] : 0;
        $stockDisponibleReal = (int) $producto['cantidad'];
        $stockDisponibleVirtual = $stockDisponibleReal - $cantidadExistente;

        if ($cantidad > $stockDisponibleVirtual) {
            return $this->response
                ->setStatusCode(400)
                ->setBody("No hay suficiente stock disponible. Stock virtual actual: $stockDisponibleVirtual");
        }

        if (isset($carrito[$idProducto])) {
            $carrito[$idProducto]['cantidad'] += $cantidad;
        } else {
            $carrito[$idProducto] = [
                'id_producto' => $idProducto,
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
                'imagen' => $producto['imagen']
            ];
        }

        $session->set('carrito', $carrito);

        $cantidadTotalEnCarrito = $carrito[$idProducto]['cantidad'];
        $stockDisponible = max(0, $producto['cantidad'] - $cantidadTotalEnCarrito);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Producto agregado al carrito',
            'stock_disponible' => $stockDisponible
        ]);
    }



    public function quitar($idProducto)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        if (isset($carrito[$idProducto])) {
            // Resta 1 a la cantidad
            $carrito[$idProducto]['cantidad']--;

            if ($carrito[$idProducto]['cantidad'] <= 0) {
                // Si la cantidad es cero o menor, eliminamos el producto completamente
                unset($carrito[$idProducto]);
            }

            $session->set('carrito', $carrito);
            return redirect()->back()->with('success', 'Producto actualizado en el carrito.');
        }

        return redirect()->back()->with('warning', 'El producto no está en el carrito.');
    }

    public function eliminar($idProducto)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        if (isset($carrito[$idProducto])) {
            unset($carrito[$idProducto]);
            $session->set('carrito', $carrito);
            return redirect()->back()->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->back()->with('warning', 'El producto no existe en el carrito.');
    }


    public function vaciar()
    {
        $session = session();
        $session->remove('carrito');

        return redirect()->back()->with('success', 'Carrito vaciado');
    }

    private function obtenerDatosCarrito() 
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];
        $productosModel = new \App\Models\ProductosModel();

        $items = [];
        $total = 0;

        foreach ($carrito as $idProducto => $item) {
            $producto = $productosModel->obtenerProductoConDetalles($idProducto);
            if ($producto) {
                $cantidadDisponible = $producto['cantidad'];
                $cantidad = min($item['cantidad'], $cantidadDisponible);
                $subtotal = $producto['precio'] * $cantidad;
                $total += $subtotal;

                $items[] = [
                    'id' => $idProducto,
                    'nombre' => $producto['nombre'],
                    'marca' => $producto['marca'],
                    'categoria' => $producto['categoria'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'imagen' => $producto['imagen'],
                    'stock' => $cantidadDisponible
                ];
            }
        }

        return ['items' => $items, 'total' => $total];
    }

    public function agregarAjax($id)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        $productosModel = new \App\Models\ProductosModel();
        $producto = $productosModel->obtenerProductoConDetalles($id);

        if (
            !$producto ||
            (isset($producto['activo']) && $producto['activo'] != 1) ||
            $producto['cantidad'] <= ($carrito[$id]['cantidad'] ?? 0)
        ) {
            return $this->response->setJSON([
                'error' => true,
                'mensaje' => 'No se puede agregar este producto. Puede estar agotado o inactivo.'
            ]);
        }

        $carrito[$id]['cantidad'] = ($carrito[$id]['cantidad'] ?? 0) + 1;
        $session->set('carrito', $carrito);

        return $this->response->setJSON($this->obtenerFragmentos());
    }

    public function quitarAjax($id)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']--;
            if ($carrito[$id]['cantidad'] <= 0) {
                unset($carrito[$id]);
            }
        }

        $session->set('carrito', $carrito);
        return $this->response->setJSON($this->obtenerFragmentos());
    }

    public function eliminarAjax($id)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        unset($carrito[$id]);
        $session->set('carrito', $carrito);

        return $this->response->setJSON($this->obtenerFragmentos());
    }

    private function obtenerFragmentos()
    {
        $datos = $this->obtenerDatosCarrito();

        return [
            'productos' => view('Fragments/ItemsCarrito', $datos),
            'resumen' => view('Fragments/ResumenCarrito', $datos)
        ];
    }

    public function comprar()
    {
        $session = session();
        $carrito = $session->get('carrito');
        $usuario = $session->get('usuario_logueado');


        if (!$this->validarCompra($usuario, $carrito)) {
            return redirect()->back()->with('error', 'Debe estar logueado y tener productos en el carrito.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $idFactura = $this->crearFactura($usuario, $carrito);
        $this->procesarDetalleYActualizarStock($carrito, $idFactura);


        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Error al procesar la compra. Intente nuevamente.');
        }

        $session->remove('carrito');
        return redirect()->to('/Carrito/confirmacion')->with('success', 'Compra realizada con éxito.');
    }

    private function validarCompra($usuario, $carrito): bool
    {
        return $usuario && !empty($carrito);
    }

    /**
     * Crea una factura para el usuario con los productos del carrito.
     *
     * @param array $usuario Datos del usuario logueado
     * @param array $carrito Contenido del carrito de compras
     * @return int ID de la factura recién insertada
     */
    private function crearFactura(array $usuario, array $carrito): int
    {
        $facturaModel = new \App\Models\FacturaModel();

        $totalProductos = 0;
        $importeTotal = 0;

        foreach ($carrito as $item) {
            $cantidad = (int) $item['cantidad'];
            $precio = (float) $item['precio'];
            $totalProductos += $cantidad;
            $importeTotal += $cantidad * $precio;
        }

        $facturaModel->insert([
            'id_usuario' => $usuario['id_usuario'],
            'cantidad_productos' => $totalProductos,
            'importe_total' => $importeTotal,
            'fecha_hora' => date('Y-m-d H:i:s')
        ]);

        return $facturaModel->getInsertID();
    }

    private function procesarDetalleYActualizarStock(array $carrito, int $idFactura): void
    {
        $detalleFacturaModel = new \App\Models\DetalleFacturaModel();
        $productosModel = new \App\Models\ProductosModel();

        foreach ($carrito as $idProducto => $item) {
            $idProducto = (int)$idProducto;
            $cantidadComprada = (int)$item['cantidad'];
            $precioUnitario = (float)$item['precio'];

            $detalleFacturaModel->insert([
                'id_factura' => $idFactura,
                'id_producto' => $idProducto,
                'cantidad' => $cantidadComprada,
                'subtotal' => $cantidadComprada * $precioUnitario
            ]);

            $producto = $productosModel->find($idProducto);
            if ($producto) {
                $nuevoStock = $producto['cantidad'] - $cantidadComprada;
                $productosModel->update($idProducto, [
                    'cantidad' => $nuevoStock,
                    'activo' => ($nuevoStock <= 0) ? 0 : 1
                ]);
            }
        }
    }

    public function confirmacion()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        if (!$usuario) {
            return redirect()->to('/Auth/Login')->with('error', 'Debe iniciar sesión para ver la confirmación de su compra.');
        }

        $facturaModel = new \App\Models\FacturaModel();
        $detalleModel = new \App\Models\DetalleFacturaModel();
        $productoModel = new \App\Models\ProductosModel();

        // Obtener la última factura del usuario
        $factura = $facturaModel
            ->where('id_usuario', $usuario['id_usuario'])
            ->orderBy('id_factura', 'DESC')
            ->first();

        if (!$factura) {
            return redirect()->to('/')->with('warning', 'No se encontró ninguna factura.');
        }

        // Obtener los detalles de la factura
        $detallesFactura = $detalleModel
            ->where('id_factura', $factura['id_factura'])
            ->findAll();

        // Enriquecer con datos del producto
        $detalles = [];
        foreach ($detallesFactura as $detalle) {
            $producto = $productoModel->find($detalle['id_producto']);

            if ($producto) {
                $detalles[] = [
                    'nombre_producto' => $producto['nombre'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $producto['precio'],
                    'subtotal' => $detalle['subtotal']
                ];
            }
        }

        return view('Templates/main_layout', [
            'title' => 'Gracias por su compra',
            'content' => view('Pages/ConfirmacionCompra', [
                'usuario' => $usuario,
                'factura' => $factura,
                'detalles' => $detalles
            ])
        ]);
    }

}

