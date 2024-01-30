<?php
// Asegúrate de que la ruta al archivo config.php y header.php sea correcta
require_once '../config.php';
require_once 'header.php';

// Lógica para añadir o editar una película
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Lógica para añadir una película
       
        $coverPath = uploadCover($_FILES['cover']);
        if ($coverPath) {
            $result = addMedia('movies', [
                'title' => $_POST['title'],
                'category_id' => $_POST['category_id'],
                'cover_path' => $coverPath
            ], $db);
            if ($result) {
                $message = "Película añadida con éxito.";
            } else {
                $message = "Error al añadir la película.";
            }
        } else {
            $message = "Error al subir la carátula.";
        }
    }
    header('Location: adminmovies.php');
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $deleteResult = deleteMedia('movies', $_GET['id'], $db);
    if ($deleteResult) {
        $message = "Película eliminada con éxito.";
    } else {
        $message = "Error al eliminar la película.";
    }
    header('Location: adminmovies.php');
    exit;
}

// Obtener películas existentes
$movies = getMovies($db);
$categories = getCategories('movie', $db);
?>

<div class="admin-container">
    <h2>Administrar Películas</h2>
    <?php if ($message): ?>
    <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <!-- Formulario para añadir una nueva película -->
    <form action="adminmovies.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="category_id">Categoría:</label>
            <select name="category_id" id="category_id" required>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="cover">Carátula:</label>
            <input type="file" name="cover" id="cover" required>
        </div>
        <input type="submit" name="add" value="Añadir Película">
    </form>

    <!-- Listar películas existentes con opciones para editar y eliminar -->
    <?php foreach ($movies as $movie): ?>
    <div class="movie-item">
        <img src="../uploads/<?php echo $movie['cover_path']; ?>" alt="Carátula">
        <h3><?php echo $movie['title']; ?></h3>
        <p>Categoría: <?php echo $movie['category_id']; ?></p>
        <!-- Los botones de Editar y Eliminar necesitarán lógica adicional y formularios posiblemente -->
        <a href="editmovie.php?id=<?php echo $movie['id']; ?>">Editar</a>
        <a href="deletemovie.php?id=<?php echo $movie['id']; ?>">Eliminar</a>
    </div>
    <?php endforeach; ?>
</div>

<footer>
    <!-- Información del pie de página si es necesario -->
</footer>

</body>
</html>
