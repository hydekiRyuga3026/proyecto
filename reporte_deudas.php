<?php
require 'vendor/autoload.php'; // Asegúrate de haber instalado PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Crear un nuevo documento de Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados de la clínica
    $sheet->setCellValue('A1', 'SALUDVET - Clínica Veterinaria');
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    $sheet->setCellValue('A2', 'RUC: ____________________');
    $sheet->mergeCells('A2:E2');

    $sheet->setCellValue('A3', 'Dirección: ___________________________________________');
    $sheet->mergeCells('A3:E3');

    $sheet->setCellValue('A4', 'Teléfono: ____________________');
    $sheet->mergeCells('A4:E4');

    $sheet->setCellValue('A5', 'Correo: ____________________');
    $sheet->mergeCells('A5:E5');

    // Boleta de venta
    $sheet->setCellValue('A7', 'BOLETA DE VENTA');
    $sheet->mergeCells('A7:E7');
    $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(12);

    $sheet->setCellValue('A8', 'N°: ____________________');
    $sheet->mergeCells('A8:E8');

    // Datos del cliente
    $sheet->setCellValue('A10', 'Fecha: ____________________');
    $sheet->mergeCells('A10:E10');

    $sheet->setCellValue('A11', 'Cliente: ____________________');
    $sheet->mergeCells('A11:E11');

    $sheet->setCellValue('A12', 'DNI: ____________________');
    $sheet->mergeCells('A12:E12');

    $sheet->setCellValue('A13', 'Dirección: ___________________________________________');
    $sheet->mergeCells('A13:E13');

    // Detalle de la boleta
    $sheet->setCellValue('A15', 'Descripción');
    $sheet->setCellValue('B15', 'Cantidad');
    $sheet->setCellValue('C15', 'P. Unitario (S/)');
    $sheet->setCellValue('D15', 'Total (S/)');

    // Agregar una fila de ejemplo (puedes llenarla dinámicamente)
    $sheet->setCellValue('A16', 'Consulta veterinaria');
    $sheet->setCellValue('B16', '1');
    $sheet->setCellValue('C16', '50.00');
    $sheet->setCellValue('D16', '50.00');

    // Totales
    $sheet->setCellValue('C18', 'Subtotal:');
    $sheet->setCellValue('D18', '50.00');

    $sheet->setCellValue('C19', 'IGV (18%):');
    $sheet->setCellValue('D19', '9.00');

    $sheet->setCellValue('C20', 'Total a pagar:');
    $sheet->setCellValue('D20', '59.00');

    // Otros datos
    $sheet->setCellValue('A22', 'Método de pago: ____________________');
    $sheet->mergeCells('A22:E22');

    $sheet->setCellValue('A23', 'Atendido por: ____________________');
    $sheet->mergeCells('A23:E23');

    // Mensaje de agradecimiento
    $sheet->setCellValue('A25', 'Gracias por confiar en SaludVet!');
    $sheet->mergeCells('A25:E25');
    $sheet->getStyle('A25')->getFont()->setBold(true);

    $sheet->setCellValue('A26', '¡Cuidamos a tus mascotas como a nuestra familia!');
    $sheet->mergeCells('A26:E26');

    // Ajustar tamaños de columnas automáticamente
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Generar el archivo Excel
    $writer = new Xlsx($spreadsheet);
    $filename = "Boleta_Venta_SaludVet.xlsx";

    // Enviar encabezados para la descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');

    // Guardar el archivo y enviarlo directamente al navegador
    $writer->save('php://output');

} catch (Exception $e) {
    // Capturar cualquier error y mostrar un mensaje
    echo "Error: " . $e->getMessage();
}
