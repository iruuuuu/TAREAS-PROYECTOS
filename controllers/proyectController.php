<?php

// --- Bloque para Crear Proyecto ---
if (isset($_POST['name']) && isset($_POST['description'])) {
    // Solo los admins pueden crear
    if ($_SESSION['user']->getRoles() == 'admin') {
        $datetime = date('Y-m-d H:i:s');
        $proyect = new Proyect(null, $_POST['name'], $_POST['description'], $datetime);
        ProyectRepository::create($proyect);
    }
    header('Location: index.php');
    die();
}

// --- Bloque para Eliminar Proyecto ---
if (isset($_GET['delete'])) {
    // Solo los admins pueden eliminar
    if ($_SESSION['user']->getRoles() == 'admin') {
        ProyectRepository::delete($_GET['delete']);
    }
    header('Location: index.php');
    die();
}

// --- Bloque para Mostrar un Proyecto ---
if (isset($_GET['id'])) {
    $proyect = ProyectRepository::getProyectById($_GET['id']);
    $tasks = TaskRepository::getTaskByProyectId($_GET['id']);
    require_once('views/showProyect.phtml');
    exit();
}