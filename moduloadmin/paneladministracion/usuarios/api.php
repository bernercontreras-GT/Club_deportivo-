<?php
require_once '../../../config/config.php';
header('Content-Type: application/json');


$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
  $res = $mysqli->query("SELECT ID AS id, Nombre AS nombre, Email AS correo, Rol AS rol, Clave AS clave FROM usuarios");
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
    $id     = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $rol    = $_POST['rol'] ?? '';
    $clavePlano = $_POST['clave'] ?? '';

    if ($id) {
        // --- UPDATE ---
        if ($clavePlano !== '') {
            // Si se envía una nueva clave, la actualizamos
            $claveHash = password_hash($clavePlano, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE usuarios SET Nombre=?, Email=?, Clave=?, Rol=? WHERE ID=?");
            $stmt->bind_param('ssssi', $nombre, $correo, $claveHash, $rol, $id);
        } else {
            // Si no se envía clave, no la tocamos
            $stmt = $mysqli->prepare("UPDATE usuarios SET Nombre=?, Email=?, Rol=? WHERE ID=?");
            $stmt->bind_param('sssi', $nombre, $correo, $rol, $id);
        }

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['mensaje' => 'Usuario actualizado']);
        } else {
            echo json_encode(['error' => 'No se pudo actualizar el usuario']);
        }
        exit; // 👈 importante: salir después de responder
    } else {
        // --- INSERT ---
        $claveHash = password_hash($clavePlano, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO usuarios (Nombre, Email, Rol, Clave) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $nombre, $correo, $rol, $claveHash);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['mensaje' => 'Usuario registrado correctamente']);
        } else {
            echo json_encode(['error' => 'No se pudo registrar el usuario']);
        }
        exit; // 👈 salir después de responder
    }

}

elseif ($metodo === 'DELETE') {
  parse_str(file_get_contents("php://input"), $data);
  $id = $data['id'] ?? 0;

  $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE ID = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  echo json_encode(['mensaje' => 'Usuario eliminado']);
}
