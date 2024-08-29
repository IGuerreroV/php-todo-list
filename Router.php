<?php

namespace MVC;

/**
 * Router Class
 * 
 * La clase Router maneja las rutas de la aplicación. Permite registrar rutas GET y POST,
 * comprobar la ruta actual, y renderizar vistas.
 */
class Router {
    // Array para almacenar las rutas GET
    public array $getRoutes = [];
    
    // Array para almacenar las rutas POST
    public array $postRoutes = [];

    /**
     * Registra una ruta GET con su función asociada.
     *
     * @param string $url La URL de la ruta.
     * @param callable $fn La función que se ejecutará cuando se acceda a esta ruta.
     */
    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    /**
     * Registra una ruta POST con su función asociada.
     *
     * @param string $url La URL de la ruta.
     * @param callable $fn La función que se ejecutará cuando se acceda a esta ruta.
     */
    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    /**
     * Comprueba la ruta actual y llama a la función asociada.
     */
    public function comprobarRutas() {
        // Inicia la sesión para proteger las rutas
        session_start();

        // Obtiene la URL actual y el método de la solicitud
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        // Selecciona la función asociada a la ruta y al método de solicitud
        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            // Llama a la función asociada a la ruta
            call_user_func($fn, $this);
        } else {
            // Muestra un mensaje de página no encontrada
            echo 'Página no encontrada';
        }
    }

    /**
     * Renderiza una vista y pasa datos a la vista.
     *
     * @param string $view Nombre del archivo de la vista.
     * @param array $datos Datos a pasar a la vista.
     */
    public function render($view, $datos = []) {
        // Extrae los datos para que estén disponibles como variables en la vista
        foreach ($datos as $key => $value) {
            $$key = $value; // $$key es una variable variable dinámica
        }

        // Inicia el almacenamiento en búfer de salida
        ob_start();

        // Incluye el archivo de la vista
        include_once __DIR__ . '/views/' . $view . '.php';

        // Obtiene el contenido del búfer y lo limpia
        $contenido = ob_get_clean();

        // Incluye el archivo de diseño/layout que puede contener la estructura HTML básica
        include_once __DIR__ . '/views/layout.php';
    }
}
