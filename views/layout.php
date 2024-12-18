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
    <div class="contenedor contenedor-tareas">
        <header>
            <h1>Tareas</h1>
        </header>
        <main class="tareas">
            <input class="nueva-tarea" type="text" id="tarea" placeholder="Nueva tarea..." name="tarea">
            <input type="submit" class="boton" value="+">
        </main>
        <aside class="contenedor-tareas">
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
</body>

</html>