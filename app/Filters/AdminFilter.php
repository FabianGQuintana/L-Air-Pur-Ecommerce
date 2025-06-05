<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

    // Verificar si está logueado
    if (!$session->get('usuario_logueado')) {
        // No está logueado → redirigir al login
        return redirect()->to('/Auth/Login');
    }

    // Verificar rol
    $usuario = $session->get('usuario_logueado');
    if (!isset($usuario['rol']) || $usuario['rol'] !== 'admin') {
        // No tiene rol admin → enviar flashdata con mensaje y redirigir a Home
        $session->setFlashdata('error', 'Acceso Denegado. No tienes permisos para acceder a esta sección.');
        return redirect()->to('/');
    }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere acción después
    }
}
