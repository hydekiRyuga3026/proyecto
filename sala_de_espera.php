<?php
// Habilitar visualización de errores (solo en entorno de desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión
require 'conexion.php';

// Filtro de búsqueda
$filtro = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta para obtener los datos de la tabla `saladeespera`
$sql = "SELECT id, nombre, telefono, codigoMascota, nombreMascota, tipoConsulta, fecha, horaInicio, horaFinal, duracion, estado 
        FROM saladeespera 
        WHERE nombre LIKE ? OR nombreMascota LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = "%$filtro%";
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

// Procesar los resultados de la consulta
$clientesMascotas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientesMascotas[] = $row;
    }
}

// Actualizar el estado si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $update_sql = "UPDATE saladeespera SET estado = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $estado, $id);
    $update_stmt->execute();
    header("Location: sala_de_espera.php"); // Recargar la página
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QVet Interface</title>
    <style>
        /* Estilos principales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .sidebar {
            width: 250px;
            background-color: #4A90E2;
            color: #fff;
            height: 100vh;
            position: fixed;
            padding: 20px 0;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .sidebar ul li:hover {
            background-color: #5DA6E8;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e0e0e0;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
        }
        .result-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .result-table th, .result-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .result-table th {
            background-color: #4A90E2;
            color: #fff;
        }
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-bar input[type="text"], .search-bar select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 10px 20px;
            background-color: #50E3C2;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #3CC2A4;
        }
        .state-select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>QVet</h2>
    <ul>
        <li><a href="inicio.php">Clientes / Mascotas</a></li>
        <li><a href="formulario_cobrar_deuda.php">Cobrar deuda</a></li>
        <li><a href="formulario_historial_medico.php">Edición de documentos</a></li>
        <li><a href="sala_de_espera.php">Citas</a></li>
        <li><a href="#">Agenda</a></li>
        <li><a href="#">Caja</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h3>Citas</h3>
    </div>
    
    <!-- Barra de búsqueda -->
    <div class="search-bar">
        <form method="GET" action="sala_de_espera.php">
            <input type="text" name="buscar" placeholder="Buscar cliente o mascota..." value="<?php echo htmlspecialchars($filtro, ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit">Buscar</button>
        </form>
        <button onclick="window.location.href='formulario_sala.php'">Agregar</button>
    </div>

    <!-- Tabla de resultados -->
    <table class="result-table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Código Mascota</th>
                <th>Nombre Mascota</th>
                <th>Tipo de Consulta</th>
                <th>Fecha</th>
                <th>Hora de Inicio</th>
                <th>Hora de Final</th>
                <th>Duración</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientesMascotas as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['codigoMascota'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['nombreMascota'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['tipoConsulta'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($cliente['fecha'])), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['horaInicio'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['horaFinal'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['duracion'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <form method="POST" action="sala_de_espera.php">
                            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                            <select name="estado" class="state-select" onchange="this.form.submit()">
                                <option value="Pendiente" <?php echo $cliente['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="Atendido" <?php echo $cliente['estado'] === 'Atendido' ? 'selected' : ''; ?>>Atendido</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
