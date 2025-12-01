<?php
session_start();
require_once '../config/config.php';
//verificaremos si no exite una sesion abierta, solamente redirija a los usuarios activos al archivo ../modulosocio/index caso contrario al archivo login

  if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === 'socio') {
        header('Location: ../modulosocio/index.php');
        exit;
    } elseif ($_SESSION['rol'] === 'admin') {
        header('Location: ../moduloadmin/gestionsocios.php');
        exit;
    }
}

// Variable para guardar mensajes de error (ej: usuario no encontrado, contraseña incorrecta)
$mensaje = '';

// Si el formulario fue enviado con método POST (cuando el usuario presiona "Entrar")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos el email ingresado, si no existe se asigna cadena vacía
    $email = $_POST['email'] ?? '';
    // Obtenemos la contraseña ingresada, si no existe se asigna cadena vacía
    $password = $_POST['password'] ?? '';

    // Preparamos consulta SQL para buscar al usuario en la base de datos por email
    $stmt = $mysqli->prepare("SELECT id, Clave, rol FROM usuarios WHERE email=?");
    // Vinculamos el parámetro (s = string)
    $stmt->bind_param('s',$email);
    // Ejecutamos la consulta
    $stmt->execute();
    // Obtenemos el resultado
    $res = $stmt->get_result();

    // Si encontramos un registro en la base de datos
    if ($row = $res->fetch_assoc()) {
        // Comparación directa de contraseñas ( insegura, solo para uso educativo)
        if (password_verify($password, $row['Clave'])) {
            // Guardamos datos importantes en la sesión
            $_SESSION['usuario_id'] = $row['id'];   // ID del usuario
            $_SESSION['rol'] = $row['rol'];         // Rol del usuario (ej. admin, cliente)
            
            // Redirigimos al dashboard
            if ($_SESSION['rol'] === 'socio') {
          header('Location: ../modulosocio/index.php');
         } elseif ($_SESSION['rol'] === 'admin') {
           header('Location: ../moduloadmin/gestionsocios.php');
          }


        } else {
            // Si la contraseña no coincide
            $mensaje = 'Contraseña incorrecta';
        }
    } else {
        // Si no existe el usuario con ese email
        $mensaje = 'Usuario no encontrado';
    }


}


?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"> <!-- Codificación UTF-8 -->
<title>Inicar sesión 💻</title> <!-- Título de la pestaña -->
<link rel="stylesheet" href="login.css"> <!-- Hoja de estilos -->
</head>
<body>
<div class="container">
  <div class="card">
    <h1>Iniciar Sesión</h1>

    <!-- Si existe un mensaje de error, lo mostramos en rojo -->
    <?php if($mensaje): ?>
      <p style="color:red;"><?= limpiar($mensaje) ?></p>
    <?php endif; ?>

    <!-- Formulario de login -->
    <form method="post">
      <!-- Campo para el email -->
      <label>Email:<br><input type="email" name="email" required></label><br>
      <!-- Campo para la contraseña -->
      <label>Contraseña:<br><input type="password" name="password" required></label><br><br>
      <!-- Botón para enviar -->
      <button type="submit" class="btn primary">Entrar</button>
    </form>

    <p style="margin-top:10px;">
  <a href="../auth/forgot_password.php">¿Olvidaste tu contraseña?</a>
</p>
  </div>
</div>
</body>
</html>

