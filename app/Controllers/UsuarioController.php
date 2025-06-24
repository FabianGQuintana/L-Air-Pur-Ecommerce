<?php

/**
 * Controlador de usuarios del sistema.
 * Maneja el registro, login, perfil, edición y visualización de usuarios.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    /**
     * Muestra la lista de usuarios.
     * Permite filtrar por nombre, apellido o email mediante parámetro `busqueda`.
     */
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

    /**
     * Muestra la vista de inicio de sesión.
     */
    public function login()
    {
        return view('Templates/login_layout', [
            'title' => 'Iniciar sesión',
            'content' => view('/Pages/Auth/Login')
        ]);
    }

    /**
     * Procesa el formulario de inicio de sesión.
     * Valida las credenciales, inicia sesión y redirige según el rol del usuario.
     */
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

            return ($usuario['rol'] === 'admin')
                ? redirect()->to('/Admin')->with('success', '¡Bienvenido, administrador!')
                : redirect()->to('/')->with('success', '¡Inicio de sesión exitoso!');
        }

        return redirect()->back()->withInput()->with('error', 'Email o contraseña incorrectos');
    }

    /**
     * Muestra la vista de registro de usuario.
     */
    public function register()
    {
        return view('Templates/login_layout', [
            'title' => 'Registrarse',
            'content' => view('/Pages/Auth/Register')
        ]);
    }

    /**
     * Procesa el formulario de registro.
     * Valida los campos, verifica unicidad de email y guarda un nuevo usuario.
     */
    public function doRegister()
    {
        $rules = [
            'nombre'            => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'apellido'          => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
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
                'is_unique'   => 'Este correo ya está registrado, por favor ingrese uno nuevo.'
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

        $telefono = $this->request->getPost('telefono');
        $soloDigitos = preg_replace('/\D/', '', $telefono);

        if (!empty($telefono) && strlen($soloDigitos) < 10) {
            $this->validator->setError('telefono', 'El número de teléfono debe tener al menos 10 dígitos reales.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new UsuarioModel();
        $email = $this->request->getPost('email');

        $data = [
            'nombre'        => $this->capitalizarNombreCompleto($this->request->getPost('nombre')),
            'apellido'      => $this->capitalizarNombreCompleto($this->request->getPost('apellido')),
            'telefono'      => $telefono,
            'email'         => $email,
            'password_hash' => password_hash($this->request->getPost('password_hash'), PASSWORD_DEFAULT)
        ];

        $model->insert($data);
        return redirect()->to('/Auth/Login')->with('success', 'Usuario registrado correctamente');
    }

    /**
     * Muestra el perfil del usuario logueado.
     */
    public function perfil()
    {
        $usuario = session('usuario_logueado');

        return view('Templates/main_layout', [
            'title'   => 'Mi Perfil',
            'content' => view('Pages/PerfilUsuario', ['usuario' => $usuario])
        ]);
    }

    /**
     * Cierra la sesión del usuario actual.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/Auth/Login')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Muestra el formulario para editar los datos del perfil del usuario logueado.
     */
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

    /**
     * Procesa la actualización de datos del usuario logueado.
     * Permite cambiar nombre, apellido, teléfono, email y contraseña.
     * Actualiza también los datos en la sesión.
     */
    public function actualizarUsuario()
    {
        $session = session();
        $usuario = $session->get('usuario_logueado');

        if (!$usuario) {
            return redirect()->to('/Auth/Login');
        }

        $rules = [
            'nombre'                => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'apellido'              => 'required|min_length[3]|regex_match[/^[\p{L}\s]+$/u]',
            'telefono'              => 'permit_empty|regex_match[/^[0-9\-\s\(\)]+$/]',
            'email'                 => 'required|valid_email|is_unique[usuarios.email,id_usuario,{id_usuario}]',
            'nueva_contrasena'      => 'permit_empty|min_length[6]',
            'confirmar_contrasena'  => 'matches[nueva_contrasena]'
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
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debe ingresar un correo electrónico válido.',
                'is_unique'   => 'Este correo ya está en uso por otro usuario.'
            ],
            'nueva_contrasena' => [
                'min_length' => 'La nueva contraseña debe tener al menos 6 caracteres.'
            ],
            'confirmar_contrasena' => [
                'matches' => 'La confirmación de la contraseña no coincide.'
            ]
        ];

        // Reemplaza el marcador {id_usuario} por el ID actual (evita conflicto con su propio email)
        $rules['email'] = str_replace('{id_usuario}', $usuario['id_usuario'], $rules['email']);

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $telefono = $this->request->getPost('telefono');
        $soloDigitos = preg_replace('/\D/', '', $telefono);
        if (!empty($telefono) && strlen($soloDigitos) < 10) {
            $this->validator->setError('telefono', 'El número de teléfono debe tener al menos 10 dígitos reales.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new UsuarioModel();

        $data = [
            'nombre'   => $this->capitalizarNombreCompleto($this->request->getPost('nombre')),
            'apellido' => $this->capitalizarNombreCompleto($this->request->getPost('apellido')),
            'telefono' => $telefono,
            'email'    => $this->request->getPost('email')
        ];

        $newPassword = $this->request->getPost('new_password');
        if (!empty($newPassword)) {
            $data['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $model->update($usuario['id_usuario'], $data);

        // Actualizar sesión
        unset($data['password_hash']); // No guardamos la contraseña en sesión
        $usuario = array_merge($usuario, $data);
        $session->set('usuario_logueado', $usuario);

        return redirect()->to('/Pages/PerfilUsuario')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Capitaliza correctamente nombres y apellidos.
     * Convierte a minúscula y luego pone la primera letra de cada palabra en mayúscula.
     * 
     * @param string $texto Texto a capitalizar.
     * @return string Texto capitalizado.
     */
    private function capitalizarNombreCompleto(string $texto): string
    {
        return preg_replace_callback('/\b[\p{L}\'\-]+/u', function ($coincidencia) {
            return mb_convert_case($coincidencia[0], MB_CASE_TITLE, "UTF-8");
        }, mb_strtolower($texto, 'UTF-8'));
    }
}
