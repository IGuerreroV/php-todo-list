<?php

namespace Controllers;
class TaskController
{
  public static function index()
  {
    // Incluimos la vista y pasamos las tareas
    require_once __DIR__ . '/../views/layout.php';
  }
}