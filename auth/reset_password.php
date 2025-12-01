<?php
require_once '../config/config.php';

$token = $_GET['token'] ?? '';

$stmt = $mysqli->prepare("SELECT ID FROM usuarios WHERE reset_token=? AND reset_expira > NOW()");
$stmt->bind_param('s', $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Token inválido o expirado.");
}
$user = $res->fetch_assoc();

// Si envió nueva contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("UPDATE usuarios SET password=?, reset_token=NULL, reset_expira=NULL WHERE ID=?");
    $stmt->bind_param('si', $password, $id);
    $stmt->execute();

    echo "Contraseña actualizada correctamente.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Reiniciar contraseña</title></head>
<body>
  <h2>Reiniciar contraseña</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= $user['ID'] ?>">
    <input type="password" name="password" placeholder="Nueva contraseña" required>
    <button type="submit">Actualizar contraseña</button>
  </form>
</body>
</html>
