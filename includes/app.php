<?php

// Incluye funciones auxiliares necesarias para la aplicación.
// Asegúrate de que este archivo contiene funciones que utilizas en tu aplicación.
// Si hay alguna función específica que estás usando en este archivo,
// puedes añadir un comentario aquí describiendo su propósito.
require 'funciones.php';

// Incluye la configuración y conexión a la base de datos.
// Verifica que este archivo contenga la configuración correcta para conectarte a tu base de datos.
// Asegúrate de manejar de forma segura la información sensible como credenciales.
require 'database.php';

// Incluye el archivo de autoloading generado por Composer para cargar automáticamente las clases.
// `__DIR__` se refiere al directorio actual del archivo `app.php`.
// La ruta `'/../vendor/autoload.php'` navega al directorio `vendor` donde Composer coloca el autoloading.
// Asegúrate de haber ejecutado `composer install` para generar este archivo.
require __DIR__ . '/../vendor/autoload.php';
