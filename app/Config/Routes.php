<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas de páginas estáticas
$routes->get('/', 'Pages::index');
$routes->get('/QuienesSomos', 'Pages::QuienesSomos');
$routes->get('/Comercializacion', 'Pages::Comercializacion');
$routes->get('/TerminosYCondiciones', 'Pages::TerminosYCondiciones');
$routes->get('/EnConstruccion', 'Pages::EnConstruccion');

//Rutas para Registrar&Loguearse
$routes->get('/Auth/Login', 'UsuarioController::login');
$routes->post('/Auth/doLogin', 'UsuarioController::doLogin');
$routes->get('/Auth/Register', 'UsuarioController::register');
$routes->post('/Auth/doRegister', 'UsuarioController::doRegister');
$routes->get('/Logout', 'UsuarioController::logout');

$routes->resource('UsuarioController', ['placeholder' => '(:num)']);

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
});
//Perfil de usuario
$routes->get('/Pages/PerfilUsuario', 'Pages::PerfilUsuario', ['filter' => 'auth']);

//Editar perfil usuario
$routes->get('/Pages/EditarPerfilUsuario', 'UsuarioController::editarPerfil');


//Actualizar usuario
$routes->post('/Pages/ActualizarUsuario', 'UsuarioController::actualizarUsuario');



// Rutas para Admin
$routes->get('/Admin', 'AdminController::index',['filter' => 'admin']);
$routes->get('/Admin/Productos', 'AdminController::administrarProductos',['filter' => 'admin']);

// Rutas para el carrito de compras
$routes->get('/Carrito', 'CarritoController::index',['filter' => 'auth']);
$routes->post('/Carrito/agregar/(:num)', 'CarritoController::agregar/$1',['filter' => 'auth']);
$routes->get('/Carrito/eliminar/(:num)', 'CarritoController::eliminar/$1',['filter' => 'auth']);
$routes->get('/Carrito/quitar/(:num)', 'CarritoController::quitar/$1',['filter' => 'auth']);
$routes->get('/Carrito/vaciar', 'CarritoController::vaciar',['filter' => 'auth']);

$routes->post('carrito/agregarAjax/(:num)', 'CarritoController::agregarAjax/$1',['filter' => 'auth']);
$routes->post('carrito/quitarAjax/(:num)', 'CarritoController::quitarAjax/$1',['filter' => 'auth']);
$routes->post('carrito/eliminarAjax/(:num)', 'CarritoController::eliminarAjax/$1',['filter' => 'auth']);
$routes->get('carrito/fragmento', 'CarritoController::obtenerFragmentos',['filter' => 'auth']);



// Rutas para contacto
$routes->get('/Contact', 'Contact::index');
$routes->post('/Contact/send', 'Contact::send');

// Rutas para productos
$routes->resource('Productos', ['placeholder' => '(:num)']);

// Establecer controlador por defecto
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');


// Manejo de 404 personalizado
$routes->set404Override(function() {
    return view('Templates/main_layout', [
        'title' => 'Página no encontrada - L’Air Pur',
        'content' => view('errors/custom_404')
    ]);
});