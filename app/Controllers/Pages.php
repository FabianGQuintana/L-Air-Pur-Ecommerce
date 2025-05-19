<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // Cargar la página de inicio
        return view('Templates/main_layout', [
            'title' => 'Inicio - L’Air Pur',
            'content' => view('Pages/PaginaPrincipal')
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
}