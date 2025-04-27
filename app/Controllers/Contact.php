<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Services;

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
        // Reglas de validación
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|regex_match[/^[0-9\-\s\(\)]+$/]',
            'message' => 'required|min_length[10]'
        ];

        // Mensajes de error personalizados
        $messages = [
            'name' => [
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.'
            ],
            'email' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, introduce un correo electrónico válido.'
            ],
            'phone' => [
                'required' => 'El teléfono es obligatorio.',
                'regex_match' => 'El teléfono solo puede contener números, espacios y paréntesis.'
            ],
            'message' => [
                'required' => 'El mensaje es obligatorio.',
                'min_length' => 'El mensaje debe tener al menos 10 caracteres.'
            ]
        ];

        // Validación
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }
        
        // Capturar datos
        $name    = $this->request->getPost('name');
        $email   = $this->request->getPost('email');
        $phone   = $this->request->getPost('phone');
        $message = $this->request->getPost('message');

        // Configurar y enviar el email
        $emailService = Services::email();

        $emailService->setFrom(env('email.fromEmail'), env('email.fromName'));
        $emailService->setTo('l.air.purr@gmail.com'); // El correo que recibe el mensaje

        $emailService->setSubject('Nuevo mensaje de contacto');

        $emailContent = "
            <h2>Nuevo mensaje de contacto</h2>
            <p><strong>Nombre:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Teléfono:</strong> {$phone}</p>
            <p><strong>Mensaje:</strong><br>{$message}</p>
        ";

        $emailService->setMessage($emailContent);

        if (!$emailService->send()) {
            // Si falla el envío
            return view('Templates/main_layout', [
                'title' => 'Contacto - Mi Tienda',
                'content' => view('Pages/Contactos', [
                    'validation' => $this->validator,
                    'email_error' => $emailService->printDebugger(['headers'])
                ])
            ]);
        }

        // Si la validación pasa, podrías enviar email, guardar en base, etc.
    
        return redirect()->to('/Contact')
                         ->with('message', 'Gracias por contactarnos. Te responderemos a la brevedad.');
    }
}
