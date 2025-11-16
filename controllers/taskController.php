<?php 

// --- Bloque para Eliminar Tarea ---
if (isset($_GET['delete'])) {
    // Solo los admins pueden eliminar
    if ($_SESSION['user']->getRoles() == 'admin') {
        TaskRepository::delete($_GET['delete']);
    }
    // Redirigimos de vuelta al proyecto al que pertenecía la tarea
    header('location:index.php?c=proyect&id=' . $_GET['projectId']);
    die();
}

// --- Bloque para Crear Tarea ---
// Comprobamos si recibimos los datos correctos del formulario
if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['projectId'])) {
    // Solo los admins pueden crear
    if ($_SESSION['user']->getRoles() == 'admin') {
        // 1. Creamos un objeto Task con los datos del formulario y de la sesión
        $user_id = $_SESSION['user']->getId();
        $datetime = date('Y-m-d H:i:s'); // Obtenemos la fecha y hora actual
        $task = new Task(null, $_POST['name'], $_POST['description'], $datetime, $_POST['projectId'], $user_id);

        // 2. Le pasamos el objeto completo al repositorio para que lo guarde
        TaskRepository::create($task);
    }

    // 3. Redirigimos de vuelta a la página del proyecto para ver la nueva tarea
    header('location:index.php?c=proyect&id=' . $_POST['projectId']);
    die();
}
