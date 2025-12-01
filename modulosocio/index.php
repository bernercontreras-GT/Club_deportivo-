<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'socio') {
    header('Location: ../auth/login.php');
    exit;
}

// Obtener nombre del usuario
$idUsuario = $_SESSION['usuario_id'];
$stmt = $mysqli->prepare("SELECT Nombre FROM usuarios WHERE ID = ?");
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$res = $stmt->get_result();
$nombre = $res->fetch_assoc()['Nombre'] ?? 'Socio';

// Fecha actual
setlocale(LC_TIME, 'es_ES.UTF-8');
$fecha = strftime('%d %B %Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Club Deportivo</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>

  <!-- Barra superior -->
  <header class="topbar">
    <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?> 👋</h1>
    <div class="fecha"><?php echo $fecha; ?></div>
    <div class="acciones">
      <span class="icono">🔔</span>
      <span class="icono">🙍</span>
    </div>
  </header>

  <!-- Menú lateral -->
  <nav class="sidebar">
    <ul>
      <li><a href="index.php">🏠 Inicio</a></li>
      <li><a href="reservas/reservas.php">📅 Reservas de instalaciones</a></li>
      <li><a href="eventos y actividades/eventos.php">📆 Eventos y actividades</a></li>
      <li><a href="../auth/logout.php">🚪 Salir</a></li>
    </ul>
  </nav>

  <!-- Contenido principal -->
  <main class="contenido">
    <h1>Inicio - Club</h1>

    <section class="grid">
      <a href="pagos/pagos.php" class="card">
        <h2>💳 Pagos</h2>
        <p>Consulta tus pagos y estado de cuenta.</p>
      </a>

      <a href="reservas/reservas.php" class="card">
        <h2>📅 Reservas</h2>
        <p>Gestiona tus reservas de instalaciones.</p>
      </a>

      <a href="notificaciones/notificaciones.php" class="card">
        <h2>🔔 Notificaciones</h2>
        <p>Revisa tus avisos y recordatorios.</p>
      </a>
    </section>
  </main>

</body>
</html>
