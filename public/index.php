<?php
require_once __DIR__ . '/../includes/app.php';

use Controllers\TaskController;

// Instancia principal
$controller = new TaskController();

// Manejar las rutas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller->crear();
} else {
  $controller->index();
}
