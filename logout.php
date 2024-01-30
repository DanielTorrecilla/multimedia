<?php
// logout.php

session_start();
session_destroy(); // Destruye la sesión y borra todos los datos de sesión.
header('Location: index.php'); // Redirige al usuario al inicio.
exit;
