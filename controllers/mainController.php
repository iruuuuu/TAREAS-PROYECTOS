<?php 

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserRepository.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/TaskRepository.php';
require_once __DIR__ . '/../models/Proyect.php';
require_once __DIR__ . '/../models/ProyectRepository.php';

session_start();

// 3. Enrutamiento (Routing): Comprueba si se ha pasado un parámetro 'c' (controlador)
//    en la URL. Si es así, delega la petición al controlador correspondiente
//    (ej: userController.php, threadController.php) y ese controlador se encargará
//    de la petición.
if (isset($_GET['c'])) {
    // Usamos __DIR__ para asegurar que la ruta es relativa a la carpeta de controladores
    require_once(__DIR__ . '/' . $_GET['c'] . 'Controller.php');
}

// 4. Autenticación: Si no se ha delegado a otro controlador, verifica si el usuario
//    ha iniciado sesión. Si no lo ha hecho, muestra la vista de login y detiene la ejecución.
if (!isset($_SESSION['user'])) {
    require_once 'views/loginView.phtml';
    die();
}

// 5. Carga de datos y renderizado de la vista principal: Si el usuario SÍ ha iniciado sesión,
//    obtiene todos los hilos del foro y carga la vista principal para mostrarlos.
$proyects = ProyectRepository::getProyects();
require_once 'views/mainView.phtml';