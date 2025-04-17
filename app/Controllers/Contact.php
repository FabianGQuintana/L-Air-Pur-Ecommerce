<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        // Cargar la página de contacto
        return view('Templates/main_layout', [
            'title' => 'Contacto - Mi Tienda',
            'content' => view('Pages/Contactos')
        ]);
    }
    
    public function send()
    {
        // Validar el formulario
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, mostrar errores
            return view('Templates/main_layout', [
                'title' => 'Contacto - Mi Tienda',
                'content' => view('Pages/Contactos', [
                    'validation' => $this->validator
                ])
            ]);
        }
        
        // Procesar el formulario (en una implementación completa,
        // aquí se enviaría un email)
        
        // Redirigir con mensaje de éxito
        return redirect()->to('/Contactos')->with('message',
            'Gracias por contactarnos. Te responderemos a la brevedad.');
    }
}