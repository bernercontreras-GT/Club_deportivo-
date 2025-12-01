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
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="usuarios.css">
</head>
<body>

  <nav class="menu">
    <ul>
      <li><a href="../admin.php">← Volver al Panel</a></li>
    </ul>
  </nav>

  <h1>Gestión de Usuarios</h1>

  <section id="formulario">
    <form id="formUsuario">
      <input type="text" name="nombre" placeholder="Nombre completo" required>
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <select name="rol" required>
        <option value="">Seleccione rol</option>
        <option value="admin">Administrador</option>
        <option value="socio">Socio</option>
      </select>
      <input type="password" name="clave" placeholder="Contraseña" >

      <input type="hidden" name="id" id="idusuario">

      <button type="submit" id="btnGuardar">Registrar</button>
    </form>
  </section>

  <section id="tablaUsuarios">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenidoUsuarios"></tbody>
    </table>
  </section>

  <script src="usuarios.js"></script>
</body>
</html>

