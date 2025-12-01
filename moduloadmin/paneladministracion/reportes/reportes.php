<?php
session_start();
require_once '../../../config/config.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportes</title>
  <link rel="stylesheet" href="reportes.css">
</head>
<body>

  <nav class="menu">
    <ul>
      <li><a href="../admin.php">← Volver al Panel</a></li>
    </ul>
  </nav>

  <section id="reportePagos">
  <h2>📄 Reporte de Pagos</h2>
  <label>Filtrar por estado:
    <select id="filtroEstado">
      <option value="todos">Todos</option>
      <option value="pagado">Pagado</option>
      <option value="pendiente">Pendiente</option>
      <option value="cancelado">Cancelado</option>
    </select>
  </label>

  <label>Filtrar por mes:
    <select id="filtroMes">
      <option value="todos">Todos</option>
      <option value="01">Enero</option>
      <option value="02">Febrero</option>
      <option value="03">Marzo</option>
      <option value="04">Abril</option>
      <option value="05">Mayo</option>
      <option value="06">Junio</option>
      <option value="07">Julio</option>
      <option value="08">Agosto</option>
      <option value="09">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select>
  </label>

  <button onclick="generarReportePagos()">Descargar CSV</button>
</section>


  <script src="reportes.js"></script>
</body>
</html>
