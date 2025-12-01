<?php

require_once '../../config/config.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

$sql = "SELECT m.Nombre_membresia AS membresia, p.Monto AS monto, p.Fecha_pago AS fecha, p.Estado AS estado
        FROM pagos p
        JOIN socios s ON p.id_socio = s.ID
        JOIN usuarios u ON s.id_usuario = u.ID
        JOIN membresias m ON p.id_membresia = m.ID
        WHERE u.ID = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

echo json_encode($res->fetch_all(MYSQLI_ASSOC));

