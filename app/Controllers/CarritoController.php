<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;

/**
 * Controlador para manejar las operaciones del carrito de compras.
 * Incluye gestión de productos en el carrito, compra, y confirmación.
 */
class CarritoController extends BaseController
{
    /**
     * Muestra la vista del carrito con los productos agregados, sus cantidades y total.
     *
     * @return \CodeIgniter\HTTP\Response|string Vista renderizada con la información del carrito.
     */
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

    /**
     * Agrega un producto al carrito, validando stock y usuario logueado.
     *
     * @param int $idProducto ID del producto a agregar.
     * @return \CodeIgniter\HTTP\Response JSON con resultado de la operación o redirección.
     */
    public function agregar($idProducto)
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');
        $request = \Config\Services::request();

        if (!$usuario || !isset($usuario['id_usuario'])) {
            return $this->respuestaNoAutorizada($request);
        }

        $cantidad = (int) $this->request->getPost('cantidad');
        if ($cantidad < 1) {
            return $this->respuestaError('Cantidad inválida', 400);
        }

        $producto = $this->obtenerProductoActivo($idProducto);
        if (!$producto) {
            return $this->respuestaError('Producto no disponible', 404);
        }

        $carrito = $session->get('carrito') ?? [];

        $stockVirtual = $this->calcularStockVirtual($producto, $carrito, $idProducto);
        if ($cantidad > $stockVirtual) {
            return $this->respuestaError("No hay suficiente stock disponible. Stock virtual actual: $stockVirtual", 400);
        }

        $carrito = $this->actualizarCarrito($carrito, $producto, $cantidad, $idProducto);
        $session->set('carrito', $carrito);

        $stockDisponible = max(0, $producto['cantidad'] - $carrito[$idProducto]['cantidad']);

        return $this->response->setJSON([
            'success' => true,
            'mensaje' => 'Producto agregado al carrito',
            'stock_disponible' => $stockDisponible
        ]);
    }

    /**
     * Retorna respuesta de error 401 para usuarios no autorizados, con redirección según si la petición es AJAX o no.
     *
     * @param object $request Objeto Request de CodeIgniter para determinar el tipo de petición.
     * @return \CodeIgniter\HTTP\Response|\CodeIgniter\HTTP\RedirectResponse Respuesta con redirección o JSON.
     */
    private function respuestaNoAutorizada($request)
    {
        if ($request->isAJAX()) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['redirect' => base_url('/Auth/Login')]);
        }
        return redirect()->to('/Auth/Login');
    }

    /**
     * Retorna respuesta HTTP con código y mensaje de error.
     *
     * @param string $mensaje Mensaje de error a enviar.
     * @param int $codigo Código HTTP de la respuesta.
     * @return \CodeIgniter\HTTP\Response Respuesta HTTP con error.
     */
    private function respuestaError($mensaje, $codigo)
    {
        return $this->response
            ->setStatusCode($codigo)
            ->setBody($mensaje);
    }

    /**
     * Obtiene el producto activo por su ID.
     *
     * @param int $idProducto ID del producto a buscar.
     * @return array|null Arreglo con datos del producto o null si no existe o no está activo.
     */
    private function obtenerProductoActivo($idProducto)
    {
        $productoModel = new ProductosModel();
        $producto = $productoModel->find($idProducto);
        if (!$producto || (isset($producto['activo']) && $producto['activo'] != 1)) {
            return null;
        }
        return $producto;
    }

    /**
     * Calcula el stock virtual disponible restando la cantidad ya agregada en el carrito.
     *
     * @param array $producto Datos del producto.
     * @param array $carrito Estado actual del carrito.
     * @param int $idProducto ID del producto.
     * @return int Cantidad disponible virtualmente para agregar.
     */
    private function calcularStockVirtual($producto, $carrito, $idProducto)
    {
        $cantidadExistente = isset($carrito[$idProducto]) ? (int) $carrito[$idProducto]['cantidad'] : 0;
        return (int) $producto['cantidad'] - $cantidadExistente;
    }

    /**
     * Actualiza el carrito agregando la cantidad indicada del producto.
     *
     * @param array $carrito Carrito actual.
     * @param array $producto Datos del producto a agregar.
     * @param int $cantidad Cantidad a agregar.
     * @param int $idProducto ID del producto.
     * @return array Carrito actualizado.
     */
    private function actualizarCarrito($carrito, $producto, $cantidad, $idProducto)
    {
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
        return $carrito;
    }

    /**
     * Reduce en 1 la cantidad de un producto en el carrito o elimina si queda en 0.
     *
     * @param int $idProducto ID del producto a quitar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirecciona a la página anterior con mensaje.
     */
    public function quitar($idProducto)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        if (isset($carrito[$idProducto])) {
            $carrito[$idProducto]['cantidad']--;

            if ($carrito[$idProducto]['cantidad'] <= 0) {
                unset($carrito[$idProducto]);
            }

            $session->set('carrito', $carrito);
            return redirect()->back()->with('success', 'Producto actualizado en el carrito.');
        }

        return redirect()->back()->with('warning', 'El producto no está en el carrito.');
    }

    /**
     * Elimina completamente un producto del carrito.
     *
     * @param int $idProducto ID del producto a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirecciona a la página anterior con mensaje.
     */
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

    /**
     * Vacía completamente el carrito.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirecciona a la página anterior con mensaje.
     */
    public function vaciar()
    {
        $session = session();
        $session->remove('carrito');

        return redirect()->back()->with('success', 'Carrito vaciado');
    }

    /**
     * Obtiene los datos completos del carrito para vistas y fragmentos.
     *
     * @return array Arreglo con 'items' (productos) y 'total' (importe total).
     */
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

    /**
     * Agrega un producto al carrito vía AJAX (incrementa en 1).
     *
     * @param int $id ID del producto a agregar.
     * @return \CodeIgniter\HTTP\Response JSON con los fragmentos actualizados o error.
     */
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

    /**
     * Quita un producto del carrito vía AJAX (decrementa en 1 o elimina si llega a 0).
     *
     * @param int $id ID del producto a quitar.
     * @return \CodeIgniter\HTTP\Response JSON con los fragmentos actualizados.
     */
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

    /**
     * Elimina un producto del carrito vía AJAX.
     *
     * @param int $id ID del producto a eliminar.
     * @return \CodeIgniter\HTTP\Response JSON con los fragmentos actualizados.
     */
    public function eliminarAjax($id)
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        unset($carrito[$id]);
        $session->set('carrito', $carrito);

        return $this->response->setJSON($this->obtenerFragmentos());
    }

    /**
     * Obtiene los fragmentos HTML para actualizar el carrito y resumen vía AJAX.
     *
     * @return array Arreglo con vistas renderizadas de productos y resumen.
     */
    private function obtenerFragmentos()
    {
        $datos = $this->obtenerDatosCarrito();

        return [
            'productos' => view('Fragments/ItemsCarrito', $datos),
            'resumen' => view('Fragments/ResumenCarrito', $datos)
        ];
    }

    /**
     * Procesa la compra: valida, crea factura, guarda detalles y actualiza stock.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirige a confirmación o retorna con error.
     */
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

    /**
     * Valida que el usuario esté logueado y el carrito no esté vacío.
     *
     * @param array|null $usuario Datos del usuario logueado.
     * @param array|null $carrito Contenido del carrito.
     * @return bool Verdadero si la compra es válida, falso en caso contrario.
     */
    private function validarCompra($usuario, $carrito): bool
    {
        return $usuario && !empty($carrito);
    }

    /**
     * Crea una factura para el usuario con los productos del carrito.
     *
     * @param array $usuario Datos del usuario logueado.
     * @param array $carrito Contenido del carrito de compras.
     * @return int ID de la factura recién insertada.
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

    /**
     * Inserta los detalles de la factura y actualiza el stock y estado de los productos.
     *
     * @param array $carrito Contenido del carrito.
     * @param int $idFactura ID de la factura creada.
     * @return void
     */
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

    /**
     * Muestra la página de confirmación de compra con datos de la última factura y sus detalles.
     *
     * @return \CodeIgniter\HTTP\Response|string Vista con la confirmación de compra o redirección.
     */
    public function confirmacion()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        if (!$usuario) {
            return redirect()
                ->to('/Auth/Login')
                ->with('error', 'Debe iniciar sesión para ver la confirmación de su compra.');
        }

        $factura = $this->obtenerUltimaFactura($usuario['id_usuario']);

        if (!$factura) {
            return redirect()
                ->to('/')
                ->with('warning', 'No se encontró ninguna factura.');
        }

        $detalles = $this->obtenerDetallesConProductos($factura['id_factura']);

        return view('Templates/main_layout', [
            'title' => 'Gracias por su compra',
            'content' => view('Pages/ConfirmacionCompra', [
                'usuario' => $usuario,
                'factura' => $factura,
                'detalles' => $detalles
            ])
        ]);
    }

    /**
     * Obtiene la última factura realizada por un usuario.
     *
     * @param int $idUsuario ID del usuario.
     * @return array|null Datos de la factura o null si no existe.
     */
    private function obtenerUltimaFactura($idUsuario)
    {
        $facturaModel = new \App\Models\FacturaModel();
        return $facturaModel
            ->where('id_usuario', $idUsuario)
            ->orderBy('id_factura', 'DESC')
            ->first();
    }

    /**
     * Obtiene los detalles de una factura junto con la información de los productos.
     *
     * @param int $idFactura ID de la factura.
     * @return array Lista de detalles con nombre de producto, cantidad, precio unitario y subtotal.
     */
    private function obtenerDetallesConProductos($idFactura)
    {
        $detalleModel = new \App\Models\DetalleFacturaModel();
        $productoModel = new \App\Models\ProductosModel();

        $detallesFactura = $detalleModel
            ->where('id_factura', $idFactura)
            ->findAll();

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

        return $detalles;
    }
}
