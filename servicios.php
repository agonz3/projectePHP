<?php
session_start();
include('connection.php');

// Verificar si el usuario está logueado, si no redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Verificar si se han enviado datos para agregar un servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_servicio'])) {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion_estimada = $_POST['duracion_estimada'];
    $tipo = $_POST['tipo'];

    // Consulta SQL para insertar el servicio
    $insert_sql = "INSERT INTO servicios (nombre, descripcion, precio, duracion_estimada, tipo) 
                   VALUES ('$nombre', '$descripcion', '$precio', '$duracion_estimada', '$tipo')";
    
    if ($conn->query($insert_sql) === TRUE) {
      $success_msg = "Servicio agregado con éxito";
  } else {
      $error_msg = "Error: " . $conn->error;
  }
}

// Consultar servicios existentes
$sql = "SELECT * FROM servicios ORDER BY tipo, nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Servicios - Los Santos Autos</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://gtamag.com/images/garage/los-santos-custom_gtao_887689_cover.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    header {
      background-color: rgba(0, 0, 0, 0.8);
      padding: 20px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 2.5em;
      letter-spacing: 2px;
      color: #ff6600;
    }

    .content {
      text-align: center;
      padding: 60px 20px;
      max-width: 900px;
      margin: 0 auto;
      background-color: rgba(0, 0, 0, 0.75);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    }

    .content h2 {
      color: #ff6600;
      font-size: 2em;
    }

    .form-container {
      background: rgba(0, 0, 0, 0.7);
      padding: 30px;
      border-radius: 8px;
      margin-top: 30px;
      width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .form-container input, 
    .form-container select, 
    .form-container textarea, 
    .form-container button {
      padding: 10px;
      margin: 10px 0;
      width: 100%;
      font-size: 1em;
      border-radius: 5px;
      border: none;
    }

    .form-container button {
      background-color: #ff6600;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color: #cc5200;
    }

    .success {
      color: #4CAF50;
      font-weight: bold;
    }

    .error {
      color: #f44336;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    table, th, td {
      border: 1px solid #444;
    }

    th {
      background-color: #ff6600;
      color: white;
      padding: 12px;
      text-align: left;
    }

    td {
      padding: 10px;
      background-color: rgba(0, 0, 0, 0.6);
    }

    tr:nth-child(even) {
      background-color: rgba(255, 102, 0, 0.1);
    }

    footer {
      background: rgba(0, 0, 0, 0.7);
      text-align: center;
      padding: 20px;
      color: #ccc;
      margin-top: 50px;
    }

    nav {
      background-color: rgba(0, 0, 0, 0.8);
      padding: 10px;
      text-align: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
    }

    nav a:hover {
      color: #ff6600;
    }
  </style>
</head>
<body>

  <header>
    <h1>Agregar Servicios</h1>
  </header>

  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="catalogo.php">Agregar Vehículos</a>
    <a href="modificaciones.php">Agregar Modificaciones</a>
    <a href="agregar_usuario.php">Agregar Usuarios</a>
  </nav>

  <div class="content">
    <h2>Formulario para agregar servicios</h2>
    
    <?php if (isset($success_msg)): ?>
      <p class="success"><?php echo $success_msg; ?></p>
    <?php endif; ?>
    
    <?php if (isset($error_msg)): ?>
      <p class="error"><?php echo $error_msg; ?></p>
    <?php endif; ?>
    
    <div class="form-container">
      <form action="servicios.php" method="POST">
        <label for="nombre">Nombre del servicio:</label>
        <input type="text" name="nombre" required>
        
        <label for="tipo">Tipo de servicio:</label>
        <select name="tipo" required>
          <option value="Mantenimiento">Mantenimiento</option>
          <option value="Reparación">Reparación</option>
          <option value="Personalización">Personalización</option>
          <option value="Limpieza">Limpieza</option>
          <option value="Seguridad">Seguridad</option>
          <option value="Otros">Otros</option>
        </select>
        
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3" required></textarea>
        
        <label for="precio">Precio ($):</label>
        <input type="number" step="0.01" name="precio" required>
        
        <label for="duracion_estimada">Duración estimada:</label>
        <input type="text" name="duracion_estimada" placeholder="Ej: 2 horas, 1 día" required>
        
        <button type="submit" name="add_servicio">Agregar servicio</button>
      </form>
    </div>

    <h2>Servicios existentes</h2>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Duración</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td><?php echo htmlspecialchars($row['tipo']); ?></td>
              <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
              <td>$<?php echo number_format($row['precio'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['duracion_estimada']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">No hay servicios registrados</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>