<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

$sql = "SELECT n.Asunto AS asunto, n.Mensaje AS mensaje, DATE_FORMAT(n.Fecha_envio, '%d/%m/%Y') AS fecha
        FROM notificaciones n
        JOIN usuarios u ON n.id_usuario = u.ID
        WHERE u.ID = ?
        ORDER BY n.Fecha_envio DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

echo json_encode($res->fetch_all(MYSQLI_ASSOC));
