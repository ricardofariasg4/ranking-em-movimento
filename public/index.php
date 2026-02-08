<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Routes;

header('Content-Type: application/json');

$router = new Router(); // Criação do roteador
Routes::register($router); // Registro das rotas
$router->dispatch(); // Processamento da requisição e envio da resposta