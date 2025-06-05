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
        $usuario = session('usuario_logueado');

        $data = [
            'title' => 'Perfil de Usuario - L’Air Pur',
            'content' => view('Pages/PerfilUsuario', ['usuario' => $usuario])
        ];

        return view('Templates/main_layout', $data);
    }


}