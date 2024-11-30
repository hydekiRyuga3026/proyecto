<?php
session_start();
require 'conexion.php'; // Archivo de conexión a la base de datos

// Validación de datos de entrada
$username = trim($_POST['username']);  // Eliminar espacios al inicio y al final
$password = $_POST['password'];  // No se necesita sanitizar aquí, ya que la contraseña será verificada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Consulta para buscar el usuario (sin la columna 'role')
    $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            // Ya no es necesario guardar 'role' en la sesión
            // $_SESSION['role'] = $user['role']; // Eliminar esta línea

            // Redirigir al inicio.php después del login exitoso
            header('Location: inicio.php');
            exit; // Detener la ejecución posterior para evitar que se siga ejecutando código después de la redirección
        } else {
            // Mensaje de error por contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        // Mensaje de error si no se encuentra el usuario
        echo "<script>alert('Usuario no encontrado');</script>";
    }
}
?>
