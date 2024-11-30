<?php
require 'conexion.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Variables predefinidas
$ruc = "70829346517";
$telefono = "918382465";
$direccion = "AV Peru 115";
$correo = "saludvet@gmail.com";

// Obtener último número de boleta
$sql = "SELECT MAX(numero_boleta) AS ultimo_numero FROM boletas";
$result = $conn->query($sql);

$ultimoNumero = ($result && $row = $result->fetch_assoc()) ? ($row['ultimo_numero'] ?? 0) : 0;
$nuevoNumero = $ultimoNumero + 1;

// Procesar datos del formulario
$cliente = $_POST['cliente'];
$dni = $_POST['dni'] ?? '';
$subtotal = $_POST['subtotal'];
$igv = $_POST['igv'];
$total = $_POST['totalPagar'];
$metodo_pago = $_POST['metodo_pago'];
$atendido_por = $_POST['atendido_por'];

// Insertar en base de datos
$sql = "INSERT INTO boletas (numero_boleta, ruc, telefono, direccion, correo, cliente, dni, subtotal, igv, total, metodo_pago, atendido_por)
        VALUES ('$nuevoNumero', '$ruc', '$telefono', '$direccion', '$correo', '$cliente', '$dni', '$subtotal', '$igv', '$total', '$metodo_pago', '$atendido_por')";
$conn->query($sql);

// Generar PDF
$html = "
<h1>SALUDVET - Clínica Veterinaria</h1>
<p>RUC: $ruc<br>Dirección: $direccion<br>Teléfono: $telefono<br>Correo: $correo</p>
<h2>BOLETA DE VENTA</h2>
<p>N°: $nuevoNumero<br>Cliente: $cliente<br>DNI: $dni</p>
<table border='1' cellpadding='5'>
    <thead>
        <tr><th>Subtotal</th><th>IGV</th><th>Total</th></tr>
    </thead>
    <tbody>
        <tr><td>S/ $subtotal</td><td>S/ $igv</td><td>S/ $total</td></tr>
    </tbody>
</table>
<p>Método de Pago: $metodo_pago<br>Atendido por: $atendido_por</p>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("boleta_$nuevoNumero.pdf", ["Attachment" => false]);
?>
