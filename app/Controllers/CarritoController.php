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

        // Obtener la cantidad enviada desde el formulario
        $cantidad = $this->request->getPost('cantidad');
        $cantidad = ($cantidad && is_numeric($cantidad) && $cantidad > 0) ? intval($cantidad) : 1;

        if (isset($carrito[$idProducto])) {
            // Sumar la cantidad al existente
            $carrito[$idProducto]['cantidad'] += $cantidad;
        } else {
            // Agregar el producto con la cantidad solicitada
            $carrito[$idProducto] = [
                'id' => $idProducto,
                'cantidad' => $cantidad
            ];
        }

        $session->set('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
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
}
