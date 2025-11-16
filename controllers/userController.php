<?php 

require_once 'helpers/fileHelper.php';

// --- Bloque de Registro Unificado ---
// Este bloque maneja el envío del formulario de registro.
// Valida que las contraseñas coincidan y luego delega la creación
// del usuario al UserRepository, manteniendo el controlador limpio.
if (isset($_POST['password2']) && isset($_POST['password']) && isset($_POST['username'])) {
    if ($_POST['password'] == $_POST['password2']) {
        // Creamos un objeto User temporal para pasarlo al repositorio
        $user = new User(null, $_POST['username'], null, null);
        UserRepository::register($user, $_POST['password']);
        // Redirigimos al usuario a la página de inicio para que pueda hacer login.
        // Esto sigue el patrón Post/Redirect/Get, que es una mejor práctica.
        header('Location: index.php');
        die(); // Siempre llama a die() o exit() después de una redirección.
    }
}

// --- Bloque de Login ---
// Este bloque maneja el envío del formulario de login.
// Ahora delega TODA la validación de credenciales al UserRepository.
if (isset($_POST['username']) && isset($_POST['password'])) {
    $userRow = UserRepository::login($_POST['username'], $_POST['password']);
    
    if ($userRow) {
        // Si el login es exitoso, creamos el objeto User y lo guardamos en la sesión.
        $_SESSION['user'] = new User($userRow['id'], $userRow['username'], $userRow['avatar'], $userRow['roles']);
        header('Location: index.php');
        die(); // Es buena práctica llamar a die() después de una redirección.
    }
    // Si $userRow es nulo (login fallido), no hacemos nada y el script continuará,
    // mostrando de nuevo la vista de login gracias al mainController.
}

// --- Bloque para Mostrar la Vista de Registro ---
// Si en la URL viene el parámetro 'register' (por GET), simplemente muestro el formulario de registro
// (`registerView.phtml`) y detengo la ejecución para no cargar nada más.
if (isset($_GET['register'])) {
    require_once('views/registerView.phtml');
    die();
}

// --- Bloque de Cierre de Sesión ---
// Si en la URL viene el parámetro 'logout', destruyo la sesión actual para desloguear al usuario
// y lo redirijo a la página de inicio.
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}

// --- Bloque para Mostrar la Vista de Edición de Usuario ---
// Si en la URL viene el parámetro 'edit', simplemente muestro la vista `editUserView.phtml`
// para que el usuario pueda modificar sus datos.
if (isset($_GET['edit'])) {
    require_once 'views/editUserView.phtml';
    die();
}

// --- Bloque para Actualizar el Avatar ---
// Si en la URL viene 'setAvatar', significa que el usuario está subiendo una nueva foto de perfil.
// Compruebo si se ha subido un archivo llamado 'avatar'.
// Uso una clase 'FileHelper' para mover el archivo temporal a la carpeta de imágenes públicas.
// Si se mueve correctamente, actualizo el objeto de usuario en la sesión con el nuevo nombre del archivo.
// Finalmente, redirijo de nuevo a la página de edición.
if (isset($_GET['setAvatar'])) {
    if (isset($_FILES['avatar'])) {
        $newAvatarName = $_FILES['avatar']['name'];
        // 1. Mover el archivo
        if (FileHelper::fileHandler($_FILES['avatar']['tmp_name'], 'public/img/' . $newAvatarName)) {
            // 2. Actualizar la base de datos
            UserRepository::setAvatar($newAvatarName, $_SESSION['user']);
            // 3. Actualizar el objeto en la sesión
            $_SESSION['user']->setAvatar($newAvatarName);
        }
    }
    header('Location: index.php?c=user&edit=1');
}