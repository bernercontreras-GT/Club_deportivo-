<?php
session_start();
require_once '../../config/config.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
   header('Location: ./../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Pagos</title>
  <link rel="stylesheet" href="pagos.css">
</head>
<body>

<!-- Menú de navegación -->
  <nav class="menu">
    <ul>
      <li><a href="../../moduloadmin/gestionsocios.php">Gestion de socios</a></li>
      <li><a href="">Gestión de pagos</a></li>
      <li><a href="../paneladministracion/admin.php">Panel de administración</a></li>
      <li><a href="../../auth/logout.php">Salir</a></li>
    </ul>
  </nav>


  <h1>Gestión de Pagos</h1>

  <section id="resumen">
    <button onclick="generarReporte('pdf')">📄 Generar Reporte</button>
    <button onclick="generarReporte('excel')">📊 Exportar Excel</button>
    <label>Filtrar por estado:
      <select id="filtroEstado">
        <option value="todos">Todos</option>
        <option value="pagado">Pagado</option>
        <option value="pendiente">Pendiente</option>
        <option value="cancelado">Cancelado</option>
      </select>
    </label>
  </section>

  <section id="tablaPagos">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Socio</th>
          <th>Membresía</th>
          <th>Fecha</th>
          <th>Monto</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody id="contenidoPagos"></tbody>
    </table>
  </section>

  <section id="nuevoPago">
    <h2>Registrar nuevo pago</h2>
    <form id="formPago">
      <select name="id_socio" required></select>
      <select name="id_membresia" required></select>
      <input type="date" name="fecha_pago" required>
      <input type="number" name="monto" step="0.01" placeholder="Monto" required>
      <select name="estado" required>
        <option value="pagado">Pagado</option>
        <option value="pendiente">Pendiente</option>
        <option value="cancelado">Cancelado</option>
      </select>
      <button type="submit">Registrar</button>
    </form>
  </section>

  <script src="pagos.js"></script>
</body>
</html>

