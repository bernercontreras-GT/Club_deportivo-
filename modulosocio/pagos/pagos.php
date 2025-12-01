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
  <title>Mis Pagos</title>
  <link rel="stylesheet" href="pagos.css">
</head>
<body>

  <header class="encabezado">
    <h1>💳 Historial de Pagos</h1>
    <a href="../index.php" class="volver">← Volver al inicio</a>
  </header>

  <section class="tabla-pagos">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Membresía</th>
          <th>Monto</th>
          <th>Fecha</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody id="contenidoPagos"></tbody>
    </table>
  </section>

  <script>
    const usuarioId = <?php echo $idUsuario; ?>;
  </script>
  <script src="pagos.js"></script>
</body>
</html>
