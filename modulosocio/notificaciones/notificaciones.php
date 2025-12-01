<?php
session_start();
require_once '../../config/config.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'socio') {
    header('Location: ../../auth/login.php');
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Notificaciones</title>
  <link rel="stylesheet" href="notificaciones.css">
</head>
<body>

  <header class="encabezado">
    <h1>🔔 Mis Notificaciones</h1>
    <a href="../index.php" class="volver">← Volver al inicio</a>
  </header>

  <section class="lista-notificaciones" id="contenedorNotificaciones">
    <!-- Aquí se cargan las notificaciones -->
  </section>

  <script>
    const usuarioId = <?php echo $idUsuario; ?>;
  </script>
  <script src="notificaciones.js"></script>
</body>
</html>
