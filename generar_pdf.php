<?php
// Incluir el autoload generado por Composer
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Crear instancia de Dompdf
$dompdf = new Dompdf();

// HTML para el PDF
$html = '
<h1>SALUDVET - Clínica Veterinaria</h1>
<p>RUC: ____________________<br>
   Dirección: ___________________________________________<br>
   Teléfono: ____________________<br>
   Correo: ____________________<br>
</p>
<h2>BOLETA DE VENTA</h2>
<p>N°: ____________________</p>
<p>Fecha: ____________________<br>
   Cliente: ____________________<br>
   DNI: ____________________<br>
   Dirección: ___________________________________________</p>

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
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
        </tr>
        <tr>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
        </tr>
        <tr>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
        </tr>
        <tr>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
            <td>____________________</td>
        </tr>
    </tbody>
</table>

<p><strong>Subtotal:</strong> ____________________<br>
   <strong>IGV (18%):</strong> ____________________<br>
   <strong>Total a pagar:</strong> ____________________</p>

<p><strong>Método de pago:</strong> ____________________<br>
   <strong>Atendido por:</strong> ____________________</p>

<p>Gracias por confiar en SaludVet!<br>
   ¡Cuidamos a tus mascotas como a nuestra familia!</p>
';

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// (Opcional) Establecer tamaño y orientación de la página
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF (esta operación puede tardar un poco)
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream("boleta_de_venta.pdf", array("Attachment" => false));
?>
