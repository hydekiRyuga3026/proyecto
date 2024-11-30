<?php
// Si se desea procesar el formulario o autenticar al usuario, se puede agregar el código aquí.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        /* Estilos globales */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Fondo de la página */
        body {
            background: url('imagenes/mascotas.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Contenedor del formulario */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Caja del formulario */
        .login-box {
            background-color: rgba(255, 255, 255, 0.5); /* Fondo blanco con transparencia */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        /* Título */
        .login-box h2 {
            text-align: center;
            color: #00334e;
            margin-bottom: 20px;
        }

        /* Inputs */
        .login-box input[type="text"], 
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Botones */
        .login-box .button-container {
            display: flex;
            justify-content: center; /* Centra los botones */
            gap: 20px; /* Espacio entre los botones */
        }

        .login-box button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100px; /* Establece un tamaño fijo para los botones */
        }

        .login-box .btn-login {
            background-color: #00334e;
            color: white;
        }

        .login-box .btn-login:hover {
            background-color: #00557a;
        }

        .login-box .btn-register {
            background-color: #ff4747;
            color: white;
        }

        .login-box .btn-register:hover {
            background-color: #d93c3c;
        }

        /* Enlace inferior */
        .login-box .footer-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .login-box .footer-link a {
            color: #00557a;
            text-decoration: none;
        }

        .login-box .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form action="login_verificacion.php" method="POST">
                <!-- Usuario -->
                <input type="text" name="username" placeholder="Usuario" required>
                <!-- Contraseña -->
                <input type="password" name="password" placeholder="Contraseña" required>
                <!-- Botones -->
                <div class="button-container">
                    <button type="submit" class="btn-login">Ingresar</button>
                    <button type="button" class="btn-register" onclick="location.href='register.php';">Registrar</button>
                </div>
            </form>
            <div class="footer-link">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
        </div>
    </div>
</body>
</html>
