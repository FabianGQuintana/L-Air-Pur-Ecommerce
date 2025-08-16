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

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
});
//Perfil de usuario
$routes->get('/Pages/PerfilUsuario', 'Pages::PerfilUsuario', ['filter' => 'auth']);

//Editar perfil usuario
$routes->get('/Pages/EditarPerfilUsuario', 'UsuarioController::editarPerfil',['filter' => 'auth']);

//Actualizar usuario
$routes->post('/Pages/ActualizarUsuario', 'UsuarioController::actualizarUsuario',['filter' => 'auth']);

// Rutas para Admin
$routes->get('/Admin', 'AdminController::index',['filter' => 'admin']);
$routes->get('/Admin/Productos', 'AdminController::administrarProductos',['filter' => 'admin']);
$routes->get('/Admin', 'AdminController::index',['filter' => 'admin']);
$routes->get('/UsuarioController', 'UsuarioController::index',['filter' => 'admin']);
$routes->get('/Admin/compras', 'AdminController::listarCompras',['filter' => 'admin']);
$routes->get('/Admin/verFactura/(:num)', 'AdminController::verFactura/$1',['filter' => 'admin']);
$routes->get('/Admin/Nuevo', 'AdminController::nuevo',['filter' => 'admin']);
$routes->post('/Admin/Guardar', 'AdminController::guardar',['filter' => 'admin']);
$routes->post('/Admin/Actualizar/(:num)', 'AdminController::actualizar/$1',['filter' => 'admin']);
$routes->get('/Admin/Editar/(:num)', 'AdminController::editar/$1',['filter' => 'admin']);
$routes->get('/Admin/Eliminar/(:num)', 'AdminController::eliminar/$1', ['filter' => 'admin']);
$routes->get('/Admin/Reactivar/(:num)', 'AdminController::reactivar/$1', ['filter' => 'admin']);
$routes->get('/Admin/consultas', 'AdminController::verConsultas',['filter' => 'admin']);
$routes->get('/Admin/responderConsulta/(:segment)/(:num)', 'AdminController::responderConsulta/$1/$2',['filter' => 'admin']);
$routes->get('/admin/nuevaCategoria', 'AdminController::nuevaCategoria',['filter' => 'admin']);
$routes->post('/admin/guardarCategoria', 'AdminController::guardarCategoria',['filter' => 'admin']);
$routes->get('/admin/nuevaMarca', 'AdminController::nuevaMarca',['filter' => 'admin']);
$routes->post('/admin/guardarMarca', 'AdminController::guardarMarca',['filter' => 'admin']);

// Rutas para el carrito de compras
$routes->get('/Carrito', 'CarritoController::index',['filter' => 'auth']);
$routes->post('/Carrito/agregar/(:num)', 'CarritoController::agregar/$1',['filter' => 'auth']);
$routes->get('/Carrito/eliminar/(:num)', 'CarritoController::eliminar/$1',['filter' => 'auth']);
$routes->get('/Carrito/quitar/(:num)', 'CarritoController::quitar/$1',['filter' => 'auth']);
$routes->get('/Carrito/vaciar', 'CarritoController::vaciar',['filter' => 'auth']);
$routes->post('/Carrito/comprar', 'CarritoController::comprar', ['filter' => 'soloUsuario']);
$routes->post('carrito/agregarAjax/(:num)', 'CarritoController::agregarAjax/$1',['filter' => 'auth']);
$routes->post('carrito/quitarAjax/(:num)', 'CarritoController::quitarAjax/$1',['filter' => 'auth']);
$routes->post('carrito/eliminarAjax/(:num)', 'CarritoController::eliminarAjax/$1',['filter' => 'auth']);
$routes->get('carrito/fragmento', 'CarritoController::obtenerFragmentos',['filter' => 'auth']);
$routes->get('/Carrito/confirmacion', 'CarritoController::confirmacion',['filter' => 'auth']);



// Rutas para contacto
$routes->get('/Contact', 'Contact::index');
$routes->post('/Contact/send', 'Contact::send');
$routes->post('Contact/sendConsulta', 'Contact::sendConsulta');

// Rutas para productos
$routes->get('Productos', 'Productos::index');
$routes->get('Productos/new', 'Productos::new', ['filter' => 'admin']);
$routes->post('Productos', 'Productos::create', ['filter' => 'admin']);
$routes->get('Productos/(:num)', 'Productos::show/$1');
$routes->get('Productos/(:num)/edit', 'Productos::edit/$1', ['filter' => 'admin']);
$routes->put('Productos/(:num)', 'Productos::update/$1', ['filter' => 'admin']);
$routes->delete('Productos/(:num)', 'Productos::delete/$1', ['filter' => 'admin']);


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