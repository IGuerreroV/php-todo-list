<?php

namespace Controllers;

use Models\Task;
class TaskController
{
  public static function index()
  {
    // Obtenemos las tareas
    $tareas = Task::all();
    // Incluimos la vista y pasamos las tareas
    require_once __DIR__ . '/../views/layout.php';
  }

  // Crear una nueva tarea
  public static function crear()
  {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // si se envio el formulario

      $tarea = new Task($_POST); // creamos una nueva tarea con los datos del formulario
      // debuguear($tarea);
      $alertas = $tarea->validar(); // validamos los datos
      // debuguear($alertas);
      if (empty($alertas)) { // si no hay errores
        $tarea->guardar(); // guardamos la tarea en la base de datos
      }
    }
  }

  // eliminar una tarea
  public static function eliminar() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Validar ID

    }
  }
}