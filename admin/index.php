<?php
// Asegúrate de que la ruta al archivo config.php y header.php sea correcta
require_once '../config.php';
require_once 'header.php'; // Incluir el header de administración
?>

<div class="admin-container">
    <h2>Bienvenido al Panel de Administración</h2>
    <p>Selecciona una de las opciones para empezar a gestionar el contenido:</p>
    <div class="admin-options">
        <a href="adminmovies.php">Administrar Películas</a>
        <a href="adminsongs.php">Administrar Canciones</a>
    </div>
</div>

<footer>
    <!-- Información del pie de página si es necesario -->
</footer>

</body>
</html>
