<?php
// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir Dompdf
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario o asignar valores predeterminados
    $nombre_mascota = $_POST['nombre_mascota'] ?? 'No especificado';
    $especie = $_POST['especie'] ?? 'No especificado';
    $raza = $_POST['raza'] ?? 'No especificado';
    $sexo = $_POST['sexo'] ?? 'No especificado';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? 'No especificado';
    $color = $_POST['color'] ?? 'No especificado';

    $nombre_propietario = $_POST['nombre_propietario'] ?? 'No especificado';
    $telefono = $_POST['telefono'] ?? 'No especificado';


    $fecha_consulta = $_POST['fecha_consulta'] ?? 'No especificado';
    $motivo_consulta = $_POST['motivo_consulta'] ?? 'No especificado';
    $sintomas = $_POST['sintomas'] ?? 'No especificado';

    $peso = $_POST['peso'] ?? 'No especificado';
    $temperatura = $_POST['temperatura'] ?? 'No especificado';
    $frecuencia_card = $_POST['frecuencia_card'] ?? 'No especificado';
    $frecuencia_respir = $_POST['frecuencia_respir'] ?? 'No especificado';
    $condicion = $_POST['condicion'] ?? 'No especificado';
    $observaciones_examen = $_POST['observaciones_examen'] ?? 'No especificado';

    $vacunas = isset($_POST['vacunas']) ? implode(', ', $_POST['vacunas']) : 'Ninguna';
    $alergias = isset($_POST['alergias']) ? implode(', ', $_POST['alergias']) : 'Ninguna';

    // Crear el contenido HTML para el PDF
    $html = "
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        h1, h2 { text-align: center; color: #333; margin: 10px 0; }
        h1 { font-size: 24px; }
        h2 { font-size: 18px; border-bottom: 2px solid #e0e0e0; padding-bottom: 5px; margin-bottom: 15px; }
        table { width: 100%; margin-top: 10px; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; color: #333; font-weight: normal; }
        p { margin: 5px 0; color: #666; line-height: 1.5; }
        .footer { text-align: center; font-size: 12px; color: #aaa; margin-top: 20px; }
    </style>

    <div class='container'>
        <h1>Historial Médico de Mascota</h1>

        <h2>Información de la Mascota</h2>
        <table>
            <tr><th>Nombre</th><td>$nombre_mascota</td></tr>
            <tr><th>Especie</th><td>$especie</td></tr>
            <tr><th>Raza</th><td>$raza</td></tr>
            <tr><th>Sexo</th><td>$sexo</td></tr>
            <tr><th>Fecha de Nacimiento</th><td>$fecha_nacimiento</td></tr>
            <tr><th>Color</th><td>$color</td></tr>
        </table>

        <h2>Información del Propietario</h2>
        <table>
            <tr><th>Nombre</th><td>$nombre_propietario</td></tr>
            <tr><th>Teléfono</th><td>$telefono</td></tr>
        </table>

        <h2>Información Clínica</h2>
        <table>
            <tr><th>Fecha de Consulta</th><td>$fecha_consulta</td></tr>
            <tr><th>Motivo de la Consulta</th><td>$motivo_consulta</td></tr>
            <tr><th>Síntomas</th><td>$sintomas</td></tr>
        </table>

        <h2>Examen Físico</h2>
        <table>
            <tr><th>Peso</th><td>$peso kg</td></tr>
            <tr><th>Temperatura</th><td>$temperatura °C</td></tr>
            <tr><th>Frecuencia Cardíaca</th><td>$frecuencia_card lat/min</td></tr>
            <tr><th>Frecuencia Respiratoria</th><td>$frecuencia_respir resp/min</td></tr>
            <tr><th>Condición Corporal</th><td>$condicion</td></tr>
            <tr><th>Observaciones</th><td>$observaciones_examen</td></tr>
        </table>

        <h2>Vacunas y Tratamientos</h2>
        <p><strong>Vacunas:</strong> $vacunas</p>
        <p><strong>Alergias:</strong> $alergias</p>

        <div class='footer'>
            <p>&copy; 2024 Historial Médico de Mascota. Diseñado para simplicidad y claridad.</p>
        </div>
    </div>
    ";

    // Configuración de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    // Cargar contenido HTML
    $dompdf->loadHtml($html);

    // Establecer tamaño y orientación del papel
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar PDF
    $dompdf->render();

    // Enviar PDF al navegador
    $dompdf->stream("historial_medico.pdf", ["Attachment" => false]);
    exit();
}
?>
