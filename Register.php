<?php
require 'conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; // Capturamos el rol elegido

    // Consulta para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado exitosamente'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            background-color: #1e3d58; /* Azul oscuro */
            background-image: url('imagenes/gatitos.jpg'); /* Imagen de fondo */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.4); /* Caja con más transparencia */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .container h2 {
            color: #1e3d58; /* Azul oscuro */
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #1e3d58; /* Azul oscuro */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #155a75; /* Azul más oscuro */
        }

        .cancelar {
            background-color: #d9534f; /* Rojo */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .cancelar:hover {
            background-color: #c9302c; /* Rojo más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrar Usuario</h2>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <!-- Campo para seleccionar el rol -->
            <select name="role" required>
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>

            <button type="submit">Registrar</button>
            <a href="login.php">
                <button type="button" class="cancelar">Cancelar</button>
            </a>
        </form>
    </div>
</body>
</html>
