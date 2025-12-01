<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  $res = $mysqli->query("SELECT ID AS id, Nombre AS nombre, Descripcion AS descripcion, capacidad FROM instalaciones");
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
  $id = $_POST['id'] ?? null ; 
  $nombre = $_POST['nombre'] ?? '';
  $descripcion = $_POST['descripcion'] ?? '';
  $capacidad = $_POST['capacidad'] ?? 0;


  if($id){
    $stmt = $mysqli ->prepare("UPDATE instalaciones SET Nombre =?, Descripcion =?, capacidad=? WHERE ID=?");
    $stmt->bind_param('ssii', $nombre,$descripcion,$capacidad,$id);
    $stmt->execute();

    echo json_encode(['mensaje' => 'Instalacion actualizada']);
  }
  else {
  $stmt = $mysqli->prepare("INSERT INTO instalaciones (Nombre, Descripcion, capacidad) VALUES (?, ?, ?)");
  $stmt->bind_param('ssi', $nombre, $descripcion, $capacidad);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Instalación registrada correctamente']);
  }
}

elseif ($metodo === 'DELETE') {
  parse_str(file_get_contents("php://input"), $data);
  $id = $data['id'] ?? 0;

  $stmt = $mysqli->prepare("DELETE FROM instalaciones WHERE ID = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Instalación eliminada']);
}
