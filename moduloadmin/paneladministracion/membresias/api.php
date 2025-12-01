<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  $res = $mysqli->query("SELECT ID AS id, Nombre_membresia AS nombre, Descripcion AS descripcion, Precio AS precio FROM membresias");
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
  $id = $_POST['id'] ?? null ;
  $nombre = $_POST['nombre'] ?? '';
  $descripcion = $_POST['descripcion'] ?? '';
  $precio = $_POST['precio'] ?? 0;

 if($id){
    $stmt = $mysqli ->prepare("UPDATE membresias SET Nombre_membresia =?,Descripcion =? , Precio =? Where ID = ?");
    $stmt->bind_param('ssdi', $nombre,$descripcion,$precio,$id);
    $stmt->execute();
    
    echo json_encode(['mensaje' => 'Membresia editada correctamente']);

  }

  else{
  $stmt = $mysqli->prepare("INSERT INTO membresias (Nombre_membresia, Descripcion, Precio) VALUES (?, ?, ?)");
  $stmt->bind_param('ssd', $nombre, $descripcion, $precio);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Membresía registrada correctamente']);
   }
}

elseif ($metodo === 'DELETE') {
  parse_str(file_get_contents("php://input"), $data);
  $id = $data['id'] ?? 0;

  $stmt = $mysqli->prepare("DELETE FROM membresias WHERE ID = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Membresía eliminada']);
}


