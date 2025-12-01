<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$res = $mysqli->query("SELECT ID AS id, Nombre_membresia AS nombre, precio FROM membresias");

echo json_encode($res->fetch_all(MYSQLI_ASSOC));