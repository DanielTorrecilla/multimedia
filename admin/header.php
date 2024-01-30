<?php
// admin/header.php
// Iniciar sesión para utilizar la variable $_SESSION
session_start();

// Verificar si el usuario es un administrador
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    // Si no es un administrador o si no está logueado, redirigir a la página de inicio de sesión
    header('Location: ../index.php');
    exit;
}

// Función para manejar el cierre de sesión
function logout() {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

// Verificar si se pidió cerrar sesión
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - Catálogo Multimedia</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="admin.js"></script>
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio Admin</a></li>
                <li><a href="adminmovies.php">Administrar Películas</a></li>
                <li><a href="adminsongs.php">Administrar Canciones</a></li>
                <li><a href="?action=logout">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
