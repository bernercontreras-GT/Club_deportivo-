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
  <title>Configuraciones del Sistema</title>
  <link rel="stylesheet" href="configuracion.css">
</head>
<body>



  <nav class="menu">
    <ul>
      <li><a href="../admin.php">← Volver al Panel</a></li>
    </ul>
  </nav>

  <h1>Configuraciones Generales</h1>

  <section id="formulario">
    <form id="formConfig" enctype="multipart/form-data">
      <input type="text" name="nombre_club" placeholder="Nombre del club" >
      <input type="text" name="moneda" placeholder="Moneda (ej. Q, USD)" >
      <input type="text" name="horario" placeholder="Horario de atención (ej. 8:00 - 18:00)" >
      <input type="file" name="logo" accept="image/*">
      <button type="submit">Guardar cambios</button>
    </form>
    <div id="previewLogo"></div>
  </section>

  <script src="configuracion.js"></script>
</body>
</html>
