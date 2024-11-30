<?php
require 'vendor/autoload.php'; // Asegúrate de que Dompdf esté instalado

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre_mascota = $_POST['nombre_mascota'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $color = $_POST['color'];
    
    $nombre_propietario = $_POST['nombre_propietario'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    
    $fecha_consulta = $_POST['fecha_consulta'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $sintomas = $_POST['sintomas'];
    
    $peso = $_POST['peso'];
    $temperatura = $_POST['temperatura'];
    $frecuencia_card = $_POST['frecuencia_card'];
    $frecuencia_respir = $_POST['frecuencia_respir'];
    $condicion = $_POST['condicion'];
    $observaciones_examen = $_POST['observaciones_examen'];
    
    $vacunas = isset($_POST['vacunas']) ? implode(', ', $_POST['vacunas']) : 'Ninguna';
    $desparasitaciones = $_POST['desparasitaciones'];
    $alergias = isset($_POST['alergias']) ? implode(', ', $_POST['alergias']) : 'Ninguna';
    $enfermedades = isset($_POST['enfermedades']) ? implode(', ', $_POST['enfermedades']) : 'Ninguna';
    $tratamientos_previos = $_POST['tratamientos_previos'];

    // Crear el contenido HTML para el PDF
    $html = "
    <h1 style='text-align: center;'>Historial Médico de Mascota</h1>
    <h2>Información de la Mascota</h2>
    <p><strong>Nombre:</strong> $nombre_mascota</p>
    <p><strong>Especie:</strong> $especie</p>
    <p><strong>Raza:</strong> $raza</p>
    <p><strong>Sexo:</strong> $sexo</p>
    <p><strong>Fecha de Nacimiento:</strong> $fecha_nacimiento</p>
    <p><strong>Color:</strong> $color</p>
    
    <h2>Información del Propietario</h2>
    <p><strong>Nombre:</strong> $nombre_propietario</p>
    <p><strong>Teléfono:</strong> $telefono</p>
    <p><strong>Dirección:</strong> $direccion</p>
    <p><strong>Correo Electrónico:</strong> $correo</p>
    
    <h2>Información Clínica</h2>
    <p><strong>Fecha de Consulta:</strong> $fecha_consulta</p>
    <p><strong>Motivo de la Consulta:</strong> $motivo_consulta</p>
    <p><strong>Síntomas:</strong> $sintomas</p>
    
    <h2>Examen Físico</h2>
    <p><strong>Peso:</strong> $peso kg</p>
    <p><strong>Temperatura:</strong> $temperatura °C</p>
    <p><strong>Frecuencia Cardíaca:</strong> $frecuencia_card latidos/min</p>
    <p><strong>Frecuencia Respiratoria:</strong> $frecuencia_respir respiraciones/min</p>
    <p><strong>Condición Corporal:</strong> $condicion</p>
    <p><strong>Observaciones:</strong> $observaciones_examen</p>
    
    <h2>Vacunas</h2>
    <p>$vacunas</p>
    
    <h2>Desparasitaciones</h2>
    <p>$desparasitaciones</p>
    
    <h2>Alergias</h2>
    <p>$alergias</p>
    
    <h2>Enfermedades</h2>
    <p>$enfermedades</p>";

    // Opciones de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Descargar o mostrar el PDF
    $dompdf->stream("historial_medico.pdf", ["Attachment" => false]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Historial Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e3d58;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Asegura que se alinee al inicio */
            height: 100vh;
            padding-top: 50px; /* Aumentar considerablemente el espacio superior */
        }
        .form-container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            color: #333;
            display: flex;
            flex-direction: column;
        }
        .form-content {
            flex-grow: 1; /* Permite que el contenido ocupe el espacio restante */
        }
        h1, h3 {
            text-align: center;
            color: #1e3d58;
        }
        label {
            font-size: 1em;
            margin-top: 10px;
            display: block;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #4CAF50;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            margin-top: 20px; /* Espaciado superior del botón */
        }
        button:hover {
            background-color: #45a049;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        .checkbox-group label {
            display: flex;
            align-items: center;
            width: 48%;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .form-row div {
            flex: 1;
            min-width: 45%;
        }
        .section-title {
            background-color: #1e3d58;
            color: #fff;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .checkbox-group.double-column {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-content">
            <h1>Formulario de Historial Médico</h1>
            <form method="POST" action="generar_pdf_historial.php">
                <!-- Información de la Mascota -->
                <div class="section-title">Información de la Mascota</div>
                <div class="form-row">
                    <div>
                        <label for="nombre_mascota">Nombre:</label>
                        <input type="text" id="nombre_mascota" name="nombre_mascota" placeholder="Ej. Firulais" required>
                    </div>
                    <div>
                        <label for="especie">Especie:</label>
                        <input type="text" id="especie" name="especie" placeholder="Ej. Perro, Gato" required>
                    </div>
                    <div>
                        <label for="raza">Raza:</label>
                        <input type="text" id="raza" name="raza" placeholder="Ej. Labrador, Siames">
                    </div>
                    <div>
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                    </div>
                    <div>
                        <label for="color">Color:</label>
                        <input type="text" id="color" name="color" placeholder="Ej. Blanco, Marrón">
                    </div>
                    <div>
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" required>
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </div>
                </div>
                <!-- Información del Propietario -->
                <div class="section-title">Información del Propietario</div>
                <div class="form-row">
                    <div>
                        <label for="nombre_propietario">Nombre:</label>
                        <input type="text" id="nombre_propietario" name="nombre_propietario" required>
                    </div>
                    <div>
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" required>
                    </div>
                </div>
                <!-- Información Clínica -->
                <div class="section-title">Información Clínica</div>
                <div class="form-row">
                    <div>
                        <label for="fecha_consulta">Fecha de Consulta:</label>
                        <input type="date" id="fecha_consulta" name="fecha_consulta">
                    </div>
                    <div>
                        <label for="motivo_consulta">Motivo de la Consulta:</label>
                        <textarea id="motivo_consulta" name="motivo_consulta"></textarea>
                    </div>
                    <div>
                        <label for="sintomas">Síntomas:</label>
                        <textarea id="sintomas" name="sintomas"></textarea>
                    </div>
                </div>
                <!-- Examen Físico -->
                <div class="section-title">Examen Físico</div>
                <div class="form-row">
                    <div>
                        <label for="peso">Peso:</label>
                        <input type="number" id="peso" name="peso" placeholder="kg">
                    </div>
                    <div>
                        <label for="temperatura">Temperatura:</label>
                        <input type="number" id="temperatura" name="temperatura" placeholder="°C">
                    </div>
                    <div>
                        <label for="frecuencia_card">Frecuencia Cardíaca:</label>
                        <input type="number" id="frecuencia_card" name="frecuencia_card" placeholder="lat/min">
                    </div>
                    <div>
                        <label for="frecuencia_respir">Frecuencia Respiratoria:</label>
                        <input type="number" id="frecuencia_respir" name="frecuencia_respir" placeholder="resp/min">
                    </div>
                    <div>
                        <label for="condicion">Condición Corporal:</label>
                        <input type="text" id="condicion" name="condicion">
                    </div>
                </div>
                <!-- Vacunas -->
                <div class="section-title">Vacunas</div>
                <div class="checkbox-group double-column">
                    <label><input type="checkbox" name="vacunas[]" value="Parvovirus"> Parvovirus</label>
                    <label><input type="checkbox" name="vacunas[]" value="Leptospirosis"> Leptospirosis</label>
                    <label><input type="checkbox" name="vacunas[]" value="Rabia"> Rabia</label>
                    <label><input type="checkbox" name="vacunas[]" value="Hepatitis"> Hepatitis</label>
                </div>
                <!-- Alergias -->
                <div class="section-title">Alergias</div>
                <div class="checkbox-group double-column">
                    <label><input type="checkbox" name="alergias[]" value="Alimentos"> Alimentos</label>
                    <label><input type="checkbox" name="alergias[]" value="Ambientales"> Ambientales</label>
                    <label><input type="checkbox" name="alergias[]" value="Picaduras de insectos"> Picaduras de insectos</label>
                    <label><input type="checkbox" name="alergias[]" value="Por contacto"> Por contacto</label>
                    <label><input type="checkbox" name="alergias[]" value="Medicamentos"> Medicamentos</label>
                    <label><input type="checkbox" name="alergias[]" value="Perfumes y productos químicos"> Perfumes y productos químicos</label>
                </div>
                <!-- Botón de Envío -->
                <button type="submit">Generar PDF</button>
            </form>
        </div>
    </div>
</body>
</html>

