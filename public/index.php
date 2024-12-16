<?php
require_once __DIR__ . '/../includes/app.php';

use Controllers\TaskController;

// Instancia principal
$controller = new TaskController();

// Llamar al metodo index
$controller->index();

// Incluir el Layout
$controller->index();