<?php
require_once '../../../config/config.php';

$estado = $_GET['estado'] ?? 'todos';
$mes = $_GET['mes'] ?? 'todos';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="reporte_pagos.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['#', 'Socio', 'Membresía', 'Fecha', 'Monto', 'Estado']);

$sql = "SELECT u.Nombre AS socio, m.Nombre_membresia AS membresia, p.Fecha_pago, p.Monto, p.Estado
        FROM pagos p
        JOIN socios s ON p.id_socio = s.ID
        JOIN usuarios u ON s.id_usuario = u.ID
        JOIN membresias m ON p.id_membresia = m.ID
        WHERE 1=1";

if ($estado !== 'todos') {
    $sql .= " AND p.Estado = '" . $mysqli->real_escape_string($estado) . "'";
}

if ($mes !== 'todos') {
    $sql .= " AND MONTH(p.Fecha_pago) = " . intval($mes);
}

$res = $mysqli->query($sql);
$i = 1;
while ($row = $res->fetch_assoc()) {
    fputcsv($output, [$i++, $row['socio'], $row['membresia'], $row['Fecha_pago'], $row['Monto'], $row['Estado']]);
}
fclose($output);

