<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $busqueda = $this->request->getGet('busqueda');

        if ($busqueda) {
            $usuarios = $usuarioModel->like('nombre', $busqueda)
                                    ->orLike('apellido', $busqueda)
                                    ->orLike('email', $busqueda)
                                    ->findAll();
        } else {
            $usuarios = $usuarioModel->findAll();
        }

        return view('Templates/admin_layout', [
            'title' => 'Lista de Usuarios',
            'content' => view('Pages/UsuariosList', [
                'usuarios' => $usuarios,
                'busqueda' => $busqueda
            ])
        ]);
    }

    public function login()
    {
        return view('Templates/login_layout', [
            'title' => 'Iniciar sesión',
            'content' => view('/Pages/Auth/Login')
        ]);
    }

    public function doLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        $messages = [
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, introduce un correo electrónico válido.'
            ],
            'password' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 6 caracteres.'
            ]
        ];

            if (! $this->validate($rules, $messages)) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            $session = session();
            $model = new UsuarioModel();
            $email = $this->request->getPost('email');
            $pass = $this->request->getPost('password');

            $usuario = $model->where('email', $email)->first();

            if ($usuario && password_verify($pass, $usuario['password_hash'])) {
            $session->set('usuario_logueado', [
            'id_usuario' => $usuario['id_usuario'],
            'nombre'     => $usuario['nombre'],
            'apellido'   => $usuario['apellido'],
            'telefono'   => $usuario['telefono'],
            'email'      => $usuario['email'],
            'rol'        => $usuario['rol']
        ]);

        // Redirección condicional según rol
        if ($usuario['rol'] === 'admin') {
            return redirect()->to('/Admin')->with('success', '¡Bienvenido, administrador!');
        } else {
            return redirect()->to('/')->with('success', '¡Inicio de sesión exitoso!');
        }
    }


        return redirect()->back()->withInput()->with('error', 'Email o contraseña incorrectos');
    }

    public function register()
    {
        return view('Templates/login_layout', [
            'title' => 'Registrarse',
            'content' => view('/Pages/Auth/Register')
        ]);
    }

    public function doRegister()
    {
        $rules = [
            'nombre' => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'apellido' => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'telefono'          => 'permit_empty|regex_match[/^[0-9\-\s\(\)]+$/]',
            'email'             => 'required|valid_email|is_unique[usuarios.email]',
            'emailConfirmar'    => 'required|matches[email]',
            'password_hash'     => 'required|min_length[6]',
            'passwordConfirmar' => 'required|matches[password_hash]'
        ];

        $messages = [
            'nombre' => [
                'required'    => 'El nombre es obligatorio.',
                'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
                'regex_match' => 'El nombre debe estar compuesto por letras'
            ],
            'apellido' => [
                'required'    => 'El apellido es obligatorio.',
                'min_length'  => 'El apellido debe tener al menos 3 caracteres.',
                'regex_match' => 'El apellido debe estar compuesto por letras'
            ],
            'telefono' => [
                'regex_match' => 'El teléfono solo puede contener números, espacios y paréntesis.'
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, introduce un correo electrónico válido.',
                'is_unique'   => 'Este correo ya esta registrado, Por favor ingrese nuevo nuevo.'
            ],
            'emailConfirmar' => [
                'required' => 'Debes confirmar el correo.',
                'matches'  => 'Los correos electrónicos no coinciden.'
            ],
            'password_hash' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
            ],
            'passwordConfirmar' => [
                'required' => 'Debes confirmar la contraseña.',
                'matches'  => 'Las contraseñas no coinciden.'
            ]
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new UsuarioModel();
        $email = $this->request->getPost('email');

        $data = [
            'nombre'   => ucfirst(strtolower($this->request->getPost('nombre'))),
            'apellido' => ucfirst(strtolower($this->request->getPost('apellido'))),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $email,
            'password_hash' => password_hash($this->request->getPost('password_hash'), PASSWORD_DEFAULT)
        ];

        $model->insert($data);
        return redirect()->to('/Auth/Login')->with('success', 'Usuario registrado correctamente');
    }

    public function perfil()
    {
        $usuario = session('usuario_logueado');

        return view('Templates/main_layout', [
            'title' => 'Mi Perfil',
            'content' => view('Pages/PerfilUsuario', ['usuario' => $usuario])
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/Auth/Login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function editarPerfil()
    {
        $usuario = session('usuario_logueado');

        if (!$usuario) {
            return redirect()->to('/Auth/Login');
        }

        return view('Templates/main_layout', [
            'title'   => 'Editar Perfil',
            'content' => view('Pages/EditarPerfilUsuario', ['usuario' => $usuario])
        ]);
    }


        public function actualizarUsuario()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        // Protección de acceso: si no hay sesión, redirigir
        if (!$usuario) {
            return redirect()->to('/Auth/Login');
        }

        // ✅ Validación de los datos recibidos
        $rules = [
            'nombre'   => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'apellido' => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'telefono' => 'permit_empty|regex_match[/^[0-9\-\s\(\)]+$/]'
        ];

        $messages = [
            'nombre' => [
                'required'    => 'El nombre es obligatorio.',
                'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
                'regex_match' => 'El nombre solo puede contener letras y espacios.'
            ],
            'apellido' => [
                'required'    => 'El apellido es obligatorio.',
                'min_length'  => 'El apellido debe tener al menos 3 caracteres.',
                'regex_match' => 'El apellido solo puede contener letras y espacios.'
            ],
            'telefono' => [
                'regex_match' => 'El teléfono solo puede contener números, espacios y paréntesis.'
            ]
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // ✅ Si pasó la validación, procesar los datos
        $model = new \App\Models\UsuarioModel();

        $data = [
            'nombre'   => ucfirst(strtolower($this->request->getPost('nombre'))),
            'apellido' => ucfirst(strtolower($this->request->getPost('apellido'))),
            'telefono' => $this->request->getPost('telefono')
        ];

        $model->update($usuario['id_usuario'], $data);

        // Actualizar datos en la sesión
        $usuario = array_merge($usuario, $data);
        $session->set('usuario_logueado', $usuario);

        return redirect()->to('/Pages/PerfilUsuario')->with('success', 'Perfil actualizado correctamente');
    }



}
