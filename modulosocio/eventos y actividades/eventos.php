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
  <title>Eventos y Actividades</title>
  <link rel="stylesheet" href="eventos.css">
</head>
<body>

  <header class="encabezado">
    <h1>📆 Eventos y Actividades</h1>
    <a href="../index.php" class="volver">← Volver al inicio</a>
  </header>

  <section class="calendario" id="calendarioEventos">
    <!-- Aquí se cargan los eventos -->
  </section>

  <section class="formulario">
    <h2>Inscribirse a un evento</h2>
    <form id="formInscripcion">
      <select name="evento" required></select>
      <button type="submit">Inscribirme</button>
    </form>
  </section>

  <script>
    const usuarioId = <?php echo $idUsuario; ?>;
  </script>
  <script src="eventos.js"></script>
</body>
</html>
