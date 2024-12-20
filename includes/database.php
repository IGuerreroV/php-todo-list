<?php
// debuguear($_ENV);
$db = mysqli_connect(
  $_ENV['DB_HOST'],
  $_ENV['DB_USER'],
  $_ENV['DB_PASSWORD'],
  $_ENV['DB_DATABASE'],
); // Conexión a la base de datos

$db->set_charset('utf8'); // Para que se muestren las tildes correctamente

if (!$db) {
  echo "Error: No se pudo conectar a MySQL." . PHP_EOL; // Si no se conecta a la base de datos
  echo "errno de depuración: " . mysqli_connect_errno(); // Muestra el error
  echo "error de depuración: " . mysqli_connect_error(); // Muestra el error
  exit; // Sale del programa
}