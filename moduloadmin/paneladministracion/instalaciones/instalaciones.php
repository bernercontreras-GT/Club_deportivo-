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
  <title>Gestión de Instalaciones</title>
  <link rel="stylesheet" href="instalaciones.css">
</head>
<body>

  <nav class="menu">
    <ul>
      <li><a href="../admin.php">← Volver al Panel</a></li>
    </ul>
  </nav>

  <h1>Gestión de Instalaciones</h1>

  <section id="formulario">
    <form id="formInstalacion">
      <h2 id="Tituloformulario">Crear instalaciones </h2>
      <input type="hidden" name="id" id="idinstalacion">
      <input type="text" name="nombre" placeholder="Nombre de la instalación" required>
      <textarea name="descripcion" placeholder="Descripción" rows="3" required></textarea>
      <input type="number" name="capacidad" placeholder="Capacidad máxima" required>
      <button type="submit" id="BTNGuardar">Registrar</button>
    </form>
  </section>

  <section id="tablaInstalaciones">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Capacidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenidoInstalaciones"></tbody>
    </table>
  </section>

  <script src="instalaciones.js"></script>
</body>
</html>

