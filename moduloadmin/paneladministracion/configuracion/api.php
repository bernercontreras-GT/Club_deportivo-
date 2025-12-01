<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  $res = $mysqli->query("SELECT Nombre_club AS nombre_club, Moneda AS moneda, Horario AS horario, Logo AS logo FROM configuracion LIMIT 1");
  echo json_encode($res->fetch_assoc());
}

elseif ($metodo === 'POST') {
  $nombre = $_POST['nombre_club'] ?? '';
  $moneda = $_POST['moneda'] ?? '';
  $horario = $_POST['horario'] ?? '';

  $existe = $mysqli->query("SELECT ID, Logo FROM configuracion LIMIT 1")->fetch_assoc();

  // Manejo de logo
  $logo = $existe['Logo'] ?? '';
  if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . '_' . basename($_FILES['logo']['name']);
    $rutaDestino = '../../../assets/logos/' . $nombreArchivo;
    move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino);
    $logo = 'assets/logos/' . $nombreArchivo;
  }

  if ($existe) {
    $stmt = $mysqli->prepare("UPDATE configuracion SET Nombre_club = ?, Moneda = ?, Horario = ?, Logo = ? WHERE ID = ?");
    $stmt->bind_param('ssssi', $nombre, $moneda, $horario, $logo, $existe['ID']);
  } else {
    $stmt = $mysqli->prepare("INSERT INTO configuracion (Nombre_club, Moneda, Horario, Logo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $nombre, $moneda, $horario, $logo);
  }

  $stmt->execute();
  echo json_encode(['mensaje' => 'Configuración actualizada correctamente']);
}
