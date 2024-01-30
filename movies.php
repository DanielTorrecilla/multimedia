<?php
// movies.php

require 'config.php'; // Asegúrate de que la ruta al archivo config.php sea correcta.
$movies = getMovies($db); // Esta función debería estar definida en config.php
$categories = getCategories('movie', $db); // Esta función debería estar definida en config.php
require 'header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Películas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Películas Disponibles</h1>
    </header>
    <section>
        <?php foreach ($categories as $category): ?>
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            <div class="movies-category">
                <?php foreach ($movies as $movie): ?>
                    <?php if ($movie['category_id'] == $category['id']): ?>
                        <div class="movie">
                            <img src="uploads/<?php echo $movie['cover_path']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                            <!-- Aquí puedes agregar un enlace o un botón para reproducir la película -->
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>
