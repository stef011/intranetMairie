<?php
require('./vendor/autoload.php');
session_start();

use App\Router\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);


$router->get('/', 'IndexController@show', 'index');

$router->post('/admin', 'AdminController@login', 'admin.login');
$router->get('/admin/logout', 'AdminController@logout', 'admin.logout');
$router->get('/admin', 'AdminController@index', 'admin.index');
$router->get('/admin/tickets', 'AdminController@tickets', 'admin.tickets');

$router->get('/ticket/setState/:id/:state', 'TicketController@setState', 'ticket.setState');


$router->get('/annuaire', 'AnnuaireController@index', 'annuaire');

$router->get('/support', 'SupportController@index', 'support');
$router->post('/support', 'SupportController@post', 'support');

$router->post('/api/tutorials', 'ApiController@tutos', 'api.tutorials');
$router->post('/api/sub-cats', 'ApiController@subCategories', 'api.subCats');

$router->get('/tutoriels', 'TutorialController@index', 'tutoriels.index');
$router->get('/tutoriels/:id', 'TutorialController@show', 'tutoriels.show');



$router->run();
