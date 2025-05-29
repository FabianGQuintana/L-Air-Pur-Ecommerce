<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function login()
    {
        return view('Templates/login_layout', [
        'title' => 'Iniciar sesión',
        'content' => view('/Pages/Auth/Login')
    ]);
    }

public function doLogin()
{
    $session = session();
    $model = new UsuarioModel();

    $email = $this->request->getPost('email');
    $pass = $this->request->getPost('password');
    $remember = $this->request->getPost('remember');

    $usuario = $model->where('email', $email)->first();

    if ($usuario && password_verify($pass, $usuario['password_hash'])) {
        $datosSesion = [
            'id_usuario' => $usuario['id_usuario'],
            'nombre'     => $usuario['nombre'],
            'apellido'   => $usuario['apellido'],
            'telefono'   => $usuario['telefono'],
            'email'      => $usuario['email']
        ];
        $session->set('usuario_logueado', $datosSesion);

        // // Si el usuario quiere que lo recuerden
        // if ($remember) {
        //     helper('cookie');
        //     set_cookie('remember_email', $email, 60*60*24*30); // 30 días
        // } else {
        //     delete_cookie('remember_email');
        // }

        return redirect()->to('/')->with('success', '¡Inicio de sesión exitoso!');
    } else {
        return redirect()->back()->with('error', 'Email o contraseña incorrectos');
    }
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
    $session = session();
    $model = new UsuarioModel();

    $nombre = $this->request->getPost('nombre');
    $apellido = $this->request->getPost('apellido');
    $email = $this->request->getPost('email');
    $emailConfirmar = $this->request->getPost('emailConfirmar');
    $telefono = $this->request->getPost('telefono');
    $password = $this->request->getPost('password_hash');
    $passwordConfirmar = $this->request->getPost('passwordConfirmar');

    // Validaciones
    if ($email !== $emailConfirmar) {
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Los correos electrónicos no coinciden.');
    }

    if ($password !== $passwordConfirmar) {
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Las contraseñas no coinciden.');
    }

    // Verifica si el email ya está registrado
    if ($model->where('email', $email)->first()) {
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'El correo electrónico ya está registrado.');
    }

    // Inserta el nuevo usuario
    $data = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'telefono' => $telefono,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT)
    ];

    $model->insert($data);

    return redirect()->to('/Auth/Login')->with('success', 'Usuario registrado correctamente');
}


}