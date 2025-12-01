<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Buscar usuario
    $stmt = $mysqli->prepare("SELECT ID FROM usuarios WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $token = bin2hex(random_bytes(16)); // token seguro
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token en DB
        $stmt = $mysqli->prepare("UPDATE usuarios SET reset_token=?, reset_expira=? WHERE ID=?");
        $stmt->bind_param('ssi', $token, $expira, $user['ID']);
        $stmt->execute();

        // Enlace de reinicio
        $link = "http://localhost/auth/reset_password.php?token=$token";
        // Enviar correo (ejemplo simple)
        mail($email, "Reiniciar contraseña", "Haz clic aquí para reiniciar tu contraseña: $link");

        echo "Se envió un enlace de reinicio a tu correo.";
    } else {
        echo "Correo no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Olvidé mi contraseña</title></head>
<body>
  <h2>¿Olvidaste tu contraseña?</h2>
  <form method="POST">
    <input type="email" name="email" placeholder="Tu correo" required>
    <button type="submit">Enviar enlace</button>
  </form>
</body>
</html>
