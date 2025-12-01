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
  <title>Gestión de Membresías</title>
  <link rel="stylesheet" href="membresias.css">
</head>
<body>

  <nav class="menu">
    <ul>
      <li><a href="../admin.php">← Volver al Panel</a></li>
    </ul>
  </nav>

  <h1>Gestión de Tipos de Membresía</h1>

  <section id="formulario">
    <form id="formMembresia">
      <h2 id="Tituloformulario">Crear Membresia </h2>
      <input type="hidden" name="id" id="idmembresia">
      <input type="text" name="nombre" placeholder="Nombre de la membresía" required>
      <textarea name="descripcion" placeholder="Descripción" rows="3" required></textarea>
      <input type="number" name="precio" placeholder="Precio (Q)" step="0.01" required>
      <button type="submit" id="BTNGuardar">Registrar</button>
    </form>
  </section>

  <section id="tablaMembresias">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenidoMembresias"></tbody>
    </table>
  </section>

  <script src="membresias.js"></script>
</body>
</html>
