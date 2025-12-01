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
  <title>Reservas</title>
  <link rel="stylesheet" href="reservas.css">
</head>
<body>

  <header class="encabezado">
    <h1>📅 Mis Reservas</h1>
    <a href="../index.php" class="volver">← Volver al inicio</a>
  </header>

  <section class="formulario">
    <h2>Crear nueva reserva</h2>
    <form id="formReserva">
      <select name="instalacion" ></select>
      <input type="date" name="fecha" required>
      <input type="time" name="hora" required>
      <input type="number" name="duracion" placeholder="Duración en minutos" required>
      <button type="submit">Reservar</button>
    </form>
  </section>

  <section class="tabla-reservas">
    <h2>Reservas registradas</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Instalación</th>
          <th>Fecha</th>
          <th>Hora inicio</th>
          <th>Hora fin</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody id="contenidoReservas"></tbody>
    </table>
  </section>

  <script>
    const usuarioId = <?php echo $idUsuario; ?>;
  </script>
  <script src="reservas.js"></script>
</body>
</html>
