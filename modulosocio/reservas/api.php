<?php
require_once '../../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  if (isset($_GET['instalaciones'])) {
    $res = $mysqli->query("SELECT ID, Nombre FROM instalaciones");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
    exit;
  }

  $id = $_GET['id'] ?? 0;
  $sql = "SELECT r.ID, i.Nombre AS instalacion, r.Fecha_reserva AS fecha, r.Hora_inicio, r.Hora_fin
          FROM reservas r
          JOIN instalaciones i ON r.id_instalacion = i.ID
          JOIN socios s ON r.id_socio = s.ID
          JOIN usuarios u ON s.id_usuario = u.ID
          WHERE u.ID = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
  $idUsuario = $_POST['id_usuario'] ?? 0;
  $idInstalacion = $_POST['instalacion'] ?? 0;
  $fecha = $_POST['fecha'] ?? '';
  $horaInicio = $_POST['hora'] ?? '';
  $duracion = $_POST['duracion'] ?? 0;

  $res = $mysqli->query("SELECT ID FROM socios WHERE id_usuario = $idUsuario");
  $idSocio = $res->fetch_assoc()['ID'] ?? 0;

  // Calcular hora fin
  $inicio = new DateTime($horaInicio);
  $fin = clone $inicio;
  $fin->modify("+$duracion minutes");
  $horaFin = $fin->format('H:i');

  $stmt = $mysqli->prepare("INSERT INTO reservas (Fecha_reserva, Hora_inicio, Hora_fin, id_socio, id_instalacion) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param('sssii', $fecha, $horaInicio, $horaFin, $idSocio, $idInstalacion);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Reserva creada correctamente']);
}

elseif ($metodo === 'DELETE') {
  parse_str($_SERVER['QUERY_STRING'], $params);
  $id = $params['id'] ?? 0;

  $stmt = $mysqli->prepare("DELETE FROM reservas WHERE ID = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Reserva cancelada']);
}
