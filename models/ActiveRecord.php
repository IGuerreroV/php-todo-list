<?php

namespace Models;

class ActiveRecord
{
  // Base de datos
  protected static $db; // Conexión a la base de datos
  protected static $columnasDB = []; // Nombres de las columnas de la tabla

  // Alertas y Mensajes
  protected static $alertas = []; // Almacena mensajes de error y alertas

  // Definir la conexión a la base de datos
  public static function setDB($database)
  {
    self::$db = $database; // Establece la conexión a la base de datos
  }

  // Crear alertas y mensajes
  public static function setAlertas($tipo, $mensaje)
  {
    static::$alertas[$tipo][] = $mensaje; // Agrega un mensaje de alerta del tipo especificado
  }

  // Obtener los mensajes de error
  public static function getAlertas()
  {
    return static::$alertas; // Retorna todas las alertas almacenadas
  }

  // Validar errores en los datos
  public function validar()
  {
    static::$alertas = []; // Reinicia las alertas
    // Aquí puedes agregar lógica de validación para los atributos del objeto
    return static::$alertas; // Retorna las alertas (vacías por ahora)
  }

  public function guardar()
  {
    $resultado = '';
    if (!is_null($this->id)) {
      // Actualizar
      $resultado = $this->actualizar();
    } else {
      // Crear un nuevo registro
      $resultado = $this->crear();
    }
    return $resultado;
  }

  // Actualizar un registro
  public function actualizar()
  {
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();

    // Iterar para ir agregando cada campo con su valor
    $valores = [];
    foreach ($atributos as $key => $value) {
      $valores[] = "{key} = '{$value}'";
    }

    $query = "UPDATE " . $_ENV['DB_DATABASE'] . " SET ";
    $query .= join(', ', $valores);
    $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
    $query .= " LIMIT 1";
  }

  // Listar todos los registros
  public static function all()
  {
    $query = "SELECT * FROM " . 'tareas'; // Consulta para obtener todos los registros
    $resultado = self::consultarSQL($query); // Ejecuta la consulta
    return $resultado; // Retorna los resultados
  }

  // Consultar SQL
  public static function consultarSQL($query)
  {
    // Consultar la base de datos
    $resultado = self::$db->query($query);

    if (!$resultado) {
      // Manejo de errores
      self::setAlertas('error', 'Error en la consulta: ' . self::$db->error);
      return []; // Retorna un array vacío en caso de error
    }

    // Iterar los resultados
    $array = [];
    while ($registro = $resultado->fetch_assoc()) {
      $array[] = static::crearObjeto($registro); // Crea un objeto a partir del registro
    }

    // Liberar la memoria
    $resultado->free();

    // Retornar los resultados
    return $array; // Retorna el array de objetos
  }

  // Crear un nuevo registro
  public function crear()
  {
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();

    // Insertar en la base de datos
    $query = "INSERT INTO " . 'tareas' . " (";
    $query .= join(', ', array_keys($atributos));
    $query .= ") VALUES ('";
    $query .= join("', '", array_values($atributos));
    $query .= "')";

    // Resultado de la consulta
    $resultado = self::$db->query($query);

    return [ // Retorna un array con el resultado y el id del registro
      'resultado' => $resultado,
      'id' => self::$db->insert_id,
    ];
  }

  // Crear un objeto en base a una consulta
  protected static function crearObjeto($registro)
  {
    $objeto = new static; // Crea una nueva instancia de la clase

    // Iterar los resultados y asignarlos al objeto
    foreach ($registro as $key => $value) {
      if (property_exists($objeto, $key)) { // Verificar que la propiedad exista
        $objeto->$key = $value; // Asignar el valor al atributo del objeto
      }
    }

    return $objeto; // Retorna el objeto creado
  }

  // Identificar y unir los atributos de la base de datos
  public function atributos()
  {
    $atributos = []; // Inicializa un array para los atributos

    foreach (static::$columnasDB as $columna) {
      if ($columna === 'id')
        continue; // Ignora el atributo 'id'
      $atributos[$columna] = $this->$columna; // Asignar el valor de la columna al atributo
    }
    return $atributos; // Retorna el array de atributos
  }

  // Sanitizar los datos
  public function sanitizarAtributos()
  {
    $atributos = $this->atributos(); // Obtiene los atributos
    $sanitizado = []; // Inicializa un array para los atributos sanitizados

    foreach ($atributos as $key => $value) {
      $sanitizado[$key] = self::$db->escape_string($value); // Escapar los valores para evitar inyecciones SQL
    }
    return $sanitizado; // Retorna el array de atributos sanitizados
  }

  // Sincronizar los atributos a la base de datos
  public function sincronizar($args = [])
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) { // Verificar que la propiedad exista y que no sea nula
        $this->$key = $value; // Asignar el valor a la propiedad
      }
    }
  }
}