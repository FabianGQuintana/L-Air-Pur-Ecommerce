<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SoloUsuarioFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        if ($usuario && isset($usuario['rol']) && $usuario['rol'] === 'admin') {
            return redirect()->to('/Carrito')->with('error', 'Los administradores no pueden realizar compras.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada después
    }
}
