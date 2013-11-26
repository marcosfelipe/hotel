<?php
require 'application.php';
Logger::getInstance()->log($_SERVER['REQUEST_URI'], Logger::NOTICE);

$router = new Router($_SERVER['REQUEST_URI']);

$router->get('/', array('controller' => 'HomeController', 'action' => 'index'));

$router->get('/home', array('controller' => 'HomeController', 'action' => 'index'));
$router->get('/sobre', array('controller' => 'HomeController', 'action' => 'about'));

$router->get('/fale-conosco', array('controller' => 'ContactsController', 'action' => 'fresh'));
$router->post('/fale-conosco', array('controller' => 'ContactsController', 'action' => 'create'));

/* USERS */
$router->post('/users/new', array('controller' => 'UsersController', 'action' => '_new'));
$router->get('/users/new', array('controller' => 'UsersController', 'action' => '_new'));
$router->post('/users/create', array('controller' => 'UsersController', 'action' => 'create'));
$router->get('/users/create', array('controller' => 'UsersController', 'action' => 'create'));

/* Routas para login e logout */
$router->get('/login', array('controller' => 'SessionsController', 'action' => 'fresh'));
$router->post('/login', array('controller' => 'SessionsController', 'action' => 'create'));
$router->get('/nova-senha', array('controller' => 'SessionsController', 'action' => 'newPassword'));
$router->post('/nova-senha', array('controller' => 'SessionsController', 'action' => 'createPassword'));
$router->get('/logout', array('controller' => 'SessionsController', 'action' => 'destroy'));

/* MEU PERFIL */
$router->get('/meu-perfil', array('controller' => 'UsersController', 'action' => 'edit'));
$router->post('/meu-perfil', array('controller' => 'UsersController', 'action' => 'update'));
$router->get('/mudar-senha', array('controller' => 'UsersController', 'action' => 'changePassword'));

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

/* SERVIÇOS */
$router->get('/servicos', array('controller' => 'ServicesController', 'action' => 'index'));
$router->get('/servicos/historico', array('controller' => 'ServicesController', 'action' => 'history'));
$router->post('/servicos/historico', array('controller' => 'ServicesController', 'action' => 'history'));
$router->get('/servicos/novo/:id', array('controller' => 'ServicesController', 'action' => 'fresh'));
$router->post('/servicos/novo/:id', array('controller' => 'ServicesController', 'action' => 'create'));
$router->get('/servicos/ver/:id', array('controller' => 'ServicesController', 'action' => 'show'));
$router->get('/servicos/deletar/:id', array('controller' => 'ServicesController', 'action' => 'destroy'));


/* CRUD TIPOS DE ACOMODAÇÃO */
$router->get('/acomodacoes-tipos', array('controller' => 'RoomTypesController', 'action' => 'index'));
$router->post('/acomodacoes-tipos/novo', array('controller' => 'RoomTypesController', 'action' => 'create'));
$router->get('/acomodacoes-tipos/novo', array('controller' => 'RoomTypesController', 'action' => 'fresh'));
$router->get('/acomodacoes-tipos/editar/:id', array('controller' => 'RoomTypesController', 'action' => 'edit'));
$router->post('/acomodacoes-tipos/editar/:id', array('controller' => 'RoomTypesController', 'action' => 'update'));
$router->get('/acomodacoes-tipos/ver/:id', array('controller' => 'RoomTypesController', 'action' => 'show'));
$router->post('/acomodacoes-tipos/preco/:id', array('controller' => 'RoomTypesController', 'action' => 'getTypePrice'));
$router->get('/acomodacoes-tipos/deletar/:id', array('controller' => 'RoomTypesController', 'action' => 'destroy'));

/* CRUD ACOMODAÇÕES */
$router->get('/acomodacoes', array('controller' => 'RoomsController', 'action' => 'index'));
$router->get('/acomodacoes/lista', array('controller' => 'RoomsController', 'action' => 'listing'));
$router->post('/acomodacoes/novo', array('controller' => 'RoomsController', 'action' => 'create'));
$router->get('/acomodacoes/novo', array('controller' => 'RoomsController', 'action' => 'fresh'));
$router->get('/acomodacoes/editar/:id', array('controller' => 'RoomsController', 'action' => 'edit'));
$router->post('/acomodacoes/editar/:id', array('controller' => 'RoomsController', 'action' => 'update'));
$router->get('/acomodacoes/ver/:id', array('controller' => 'RoomsController', 'action' => 'show'));
$router->get('/acomodacoes/detalhes/:id', array('controller' => 'RoomsController', 'action' => 'details'));
$router->get('/acomodacoes/deletar/:id', array('controller' => 'RoomsController', 'action' => 'destroy'));
$router->get('/acomodacoes/verificar/:id', array('controller' => 'RoomsController', 'action' => 'verify'));

/* FOTOS DAS ACOMODAÇÕES */
$router->post('/acomodacao-photo/create/:id', array('controller' => 'RoomPhotosController', 'action' => 'create'));
$router->post('/acomodacao-photo/deletar/:id', array('controller' => 'RoomPhotosController', 'action' => 'destroy'));

/* CRUD CLIENTES */
$router->get('/clientes', array('controller' => 'ClientsController', 'action' => 'index'));
$router->post('/clientes/novo', array('controller' => 'ClientsController', 'action' => 'create'));
$router->get('/clientes/novo', array('controller' => 'ClientsController', 'action' => 'fresh'));
$router->get('/clientes/editar/:id', array('controller' => 'ClientsController', 'action' => 'edit'));
$router->post('/clientes/editar/:id', array('controller' => 'ClientsController', 'action' => 'update'));
$router->get('/clientes/ver/:id', array('controller' => 'ClientsController', 'action' => 'show'));
$router->get('/clientes/deletar/:id', array('controller' => 'ClientsController', 'action' => 'destroy'));

/* CRUD FUNCIONÁRIOS */
$router->get('/funcionarios', array('controller' => 'EmployeesController', 'action' => 'index'));
$router->post('/funcionarios/novo', array('controller' => 'EmployeesController', 'action' => 'create'));
$router->get('/funcionarios/novo', array('controller' => 'EmployeesController', 'action' => 'fresh'));
$router->get('/funcionarios/editar/:id', array('controller' => 'EmployeesController', 'action' => 'edit'));
$router->post('/funcionarios/editar/:id', array('controller' => 'EmployeesController', 'action' => 'update'));
$router->get('/funcionarios/ver/:id', array('controller' => 'EmployeesController', 'action' => 'show'));
$router->get('/funcionarios/deletar/:id', array('controller' => 'EmployeesController', 'action' => 'destroy'));
$router->get('/funcionarios/restabelecer-senha/:id', array('controller' => 'EmployeesController', 'action' => 'resetPassword'));

/* CRUD TIPOS DE PAGAMENTO S*/
$router->get('/pagamentos-tipos', array('controller' => 'PaymentTypesController', 'action' => 'index'));
$router->post('/pagamentos-tipos/novo', array('controller' => 'PaymentTypesController', 'action' => 'create'));
$router->get('/pagamentos-tipos/novo', array('controller' => 'PaymentTypesController', 'action' => 'fresh'));
$router->get('/pagamentos-tipos/editar/:id', array('controller' => 'PaymentTypesController', 'action' => 'edit'));
$router->post('/pagamentos-tipos/editar/:id', array('controller' => 'PaymentTypesController', 'action' => 'update'));
$router->get('/pagamentos-tipos/ver/:id', array('controller' => 'PaymentTypesController', 'action' => 'show'));
$router->get('/pagamentos-tipos/deletar/:id', array('controller' => 'PaymentTypesController', 'action' => 'destroy'));

/* PAGAMENTOS */
$router->get('/pagamentos', array('controller' => 'PaymentsController', 'action' => 'index'));
$router->get('/pagamentos/historico', array('controller' => 'PaymentsController', 'action' => 'history'));
$router->post('/pagamentos/historico', array('controller' => 'PaymentsController', 'action' => 'history'));
$router->get('/pagamentos/novo/:id', array('controller' => 'PaymentsController', 'action' => 'fresh'));
$router->post('/pagamentos/novo/:id', array('controller' => 'PaymentsController', 'action' => 'create'));
$router->get('/pagamentos/ver/:id', array('controller' => 'PaymentsController', 'action' => 'show'));
$router->get('/pagamentos/deletar/:id', array('controller' => 'PaymentsController', 'action' => 'destroy'));

/* RESERVAS */
$router->get('/reservas', array('controller' => 'ReservationsController', 'action' => 'index'));
$router->get('/reservas/historico', array('controller' => 'ReservationsController', 'action' => 'history'));
$router->post('/reservas/historico', array('controller' => 'ReservationsController', 'action' => 'history'));
$router->get('/reservas/novo', array('controller' => 'ReservationsController', 'action' => 'fresh'));
$router->post('/reservas/novo', array('controller' => 'ReservationsController', 'action' => 'create'));
$router->get('/reservas/ver/:id', array('controller' => 'ReservationsController', 'action' => 'show'));
$router->get('/reservas/cancelar/:id', array('controller' => 'ReservationsController', 'action' => 'cancel'));
$router->get('/reservas/check-in/:id', array('controller' => 'ReservationsController', 'action' => 'checkIn'));

/* HOSPEDAGENS */
$router->get('/hospedagens', array('controller' => 'AccommodationsController', 'action' => 'index'));
$router->get('/hospedagens/historico', array('controller' => 'AccommodationsController', 'action' => 'history'));
$router->post('/hospedagens/historico', array('controller' => 'AccommodationsController', 'action' => 'history'));
$router->get('/hospedagens/ver/:id', array('controller' => 'AccommodationsController', 'action' => 'show'));
$router->get('/hospedagens/check-out/:id', array('controller' => 'AccommodationsController', 'action' => 'checkOut'));
$router->get('/hospedagens/pagamento/:id', array('controller' => 'AccommodationsController', 'action' => 'payment'));

/* CONSUMO DE PRODUTOS */
$router->get('/produtos-consumos', array('controller' => 'ProductConsumptionsController', 'action' => 'index'));
$router->get('/produtos-consumos/historico', array('controller' => 'ProductConsumptionsController', 'action' => 'history'));
$router->post('/produtos-consumos/historico', array('controller' => 'ProductConsumptionsController', 'action' => 'history'));
$router->get('/produtos-consumos/ver/:id', array('controller' => 'ProductConsumptionsController', 'action' => 'show'));
$router->get('/produtos-consumos/novo/:id', array('controller' => 'ProductConsumptionsController', 'action' => 'fresh'));
$router->post('/produtos-consumos/novo/:id', array('controller' => 'ProductConsumptionsController', 'action' => 'create'));
$router->get('/produtos-consumos/deletar/:id', array('controller' => 'ProductConsumptionsController', 'action' => 'destroy'));

/* FATURAMENTO */
$router->get('/faturamento', array('controller' => 'BillingsController', 'action' => 'index'));
$router->get('/faturamento/por-periodo', array('controller' => 'BillingsController', 'action' => 'search'));
$router->post('/faturamento/por-periodo', array('controller' => 'BillingsController', 'action' => 'search'));
$router->post('/faturamento/gerar-pdf', array('controller' => 'BillingsController', 'action' => 'generate'));


$router->load();
?>
