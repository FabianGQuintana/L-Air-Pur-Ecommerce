<?php

namespace App\Controllers;

use App\Models\ContactoModel;
use App\Models\ConsultasModel;
use CodeIgniter\Controller;

/**
 * Controlador para gestionar el formulario de contacto público
 * y las consultas realizadas por usuarios logueados.
 *
 * Este controlador incluye métodos para:
 * - Mostrar el formulario de contacto.
 * - Validar y guardar mensajes de contacto de visitantes.
 * - Validar y guardar consultas de usuarios registrados.
 */
class Contact extends BaseController
{
    /**
     * Muestra la vista principal de contacto.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        $formulario = $usuario
            ? view('Components/Form_Consulta')
            : view('Components/Form_Contacto');

        return view('Templates/main_layout', [
            'title' => 'Contacto - Mi Tienda',
            'content' => view('Pages/Contactos', [
                'formulario' => $formulario
            ])
        ]);
    }

    /**
     * Procesa y guarda el formulario de contacto público (usuarios no logueados).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function send()
    {
        if (!$this->validate($this->getContactoRules(), $this->getContactoMessages())) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = $this->getFormDataContacto();
        $this->guardarContacto($data);

        return redirect()->to('/Contact')
                         ->with('message', 'Gracias por contactarnos. Te responderemos a la brevedad.');
    }

    /**
     * Procesa y guarda una consulta realizada por un usuario logueado.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function sendConsulta()
    {
        if (!$this->validate($this->getConsultaRules(), $this->getConsultaMessages())) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $session = session();
        $usuario = $session->get('usuario_logueado');

        if (!$usuario || !isset($usuario['id_usuario'])) {
            return redirect()->to('/Auth/Login')->with('error', 'Debes iniciar sesión para enviar una consulta.');
        }

        $data = [
            'id_usuario' => $usuario['id_usuario'],
            'fecha_hora' => date('Y-m-d H:i:s'),
            'asunto'     => $this->request->getPost('asunto'),
            'mensaje'    => $this->request->getPost('mensaje'),
            'estado'     => 'Sin Responder'
        ];

        $this->guardarConsulta($data);

        return redirect()->to('/Contact')
                         ->with('message', 'Tu consulta fue enviada correctamente.');
    }

    /**
     * Reglas de validación para el formulario de contacto público.
     *
     * @return array
     */
    private function getContactoRules()
    {
        return [
            'name'    => 'required|min_length[3]',
            'email'   => 'required|valid_email',
            'phone'   => 'required|regex_match[/^[0-9\-\s\(\)]+$/]',
            'message' => 'required|min_length[10]',
        ];
    }

    /**
     * Mensajes personalizados de validación para el formulario de contacto.
     *
     * @return array
     */
    private function getContactoMessages()
    {
        return [
            'name' => [
                'required'   => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.'
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, introduce un correo electrónico válido.'
            ],
            'phone' => [
                'required'    => 'El teléfono es obligatorio.',
                'regex_match' => 'El teléfono solo puede contener números, espacios y paréntesis.'
            ],
            'message' => [
                'required'   => 'El mensaje es obligatorio.',
                'min_length' => 'El mensaje debe tener al menos 10 caracteres.',
            ]
        ];
    }

    /**
     * Reglas de validación para el formulario de consulta de usuario logueado.
     *
     * @return array
     */
    private function getConsultaRules()
    {
        return [
            'asunto'  => 'required|min_length[3]',
            'mensaje' => 'required|min_length[10]'
        ];
    }

    /**
     * Mensajes personalizados para validación de consultas de usuarios.
     *
     * @return array
     */
    private function getConsultaMessages()
    {
        return [
            'asunto' => [
                'required'   => 'El asunto es obligatorio.',
                'min_length' => 'El asunto debe tener al menos 3 caracteres.'
            ],
            'mensaje' => [
                'required'   => 'El mensaje es obligatorio.',
                'min_length' => 'El mensaje debe tener al menos 10 caracteres.'
            ]
        ];
    }

    /**
     * Extrae los datos del formulario de contacto desde el `POST`.
     *
     * @return array
     */
    private function getFormDataContacto()
    {
        return [
            'nombre'     => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'telefono'   => $this->request->getPost('phone'),
            'mensaje'    => $this->request->getPost('message'),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'estado'     => 'Sin Responder'
        ];
    }

    /**
     * Inserta en la base de datos un nuevo mensaje de contacto.
     *
     * @param array $data
     * @return void
     */
    private function guardarContacto($data)
    {
        $contactoModel = new ContactoModel();
        $contactoModel->insert($data);
    }

    /**
     * Inserta en la base de datos una nueva consulta de usuario logueado.
     *
     * @param array $data
     * @return void
     */
    private function guardarConsulta($data)
    {
        $consultasModel = new ConsultasModel();
        $consultasModel->insert($data);
    }
}
