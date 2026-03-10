<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas para Alumnos
$routes->get('/alumnos', 'Alumnos::index');
$routes->get('/alumnos/create', 'Alumnos::create');
$routes->post('/alumnos/store', 'Alumnos::store');
$routes->get('/alumnos/show/(:num)', 'Alumnos::show/$1');
$routes->get('/alumnos/edit/(:num)', 'Alumnos::edit/$1');
$routes->post('/alumnos/update/(:num)', 'Alumnos::update/$1');
$routes->get('/alumnos/delete/(:num)', 'Alumnos::delete/$1');

// Rutas para Docentes
$routes->get('/docentes', 'Docentes::index');
$routes->get('/docentes/create', 'Docentes::create');
$routes->post('/docentes/store', 'Docentes::store');
$routes->get('/docentes/show/(:num)', 'Docentes::show/$1');
$routes->get('/docentes/edit/(:num)', 'Docentes::edit/$1');
$routes->post('/docentes/update/(:num)', 'Docentes::update/$1');
$routes->get('/docentes/delete/(:num)', 'Docentes::delete/$1');
$routes->get('/docentes/(:num)/materias', 'Horario::materiasPorDocente/$1');

// Rutas para Carreras
$routes->get('/carreras', 'Carreras::index');
$routes->get('/carreras/create', 'Carreras::create');
$routes->post('/carreras/store', 'Carreras::store');
$routes->get('/carreras/show/(:num)', 'Carreras::show/$1');
$routes->get('/carreras/edit/(:num)', 'Carreras::edit/$1');
$routes->post('/carreras/update/(:num)', 'Carreras::update/$1');
$routes->get('/carreras/delete/(:num)', 'Carreras::delete/$1');

// Rutas para Horarios (Inscripción de Docentes)
$routes->get('/horarios', 'Horario::index');
$routes->get('/horarios/create', 'Horario::create');
$routes->post('/horarios/store', 'Horario::store');
$routes->get('/horarios/show/(:num)', 'Horario::show/$1');
$routes->get('/horarios/edit/(:num)', 'Horario::edit/$1');
$routes->post('/horarios/update/(:num)', 'Horario::update/$1');
$routes->get('/horarios/delete/(:num)', 'Horario::delete/$1');

// Rutas para Materias
$routes->get('/materias', 'Home::materias');
$routes->get('/materias/(:num)/alumnos', 'Home::alumnosPorMateria/$1');

// Rutas para Asignación Alumno-Carrera
$routes->get('/alumno_carrera', 'AlumnoCarrera::index');
$routes->get('/alumno_carrera/create', 'AlumnoCarrera::create');
$routes->post('/alumno_carrera/store', 'AlumnoCarrera::store');
$routes->get('/alumno_carrera/show/(:num)', 'AlumnoCarrera::show/$1');
$routes->get('/alumno_carrera/edit/(:num)', 'AlumnoCarrera::edit/$1');
$routes->post('/alumno_carrera/update/(:num)', 'AlumnoCarrera::update/$1');
$routes->get('/alumno_carrera/delete/(:num)', 'AlumnoCarrera::delete/$1');
