<?php
require 'application.php';
Logger::getInstance()->log($_SERVER['REQUEST_URI'], Logger::NOTICE);

$router = new Router($_SERVER['REQUEST_URI']);

$router->get('/', array('controller' => 'HomeController', 'action' => 'index'));

$router->get('/home', array('controller' => 'HomeController', 'action' => 'index'));
$router->get('/home/index', array('controller' => 'HomeController', 'action' => 'index'));
$router->get('/home/sobre', array('controller' => 'HomeController', 'action' => 'about'));

$router->get('/fale-conosco', array('controller' => 'ContactsController', 'action' => 'fresh'));
$router->post('/fale-conosco', array('controller' => 'ContactsController', 'action' => 'create'));

$router->get('/cliente/novo', array('controller' => 'ClienteController', 'action' => 'novo'));

/* USERS */
$router->post('/users/new', array('controller' => 'UsersController', 'action' => '_new'));
$router->get('/users/new', array('controller' => 'UsersController', 'action' => '_new'));
$router->post('/users/create', array('controller' => 'UsersController', 'action' => 'create'));
$router->get('/users/create', array('controller' => 'UsersController', 'action' => 'create'));

/* Routas para login e logout */
$router->get('/login', array('controller' => 'SessionsController', 'action' => 'fresh'));
$router->post('/login', array('controller' => 'SessionsController', 'action' => 'create'));
$router->get('/logout', array('controller' => 'SessionsController', 'action' => 'destroy'));

/* MEU PERFIL */
$router->get('/meu-perfil', array('controller' => 'UsersController', 'action' => 'edit'));
$router->post('/meu-perfil', array('controller' => 'UsersController', 'action' => 'update'));

/* CRUD MOTIVOS */
$router->get('/motivos', array('controller' => 'ReasonsController', 'action' => 'index'));
$router->post('/motivos/novo', array('controller' => 'ReasonsController', 'action' => 'create'));
$router->get('/motivos/novo', array('controller' => 'ReasonsController', 'action' => 'fresh'));
$router->get('/motivos/editar/:id', array('controller' => 'ReasonsController', 'action' => 'edit'));
$router->post('/motivos/editar/:id', array('controller' => 'ReasonsController', 'action' => 'update'));
$router->get('/motivos/ver/:id', array('controller' => 'ReasonsController', 'action' => 'show'));
$router->get('/motivos/deletar/:id', array('controller' => 'ReasonsController', 'action' => 'destroy'));

/* CRUD TIPOS DE PRODUTO */
$router->get('/produtos-tipos', array('controller' => 'ProductTypesController', 'action' => 'index'));
$router->post('/produtos-tipos/novo', array('controller' => 'ProductTypesController', 'action' => 'create'));
$router->get('/produtos-tipos/novo', array('controller' => 'ProductTypesController', 'action' => 'fresh'));
$router->get('/produtos-tipos/editar/:id', array('controller' => 'ProductTypesController', 'action' => 'edit'));
$router->post('/produtos-tipos/editar/:id', array('controller' => 'ProductTypesController', 'action' => 'update'));
$router->get('/produtos-tipos/ver/:id', array('controller' => 'ProductTypesController', 'action' => 'show'));
$router->get('/produtos-tipos/deletar/:id', array('controller' => 'ProductTypesController', 'action' => 'destroy'));

/* CRUD PRODUTOS */
$router->get('/produtos', array('controller' => 'ProductsController', 'action' => 'index'));
$router->post('/produtos/novo', array('controller' => 'ProductsController', 'action' => 'create'));
$router->get('/produtos/novo', array('controller' => 'ProductsController', 'action' => 'fresh'));
$router->get('/produtos/editar/:id', array('controller' => 'ProductsController', 'action' => 'edit'));
$router->post('/produtos/editar/:id', array('controller' => 'ProductsController', 'action' => 'update'));
$router->get('/produtos/ver/:id', array('controller' => 'ProductsController', 'action' => 'show'));
$router->get('/produtos/deletar/:id', array('controller' => 'ProductsController', 'action' => 'destroy'));

/* CRUD EMPRESAS */
$router->get('/empresas', array('controller' => 'EnterprisesController', 'action' => 'index'));
$router->post('/empresas/novo', array('controller' => 'EnterprisesController', 'action' => 'create'));
$router->get('/empresas/novo', array('controller' => 'EnterprisesController', 'action' => 'fresh'));
$router->get('/empresas/editar/:id', array('controller' => 'EnterprisesController', 'action' => 'edit'));
$router->post('/empresas/editar/:id', array('controller' => 'EnterprisesController', 'action' => 'update'));
$router->get('/empresas/ver/:id', array('controller' => 'EnterprisesController', 'action' => 'show'));
$router->get('/empresas/deletar/:id', array('controller' => 'EnterprisesController', 'action' => 'destroy'));


/* CRUD TIPOS DE SERVIÇO */
$router->get('/servicos-tipos', array('controller' => 'ServiceTypesController', 'action' => 'index'));
$router->post('/servicos-tipos/novo', array('controller' => 'ServiceTypesController', 'action' => 'create'));
$router->get('/servicos-tipos/novo', array('controller' => 'ServiceTypesController', 'action' => 'fresh'));
$router->get('/servicos-tipos/editar/:id', array('controller' => 'ServiceTypesController', 'action' => 'edit'));
$router->post('/servicos-tipos/editar/:id', array('controller' => 'ServiceTypesController', 'action' => 'update'));
$router->get('/servicos-tipos/ver/:id', array('controller' => 'ServiceTypesController', 'action' => 'show'));
$router->get('/servicos-tipos/deletar/:id', array('controller' => 'ServiceTypesController', 'action' => 'destroy'));

/* CRUD TIPOS DE SERVIÇO */
$router->get('/servicos', array('controller' => 'ServicesController', 'action' => 'index'));
$router->post('/servicos/novo', array('controller' => 'ServicesController', 'action' => 'create'));
$router->get('/servicos/novo', array('controller' => 'ServicesController', 'action' => 'fresh'));
$router->get('/servicos/editar/:id', array('controller' => 'ServicesController', 'action' => 'edit'));
$router->post('/servicos/editar/:id', array('controller' => 'ServicesController', 'action' => 'update'));
$router->get('/servicos/ver/:id', array('controller' => 'ServicesController', 'action' => 'show'));
$router->get('/servicos/deletar/:id', array('controller' => 'ServicesController', 'action' => 'destroy'));


/* CRUD TIPOS DE ACOMODAÇÃO */
$router->get('/acomodacoes-tipos', array('controller' => 'RoomTypesController', 'action' => 'index'));
$router->post('/acomodacoes-tipos/novo', array('controller' => 'RoomTypesController', 'action' => 'create'));
$router->get('/acomodacoes-tipos/novo', array('controller' => 'RoomTypesController', 'action' => 'fresh'));
$router->get('/acomodacoes-tipos/editar/:id', array('controller' => 'RoomTypesController', 'action' => 'edit'));
$router->post('/acomodacoes-tipos/editar/:id', array('controller' => 'RoomTypesController', 'action' => 'update'));
$router->get('/acomodacoes-tipos/ver/:id', array('controller' => 'RoomTypesController', 'action' => 'show'));
$router->get('/acomodacoes-tipos/deletar/:id', array('controller' => 'RoomTypesController', 'action' => 'destroy'));

/* CRUD ACOMODAÇÕES */
$router->get('/acomodacoes', array('controller' => 'RoomsController', 'action' => 'index'));
$router->post('/acomodacoes/novo', array('controller' => 'RoomsController', 'action' => 'create'));
$router->get('/acomodacoes/novo', array('controller' => 'RoomsController', 'action' => 'fresh'));
$router->get('/acomodacoes/editar/:id', array('controller' => 'RoomsController', 'action' => 'edit'));
$router->post('/acomodacoes/editar/:id', array('controller' => 'RoomsController', 'action' => 'update'));
$router->get('/acomodacoes/ver/:id', array('controller' => 'RoomsController', 'action' => 'show'));
$router->get('/acomodacoes/deletar/:id', array('controller' => 'RoomsController', 'action' => 'destroy'));

/* CRUD CLIENTES */
$router->get('/clientes', array('controller' => 'ClientsController', 'action' => 'index'));
$router->post('/clientes/novo', array('controller' => 'ClientsController', 'action' => 'create'));
$router->get('/clientes/novo', array('controller' => 'ClientsController', 'action' => 'fresh'));
$router->get('/clientes/editar/:id', array('controller' => 'ClientsController', 'action' => 'edit'));
$router->post('/clientes/editar/:id', array('controller' => 'ClientsController', 'action' => 'update'));
$router->get('/clientes/ver/:id', array('controller' => 'ClientsController', 'action' => 'show'));
$router->get('/clientes/deletar/:id', array('controller' => 'ClientsController', 'action' => 'destroy'));


$router->load();
?>