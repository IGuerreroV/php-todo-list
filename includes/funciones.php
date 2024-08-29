<?php

// Funcion para debuguear
// Esta funcion imprime el contenido de una variable de forma legible
function debuguear($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

// Sanitizar el HTML
// Esta funcion convierte los caracteres especiales en entidades HTML
// para evitar que se ejecuten scripts maliciosos
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s; // Retorna el HTML sanitizado
}