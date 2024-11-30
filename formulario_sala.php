<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'Veterinaria';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Manejo del envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $codigoMascota = $_POST['codigoMascota'];
    $nombreMascota = $_POST['nombreMascota'];
    $fecha = $_POST['fecha'];
    $tipoConsulta = $_POST['tipoConsulta'];
    $horaInicio = $_POST['horaInicio'];
    $horaFinal = $_POST['horaFinal'];
    $duracion = $_POST['duracion'];

    $sql = "INSERT INTO saladeespera (nombre, telefono, codigoMascota, nombreMascota, fecha, tipoConsulta, horaInicio, horaFinal, duracion) 
            VALUES (:nombre, :telefono, :codigoMascota, :nombreMascota, :fecha, :tipoConsulta, :horaInicio, :horaFinal, :duracion)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':codigoMascota', $codigoMascota);
    $stmt->bindParam(':nombreMascota', $nombreMascota);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':tipoConsulta', $tipoConsulta);
    $stmt->bindParam(':horaInicio', $horaInicio);
    $stmt->bindParam(':horaFinal', $horaFinal);
    $stmt->bindParam(':duracion', $duracion);

    try {
        $stmt->execute();
        $mensaje = "Cita agregada exitosamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al agregar la cita: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Sala de Espera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 700px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        .form-group input, .form-group select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4A90E2;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #3C7ACF;
        }
        .message {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
    <script>
        function actualizarHoraFinal() {
            const tipoConsulta = document.getElementById('tipoConsulta').value;
            const horaInicio = document.getElementById('horaInicio').value;

            const duraciones = {
                "Consulta general": 30,
                "Vacunación/desparacitación": 20,
                "Diagnóstico o tratamiento específico": 60,
                "Emergencia": 120,
                "Procedimiento quirúrgico": 300
            };

            const duracion = duraciones[tipoConsulta] || 0;
            if (horaInicio) {
                const horaInicioDate = new Date(`1970-01-01T${horaInicio}:00`);
                horaInicioDate.setMinutes(horaInicioDate.getMinutes() + duracion);
                const horaFinal = horaInicioDate.toTimeString().split(" ")[0].substring(0, 5);
                document.getElementById('horaFinal').value = horaFinal;

                if (duracion > 60) {
                    const horas = Math.floor(duracion / 60);
                    const minutos = duracion % 60;
                    document.getElementById('duracion').value = `${horas} hora(s) ${minutos > 0 ? minutos + ' minuto(s)' : ''}`;
                } else {
                    document.getElementById('duracion').value = `${duracion} minutos`;
                }
            }
        }
    </script>
</head>
<body>
<div class="form-container">
    <h2>Agregar Cita</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre del Dueño</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono del Dueño</label>
                <input type="text" id="telefono" name="telefono">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="codigoMascota">Código de la Mascota</label>
                <input type="text" id="codigoMascota" name="codigoMascota">
            </div>
            <div class="form-group">
                <label for="nombreMascota">Nombre de la Mascota</label>
                <input type="text" id="nombreMascota" name="nombreMascota" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="fecha">Fecha de la consulta</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="tipoConsulta">Tipo de la Consulta</label>
                <select id="tipoConsulta" name="tipoConsulta" required onchange="actualizarHoraFinal()">
                    <option value="">Seleccione</option>
                    <option value="Consulta general">Consulta general</option>
                    <option value="Vacunación/desparacitación">Vacunación/desparacitación</option>
                    <option value="Diagnóstico o tratamiento específico">Diagnóstico o tratamiento específico</option>
                    <option value="Emergencia">Emergencia</option>
                    <option value="Procedimiento quirúrgico">Procedimiento quirúrgico</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="horaInicio">Hora de Inicio</label>
                <input type="time" id="horaInicio" name="horaInicio" required onchange="actualizarHoraFinal()">
            </div>
            <div class="form-group">
                <label for="horaFinal">Hora de Finalización</label>
                <input type="time" id="horaFinal" name="horaFinal" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="duracion">Duración de la consulta</label>
                <input type="text" id="duracion" name="duracion" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <button type="submit">Guardar</button>
            </div>
            <div class="form-group">
                <button type="button" onclick="window.location.href='sala_de_espera.php';">Ir a Sala de Espera</button>
            </div>
        </div>
    </form>
    <?php if (isset($mensaje)): ?>
        <div class="message <?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'success'; ?>">
            <?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
