<?php
require('./vendor/autoload.php');

use App\Router\Router;


$router = new Router($_GET['url']);
$router->get('/', 'TestController@show');

$router->run();