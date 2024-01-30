<?php
// header.php

// Iniciar sesión para utilizar la variable $_SESSION
session_start();

// Función para manejar el proceso de inicio de sesión
function loginUser($username, $password, $db) {
    $is_admin = checkUser($username, $password, $db); // Esta función debe existir en config.php
    if ($is_admin !== false) {
        $_SESSION['is_admin'] = $is_admin;
        $_SESSION['username'] = $username;
        if ($is_admin) {
            header('Location: admin/index.php');
            exit;
        }
    } else {
        echo "<p>Usuario o contraseña incorrectos.</p>";
    }
}

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    loginUser($_POST['username'], $_POST['password'], $db);
}

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Multimedia</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js"></script>
</head>
<body>
    <header>
        <h1>Catálogo Multimedia para Viajeros</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="movies.php">Películas</a></li>
                <li><a href="songs.php">Canciones</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <li><a href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="text" name="username" placeholder="Usuario" required>
                            <input type="password" name="password" placeholder="Contraseña" required>
                            <input type="submit" name="login" value="Iniciar Sesión">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</html>
