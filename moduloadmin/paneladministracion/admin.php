php
<?php
session_start();
require_once '../../config/config.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}


$config = $mysqli->query("SELECT Nombre_club, Logo FROM configuracion LIMIT 1")->fetch_assoc();
$nombreClub = $config['Nombre_club'] ?? 'Club Deportivo';
$logoClub = $config['Logo'] ?? '';


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>



<header class="encabezado">
  <?php if ($logoClub): ?>
    <img src="../../<?php echo $logoClub; ?>" alt="Logo del club" class="logo">
  <?php endif; ?>
  <h1><?php echo $nombreClub; ?></h1>
</header>


  <!-- Menú de navegación -->
  <nav class="menu">
    <ul>
      <li><a href="/moduloadmin/gestionsocios.php">Gestion de socios </a></li>
      <li><a href="/moduloadmin/pagos/pagos.php">Gestión de pagos</a></li>
      <li><a href="">Panel de administración</a></li>
      <li><a href="../../auth/logout.php">Salir</a></li>
    </ul>
  </nav>

  <h1>Panel de Administración</h1>

  <section class="admin-grid">
    <a href="usuarios/usuarios.php" class="admin-card">
      <h2>👥 Usuarios</h2>
      <p>Gestionar cuentas, roles y accesos.</p>
    </a>

    <a href="instalaciones/instalaciones.php" class="admin-card">
      <h2>🏟️ Instalaciones</h2>
      <p>Registrar y administrar espacios físicos.</p>
    </a>

    <a href="membresias/membresias.php" class="admin-card">
      <h2>📋 Tipos de Membresía</h2>
      <p>Definir precios, duración y beneficios.</p>
    </a>

    <a href="reportes/reportes.php" class="admin-card">
      <h2>📊 Reportes</h2>
      <p>Generar informes financieros y de actividad.</p>
    </a>

    <a href="configuracion/configuracion.php" class="admin-card">
      <h2>⚙️ Configuraciones</h2>
      <p>Ajustes generales del sistema.</p>
    </a>
  </section>

</body>
</html>


