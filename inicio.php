<?php
// Habilitar visualización de errores (solo en entorno de desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión
require 'conexion.php';

// Filtro de búsqueda
$filtro = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta para obtener los datos de clientes y mascotas con filtro
$sql = "SELECT id, nombre, direccion, telefono, codigoMascota, nombreMascota, chip, entidadPeruana, estado 
        FROM clientesMascotas 
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

// Procesar la actualización del estado si se recibe un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'cambiar_estado') {
    $id_cliente = $_POST['id_cliente'];
    $nuevo_estado = $_POST['estado'];

    // Verificar que el estado no esté vacío antes de actualizar
    if (!empty($nuevo_estado)) {
        // Actualizar el estado en la base de datos
        $update_sql = "UPDATE clientesMascotas SET estado = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $nuevo_estado, $id_cliente);
        if ($stmt->execute()) {
            // Redirigir para evitar reenvío del formulario
            header("Location: inicio.php");
            exit;
        } else {
            die("Error al actualizar el estado: " . $stmt->error);
        }
    } else {
        die("El estado seleccionado no es válido.");
    }
}

// Procesar la eliminación de un cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    $id_cliente = $_POST['id_cliente'];

    // Eliminar el cliente de la base de datos
    $delete_sql = "DELETE FROM clientesMascotas WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id_cliente);
    if ($stmt->execute()) {
        header("Location: inicio.php");
        exit;
    } else {
        die("Error al eliminar el cliente: " . $stmt->error);
    }
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
        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
        .btn-cambiar-estado {
            background-color: #50E3C2;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-cambiar-estado:hover {
            background-color: #3CC2A4;
        }
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-bar input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
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

        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-content h4 {
            margin-bottom: 15px;
        }

        .checkbox-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .checkbox-container input[type="checkbox"] {
            transform: scale(0.8); /* Hacer los checkboxes más pequeños */
            margin-right: 10px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .btn-cambiar-estado {
            background-color: #50E3C2;
            color: white;
            border: none;
            padding: 8px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-cambiar-estado:hover {
            background-color: #3CC2A4;
        }

        .modal-content button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>QVet</h2>
    <ul>
        <li><a href="inicio.php">Clientes / Mascotas</a></li>
        <li><a href="formulario_cobrar_deuda.php">Cobrar deuda</a></li>
        <li><a href="formulario_historial_medico.php">Edición de documentos</a></li> <!-- Nuevo botón aquí -->
        <li><a href="sala_de_espera.php">Citas</a></li>
        <li><a href="#">Agenda</a></li>
        <li><a href="#">Caja</a></li>
    </ul>
</div>

    <div class="main-content">
        <div class="header">
            <h3>Clientes / Mascotas</h3>
        </div>
        
        <!-- Barra de búsqueda y botón Agregar -->
        <div class="search-bar">
            <form method="GET" action="inicio.php">
                <input type="text" name="buscar" placeholder="Buscar cliente o mascota..." value="<?php echo htmlspecialchars($filtro, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit">Buscar</button>
            </form>
            <button onclick="window.location.href='formulario.php'">Agregar</button>
        </div>

        <table class="result-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Código Mascota</th>
                    <th>Nombre Mascota</th>
                    <th>Chip</th>
                    <th>Entidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientesMascotas as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['direccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['codigoMascota'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['nombreMascota'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['chip'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['entidadPeruana'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <span id="estado<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['estado'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <button class="btn-cambiar-estado" onclick="openModal(<?php echo $cliente['id']; ?>, '<?php echo $cliente['estado']; ?>')">Cambiar Estado</button>
                        </td>
                        <td>
                            <form method="POST" action="inicio.php" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id']; ?>">
                                <button type="submit" class="delete-btn">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal para cambiar el estado -->
        <div class="modal" id="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h4>Cambiar Estado</h4>
                <form id="estadoForm" method="POST" action="inicio.php">
                    <input type="hidden" name="accion" value="cambiar_estado">
                    <input type="hidden" id="clienteId" name="id_cliente" value="">
                    <input type="hidden" id="estadoSeleccionado" name="estado" value="">
                    <div class="checkbox-container">
                        <div>
                            <input type="radio" id="estadoActivo" name="estado" value="Activo">
                            <label for="estadoActivo">Activo</label>
                        </div>
                        <div>
                            <input type="radio" id="estadoInactivo" name="estado" value="Inactivo">
                            <label for="estadoInactivo">Inactivo</label>
                        </div>
                    </div>
                    <button type="button" class="btn-cambiar-estado" onclick="guardarEstado()">Guardar</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openModal(id, estado) {
            document.getElementById('modal').style.display = 'flex';
            // Establecer el estado en el modal
            if (estado === 'Activo') {
                document.getElementById('estadoActivo').checked = true;
            } else {
                document.getElementById('estadoInactivo').checked = true;
            }
            document.getElementById('clienteId').value = id;
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function guardarEstado() {
            var estadoSeleccionado = document.querySelector('input[name="estado"]:checked').value;
            document.getElementById('estadoSeleccionado').value = estadoSeleccionado;
            document.getElementById('estadoForm').submit();
        }
    </script>
</body>
</html>
