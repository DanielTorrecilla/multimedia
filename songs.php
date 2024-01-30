<?php
// songs.php

require 'config.php'; // Asegúrate de que la ruta al archivo config.php sea correcta.
$songs = getSongs($db); // Esta función debería estar definida en config.php
require 'header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Canciones</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js"></script> <!-- Asegúrate de tener el archivo script.js -->
</head>
<body>
    <header>
        <h1>Canciones Disponibles</h1>
    </header>
    <section>
        <?php foreach ($songs as $song): ?>
            <div class="song">
                <img src="uploads/<?php echo $song['cover_path']; ?>" alt="<?php echo htmlspecialchars($song['title']); ?>">
                <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                <!-- Aquí puedes agregar un reproductor de música o un enlace para escuchar la canción -->
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>
