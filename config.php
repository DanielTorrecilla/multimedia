<?php
// config.php

// Datos para la conexión a la base de datos
$host = 'localhost';
$db_name = 'basemultimedia';
$db_user = 'root'; // Cambiar por tu usuario de base de datos
$db_pass = ''; // Cambiar por tu contraseña de base de datos

// Conexión con PDO
try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit("Error de conexión: " . $e->getMessage());
}

// Función para verificar el usuario y contraseña
function checkUser($username, $password, $db) {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch();
    
    return $user ? $user['is_admin'] : false; // Devuelve si es admin o no, o false si no se encuentra el usuario.
}

// Funciones para obtener películas y canciones
function getMovies($db) {
    $stmt = $db->query("SELECT * FROM movies");
    return $stmt->fetchAll();
}

function getSongs($db) {
    $stmt = $db->query("SELECT * FROM songs");
    return $stmt->fetchAll();
}

// Funciones para obtener categorías
function getCategories($type, $db) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE type = :type");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    return $stmt->fetchAll();
}



// Función para añadir una película o canción
function addMedia($table, $data, $db) {
    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));
    
    $stmt = $db->prepare("INSERT INTO $table ($columns) VALUES ($values)");
    return $stmt->execute($data);
}

// Función para obtener una película o canción por ID
function getMediaById($table, $id, $db) {
    $stmt = $db->prepare("SELECT * FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

// Función para actualizar una película o canción
function updateMedia($table, $data, $id, $db) {
    $sets = [];
    foreach ($data as $key => $value) {
        $sets[] = "$key = :$key";
    }
    $sets = implode(", ", $sets);
    
    $data['id'] = $id; // Asegurarse de que el array de datos incluya el ID para la condición WHERE
    $stmt = $db->prepare("UPDATE $table SET $sets WHERE id = :id");
    return $stmt->execute($data);
}

// Función para borrar una película o canción
function deleteMedia($table, $id, $db) {
    $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

// Función para subir carátulas
function uploadCover($file) {
    $targetDir = "uploads/";
    // Crear el directorio si no existe
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Sanitizar el nombre del archivo para evitar errores
    $fileName = time() . '-' . preg_replace('/[^A-Za-z0-9\-.]/', '', basename($file["name"]));
    $targetFilePath = $targetDir . $fileName;
    
    // Mover el archivo subido al directorio de uploads
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $fileName;
    } else {
        return false;
    }
}

function deleteMovie($movieId, $db) {
    // Realizar la consulta SQL para eliminar la película
    $sql = "DELETE FROM movies WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);

    // Ejecutar la consulta
    $result = $stmt->execute();

    return $result;
}

// ...

?>
