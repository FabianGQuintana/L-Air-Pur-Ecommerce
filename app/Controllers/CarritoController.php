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
                $subtotal = $producto['precio'] * $item['cantidad'];
                $total += $subtotal;

                $items[] = [
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
        
        $carrito = $session->get('carrito') ?? [];

        $cantidadSolicitada = $this->request->getPost('cantidad');
        $cantidadSolicitada = (is_numeric($cantidadSolicitada) && $cantidadSolicitada > 0) ? intval($cantidadSolicitada) : 1;

        $productosModel = new \App\Models\ProductosModel();
        $producto = $productosModel->obtenerProductoConDetalles($idProducto);

        if (!$producto) {
            return $this->response->setStatusCode(400)->setBody('Producto no encontrado');
        }

        $stockDisponible = intval($producto['cantidad']);
        $cantidadActualEnCarrito = isset($carrito[$idProducto]) ? $carrito[$idProducto]['cantidad'] : 0;
        $cantidadFinal = $cantidadActualEnCarrito + $cantidadSolicitada;

        if ($cantidadFinal > $stockDisponible) {
            return $this->response->setStatusCode(400)->setBody('No hay suficiente stock disponible');
        }

        $carrito[$idProducto] = [
            'id' => $idProducto,
            'cantidad' => $cantidadFinal
        ];

        $session->set('carrito', $carrito);

        return $this->response->setStatusCode(200)->setBody('Producto agregado al carrito');
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
                $subtotal = $producto['precio'] * $item['cantidad'];
                $total += $subtotal;

                $items[] = [
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

        return ['items' => $items, 'total' => $total];
    }

    public function agregarAjax($id)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

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
