<?php

namespace Models;

use Model\ActiveRecord;// Namespace del modelo, sirve para organizar los archivos

class Task extends ActiveRecord // Hereda de ActiveRecord para poder usar los métodos de la clase padre
{
  protected static $columnasDB = ['id', 'titulo', 'estado', 'fecha_creacion', 'fecha_actualizacion']; // Columnas de la tabla en la base de datos

  protected $id;
  protected $titulo;
  protected $estado;
  protected $fecha_creacion;
  protected $fecha_actualizacion;

  public function __construct($args = [])
  { // Constructor de la clase, se ejecuta al instaciar un objeto de la clase
    $this->id = $args['id'] ?? null; // Si no se pasa un id, se asigna null
    $this->titulo = $args['titulo'] ?? ''; // Si no se pasa un titulo, se asigna un string vacío
    $this->estado = $args['estado'] ?? 0; // Si no se pasa un estado, se asigna 0
    $this->fecha_creacion = date('Y-m-d'); // Se asigna la fecha actual
    $this->fecha_actualizacion = date('Y-m-d'); // Se asigna la fecha actual
  }
}
