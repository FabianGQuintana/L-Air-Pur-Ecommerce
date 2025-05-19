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

// Ruta para el login de usuarios
$routes->get('/Auth/Login', 'LoginController::index');
$routes->post('/Auth/Login', 'LoginController::auth');
$routes->get('/logout', 'LoginController::logout');



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