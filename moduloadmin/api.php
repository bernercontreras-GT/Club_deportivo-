<?php
require_once '../config/config.php';
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $res = $mysqli->query("SELECT s.ID AS id, u.Nombre AS nombre, s.Telefono AS telefono, s.Direccion AS direccion, s.fecha_ingreso, s.Numero_socio, 'activo' AS estado FROM socios s JOIN usuarios u ON s.id_usuario = u.ID");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($metodo === 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = limpiar($_POST['nombre']);
    $telefono = limpiar($_POST['telefono']);
    $direccion = limpiar($_POST['direccion']);
    $fecha = limpiar($_POST['fecha_ingreso']);
    $numero = limpiar($_POST['numero_socio']);

    if ($id) {
        // Actualizar socio
        $stmt = $mysqli->prepare("UPDATE socios SET Telefono=?, Direccion=?, fecha_ingreso=?, Numero_socio=? WHERE ID=?");
        $stmt->bind_param('sssii', $telefono, $direccion, $fecha, $numero, $id);
        $stmt->execute();

        // Actualizar nombre en usuarios
        $stmt2 = $mysqli->prepare("UPDATE usuarios SET Nombre=? WHERE ID=(SELECT id_usuario FROM socios WHERE ID=?)");
        $stmt2->bind_param('si', $nombre, $id);
        $stmt2->execute();

        echo json_encode(['mensaje' => 'Socio actualizado']);
    } else {
        // Crear usuario
        $email = $numero . '@club.com';
        $clave = '1234';
        $stmt = $mysqli->prepare("INSERT INTO usuarios (Nombre, Email, Clave, Rol) VALUES (?, ?, ?, 'socio')");
        $stmt->bind_param('sss', $nombre, $email, $clave);
        $stmt->execute();
        $id_usuario = $stmt->insert_id;

        // Crear socio
        $stmt2 = $mysqli->prepare("INSERT INTO socios (Numero_socio, Telefono, Direccion, fecha_ingreso, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param('iissi', $numero, $telefono, $direccion, $fecha, $id_usuario);
        $stmt2->execute();

        echo json_encode(['mensaje' => 'Socio registrado']);
    }
}

elseif ($metodo === 'DELETE') {
    $id = $_GET['id'] ?? 0;
    $stmt = $mysqli->prepare("DELETE FROM socios WHERE ID=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    echo json_encode(['mensaje' => 'Socio eliminado']);
}
