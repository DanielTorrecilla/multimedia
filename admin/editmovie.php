<?php
// editmovie.php

require_once '../config.php';
require_once 'header.php';

$movieId = isset($_GET['id']) ? $_GET['id'] : null;
$movie = null;
$message = "";

if ($movieId) {
    $movie = getMediaById('movies', $movieId, $db);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    // Asumiendo que tienes un formulario con campos para 'title', 'category_id' y 'cover'
    // Además, el campo 'cover' es opcional en caso de que no se desee actualizar la carátula
    $coverPath = $movie['cover_path']; // Usar la carátula existente por defecto
    if ($_FILES['cover']['name']) {
        $coverPath = uploadCover($_FILES['cover']);
    }

    if (!$coverPath) {
        $message = "Error al subir la carátula.";
    } else {
        $updateData = [
            'title' => $_POST['title'],
            'category_id' => $_POST['category_id'],
            'cover_path' => $coverPath
        ];

        $result = updateMedia('movies', $updateData, $movieId, $db);
        if ($result) {
            $message = "Película actualizada con éxito.";
            // Recargar la película después de la actualización
            $movie = getMediaById('movies', $movieId, $db);
        } else {
            $message = "Error al actualizar la película.";
        }
    }
}

$categories = getCategories('movie', $db);
?>

<div class="admin-container">
    <h2>Editar Película</h2>
    <?php if ($message): ?>
    <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($movie): ?>
    <form action="editmovie.php?id=<?php echo $movieId; ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
        </div>
        <div>
            <label for="category_id">Categoría:</label>
            <select name="category_id" id="category_id" required>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $movie['category_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="cover">Carátula:</label>
            <input type="file" name="cover" id="cover">
            <img src="../uploads/<?php echo htmlspecialchars($movie['cover_path']); ?>" alt="Carátula">

        </div>
        <input type="submit" name="edit" value="Editar Película">
    </form>
    <?php else: ?>
    <p>Película no encontrada.</p>
    <?php endif; ?>
</div>

<footer>
    <!-- Información del pie de página si es necesario -->
</footer>

</body>
</html>
