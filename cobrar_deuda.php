<?php
// Incluir el autoload generado por Composer
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Verificar si se reciben los parámetros correctos del formulario POST
if (isset($_POST['ruc'], $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $_POST['cliente'], $_POST['dni'])) {
    // Recibir los parámetros enviados por el formulario
    $ruc = htmlspecialchars($_POST['ruc']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $correo = htmlspecialchars($_POST['correo']);
    $cliente = htmlspecialchars($_POST['cliente']);
    $dni = htmlspecialchars($_POST['dni']);
    $fecha = date('d/m/Y');

    // Crear el contenido dinámico del PDF
    $html = '
    <h1>SALUDVET - Clínica Veterinaria</h1>
    <p>RUC: ' . $ruc . '<br>
       Dirección: ' . $direccion . '<br>
       Teléfono: ' . $telefono . '<br>
       Correo: ' . $correo . '<br>
    </p>
    <h2>BOLETA DE VENTA</h2>
    <p>N°: ____________________</p>
    <p>Fecha: ' . $fecha . '<br>
       Cliente: ' . $cliente . '<br>
       DNI: ' . ($dni ? $dni : '____________________') . '<br>
       Dirección: ' . ($direccion ? $direccion : '___________________________________________') . '</p>
    
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>P. Unitario (S/)</th>
                <th>Total (S/)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consulta veterinaria</td>
                <td>1</td>
                <td>50.00</td>
                <td>50.00</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> 50.00<br>
       <strong>IGV (18%):</strong> 9.00<br>
       <strong>Total a pagar:</strong> 59.00</p>

    <p><strong>Método de pago:</strong> Efectivo<br>
       <strong>Atendido por:</strong> Dr. Veterinario</p>

    <p>Gracias por confiar en SaludVet!<br>
       ¡Cuidamos a tus mascotas como a nuestra familia!</p>
    ';

    // Generar el PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream("Boleta_{$cliente}.pdf", array("Attachment" => false));

} else {
    echo "Por favor, complete todos los campos.";
}
?>
