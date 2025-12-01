<?php
session_start();
require_once '../config/config.php';

// Verificar si el usuario es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Socios</title>
  <link rel="stylesheet" href="gestionsocios.css">
</head>
<body>


<!-- Menú de navegación -->
  <nav class="menu">
    <ul>
      <li><a href="">Gestion de socios</a></li>
      <li><a href="pagos/pagos.php">Gestión de pagos</a></li>
      <li><a href="paneladministracion/admin.php">Panel de administración</a></li>
      <li><a href="../auth/logout.php">Salir</a></li>
    </ul>
  </nav>



  <h1>Gestión de Socios</h1>

  <section id="filtro">
    <label>Filtrar por estado:
      <select id="estadoFiltro">
        <option value="todos">Todos</option>
        <option value="activo">Activos</option>
        <option value="atrasado">Atrasados</option>
      </select>
    </label>
    <input type="text" id="busqueda" placeholder="Buscar por nombre o número">
  </section>

  <section id="tablaSocios">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>Ingreso</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenidoTabla"></tbody>
    </table>
  </section>

  <section id="formularioNuevo">
    <h2>Añadir nuevo socio</h2>
    <form id="formSocio" method="$_POST">
      <input type="hidden" name="id" id="idSocio">
      <input type="text" name="nombre" placeholder="Nombre completo" required>
      <input type="text" name="telefono" placeholder="Teléfono" required>
      <input type="text" name="direccion" placeholder="Dirección" required>
      <input type="date" name="fecha_ingreso" required>
      <input type="number" name="numero_socio" placeholder="Número de socio" >
      <button type="submit" id="btnGuardar" >Guardar</button>
    </form>
  </section>



  <script src="gestionsocios.js"></script>
</body>
</html>