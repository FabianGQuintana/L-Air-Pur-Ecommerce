<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LoginController extends BaseController
{
public function index()
{
    return view('Templates/login_layout', [
        'title' => 'Iniciar sesión',
        'content' => view('/Pages/Auth/Login')
    ]);
}


    public function auth()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Ejemplo simple de validación
        if ($email === 'admin@lairpur.com' && $password === '123456') {
            session()->set('isLoggedIn', true);
            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Usuario Incorrecto');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/Login');
    }
}
