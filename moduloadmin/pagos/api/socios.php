<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$res = $mysqli->query("SELECT s.ID AS id, u.Nombre AS nombre, s.numero_socio
                       FROM socios s
                       JOIN usuarios u ON s.id_usuario = u.ID");

echo json_encode($res->fetch_all(MYSQLI_ASSOC));