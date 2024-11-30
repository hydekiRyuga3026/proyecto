<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "Veterinaria"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar el conjunto de caracteres a UTF-8
if (!$conn->set_charset("utf8")) {
    die("Error al configurar el conjunto de caracteres: " . $conn->error);
}

// Hacer la conexión disponible globalmente
$GLOBALS['conn'] = $conn;
?>
