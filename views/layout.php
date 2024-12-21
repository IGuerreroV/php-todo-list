<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/app.css">
  <title>Todo list</title>
</head>

<body>
  <div class="contenedor">
    <header>
      <h1>Tareas</h1>
    </header>
    <main class="tareas">
      <div>
        <form class="formulario" method="POST" id="form-tarea">
          <input class="nueva-tarea" type="text" id="tarea" placeholder="Nueva tarea..." name="titulo" required>
          <input type="submit" class="boton" value="+">
        </form>
      </div>

      <div class="contenedor-tareas" id="lista-tareas">
        <ul class="listado">
          <?php foreach ($tareas as $tarea): ?>
            <li>
              <div class="estado">
                <input type="checkbox" id="estado-<?php echo $tarea->id; ?>" name="estado-<?php echo $tarea->id; ?>">
                <label for="estado-<?php echo $tarea->id; ?>"><?php echo $tarea->titulo; ?></label>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </main>
    <aside class="contenedor-estados">
      <div>
        <span>Total</span>
        <span>•</span>
        <span>Completadas</span>
        <span>•</span>
        <span>pendientes</span>
      </div>
    </aside>
    <footer>
      <p>&copy; 2024 Todo List</p>
    </footer>
  </div>

  <!-- <script src="app.js"></script> -->
</body>

</html>