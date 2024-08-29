<?php

// Conexión a la base de datos
// Parametros:
// - 'localhost' es el servidor de la base de datos
// - 'root' es el usuario de la base de datos
// - 'root' es la contraseña del usuario de la base de datos
// - '' es el nombre de la base de datos

$db = mysqli_connect('localhost', 'root', 'root', '');

// Comprobar la conexión
if(!$db) {
    // Si no se puede conectar a la base de datos, muestra un mensaje de error
    echo 'Error en la conexión';
    // Muestra el número de error de la conexión para depuración
    echo 'errno de depuración: ' . mysqli_connect_errno();
    // Muestra el mensaje de error de la conexión para depuración
    echo 'error de depuración: ' . mysqli_connect_error();
    // Termina la ejecución del script
    exit;
}