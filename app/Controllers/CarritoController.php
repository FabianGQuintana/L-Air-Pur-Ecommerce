<?php

namespace App\Controllers;

use App\Models\ProductosModel;

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

        if (!$producto) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Producto no encontrado');
        }

        if (!$session->has('carrito')) {
            $session->set('carrito', []);
        }

        $carrito = $session->get('carrito');

        $cantidadExistente = isset($carrito[$idProducto]) ? (int) $carrito[$idProducto]['cantidad'] : 0;
        $stockDisponibleReal = (int) $producto['cantidad'];
        $stockDisponibleVirtual = $stockDisponibleReal - $cantidadExistente;

        // Validar stock disponible
        if ($cantidad > $stockDisponibleVirtual) {
            return $this->response
                ->setStatusCode(400)
                ->setBody("No hay suficiente stock disponible. Stock virtual actual: $stockDisponibleVirtual");
        }

        // Agregar al carrito
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

        // Calcular stock virtual restante
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

        if (!$producto || $producto['cantidad'] <= ($carrito[$id]['cantidad'] ?? 0)) {
            return $this->response->setJSON([
                'error' => true,
                'mensaje' => 'No hay suficiente stock disponible para este producto.'
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
    
}
