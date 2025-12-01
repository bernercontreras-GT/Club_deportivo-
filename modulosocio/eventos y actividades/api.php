<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  if (isset($_GET['listar'])) {
    $res = $mysqli->query("SELECT ID, Titulo, Fecha FROM eventos WHERE Fecha >= CURDATE()");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
    exit;
  }

  $id = $_GET['id'] ?? 0;
  $sql = "SELECT e.ID, e.Titulo AS titulo, e.Descripcion AS descripcion, e.Fecha AS fecha, e.Hora AS hora,
                 EXISTS(SELECT 1 FROM inscripciones WHERE id_evento = e.ID AND id_usuario = ?) AS inscrito
          FROM eventos e
          ORDER BY e.Fecha ASC";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
  $idUsuario = $_POST['id_usuario'] ?? 0;
  $idEvento = $_POST['evento'] ?? 0;

  $stmt = $mysqli->prepare("INSERT IGNORE INTO inscripciones (id_usuario, id_evento) VALUES (?, ?)");
  $stmt->bind_param('ii', $idUsuario, $idEvento);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Inscripción registrada']);
}
