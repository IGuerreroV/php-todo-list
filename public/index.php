<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MVC\Router;

// Inicializa el router y maneja las solicitudes
$router = new Router();




// Compueba la ruta actual y llama a la función asociada
$router->comprobarRutas();