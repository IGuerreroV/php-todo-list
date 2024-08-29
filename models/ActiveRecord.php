<?php
namespace Model;

class ActiveRecord {

    // Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    /**
     * Establece la conexión a la base de datos.
     *
     * @param mysqli $database Instancia de la conexión a la base de datos.
     */
    public static function setDB($database) {
        self::$db = $database;
    }

    /**
     * Agrega una alerta a la lista de alertas.
     *
     * @param string $tipo Tipo de alerta (e.g., error, éxito).
     * @param string $mensaje Mensaje de la alerta.
     */
    public static function setAlertas($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    /**
     * Obtiene todas las alertas.
     *
     * @return array Lista de alertas.
     */
    public static function getAlertas() {
        return static::$alertas;
    }

    /**
     * Valida los datos del objeto y limpia las alertas.
     *
     * @return array Lista de alertas después de la validación.
     */
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    /**
     * Ejecuta una consulta SQL y devuelve objetos correspondientes.
     *
     * @param string $query Consulta SQL.
     * @return array Array de objetos correspondientes a los registros.
     */
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array =[];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    /**
     * Crea un objeto a partir de un registro.
     *
     * @param array $registro Datos del registro.
     * @return static Objeto creado.
     */
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if(property_exists( $objeto, $key )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    /**
     * Obtiene los atributos del objeto.
     *
     * @return array Atributos del objeto.
     */
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    /**
     * Sanitiza los atributos del objeto para prevenir inyecciones SQL.
     *
     * @return array Atributos sanitizados.
     */
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    /**
     * Sincroniza el objeto con los datos proporcionados.
     *
     * @param array $args Datos para sincronizar.
     */
    public function sincronizar($args=[]) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Guarda el objeto en la base de datos (crea o actualiza).
     *
     * @return array Resultado de la operación y el ID del nuevo registro (si aplica).
     */
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // Actualizar
            $resultado = $this->actualizar();
        } else {
            // Crear un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    /**
     * Obtiene todos los registros de la tabla.
     *
     * @return array Array de objetos de la tabla.
     */
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * Busca un registro por su ID.
     *
     * @param int $id ID del registro.
     * @return static|null Objeto correspondiente al registro o null si no se encuentra.
     */
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado );
    }

    /**
     * Crea un nuevo registro en la base de datos.
     *
     * @return array Resultado de la operación y el ID del nuevo registro.
     */
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la BD
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }

    /**
     * Actualiza un registro existente en la base de datos.
     *
     * @return bool Resultado de la operación.
     */
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para agregar los atributos
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // conusulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar la BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @return bool Resultado de la operación.
     */
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);
        return $resultado;
    }
}