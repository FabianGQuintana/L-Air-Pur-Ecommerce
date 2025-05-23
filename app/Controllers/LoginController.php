<?php

// namespace App\Controllers;

// use CodeIgniter\Controller;

// class LoginController extends BaseController
// {
// public function index()
// {
//     return view('Templates/login_layout', [
//         'title' => 'Iniciar sesión',
//         'content' => view('/Pages/Auth/Login')
//     ]);
// }


//     public function auth()
//     {
//         $email = $this->request->getPost('email');
//         $password = $this->request->getPost('password');

//         // Ejemplo simple de validación
//         if ($email === 'admin@lairpur.com' && $password === '123456') {
//             session()->set('isLoggedIn', true);
//             return redirect()->to('/');
//         }

//         return redirect()->back()->with('error', 'Usuario Incorrecto');
//     }

//     public function logout()
//     {
//         session()->destroy();
//         return redirect()->to('/Login');
//     }
// }

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

        $usuario = $model->where('email', $email)->first();

        if ($usuario && password_verify($pass, $usuario['password'])) {
            $session->set('usuario_logueado', [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email']
            ]);
            return redirect()->to('/dashboard');
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
        $model = new UsuarioModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->insert($data);

        return redirect()->to('/Auth/Login')->with('success', 'Usuario registrado correctamente');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/Auth/Login');
    }
}