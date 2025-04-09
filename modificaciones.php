<?php
session_start();
include('connection.php');

// Verificar si el usuario está logueado, si no redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Verificar si se han enviado datos para agregar una modificación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_mod'])) {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $nivel_mejora = $_POST['nivel_mejora'];
    $requisitos = $_POST['requisitos'];

    // Consulta SQL para insertar la modificación
    $insert_sql = "INSERT INTO modificaciones (nombre, tipo, descripcion, precio, nivel_mejora, requisitos) 
                   VALUES ('$nombre', '$tipo', '$descripcion', '$precio', '$nivel_mejora', '$requisitos')";
    
    if ($conn->query($insert_sql) === TRUE) {
      $success_msg = "Modificación agregada con éxito";
  } else {
      $error_msg = "Error: " . $conn->error;
  }
}

// Consultar modificaciones existentes
$sql = "SELECT * FROM modificaciones ORDER BY tipo, nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Modificaciones - Los Santos Autos</title>
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
    <h1>Agregar Modificaciones</h1>
  </header>

  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="catalogo.php">Agregar Vehículos</a>
    <a href="servicios.php">Agregar Servicios</a>
    <a href="agregar_usuario.php">Agregar Usuarios</a>
  </nav>

  <div class="content">
    <h2>Formulario para agregar modificaciones</h2>
    
    <?php if (isset($success_msg)): ?>
      <p class="success"><?php echo $success_msg; ?></p>
    <?php endif; ?>
    
    <?php if (isset($error_msg)): ?>
      <p class="error"><?php echo $error_msg; ?></p>
    <?php endif; ?>
    
    <div class="form-container">
      <form action="modificaciones.php" method="POST">
        <label for="nombre">Nombre de la modificación:</label>
        <input type="text" name="nombre" required>
        
        <label for="tipo">Tipo de modificación:</label>
        <select name="tipo" required>
          <option value="Motor">Motor</option>
          <option value="Suspensión">Suspensión</option>
          <option value="Frenos">Frenos</option>
          <option value="Transmisión">Transmisión</option>
          <option value="Turbo">Turbo</option>
          <option value="Neumáticos">Neumáticos</option>
          <option value="Carrocería">Carrocería</option>
          <option value="Pintura">Pintura</option>
          <option value="Ventanas">Ventanas</option>
          <option value="Adornos">Adornos</option>
          <option value="Luces">Luces</option>
          <option value="Placa">Placa</option>
          <option value="Escape">Escape</option>
          <option value="Capó">Capó</option>
          <option value="Parachoques">Parachoques</option>
          <option value="Alerón">Alerón</option>
          <option value="Volante">Volante</option>
          <option value="Radio">Radio</option>
          <option value="Hidráulica">Hidráulica</option>
          <option value="Nitrógeno">Nitrógeno</option>
          <option value="Blindaje">Blindaje</option>
          <option value="Tinte">Tinte de ventanas</option>
          <option value="Neón">Neón</option>
        </select>
        
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3" required></textarea>
        
        <label for="precio">Precio ($):</label>
        <input type="number" step="0.01" name="precio" required>
        
        <label for="nivel_mejora">Nivel de mejora (1-5):</label>
        <input type="number" name="nivel_mejora" min="1" max="5" required>
        
        <label for="requisitos">Requisitos (opcional):</label>
        <textarea name="requisitos" rows="2"></textarea>
        
        <button type="submit" name="add_mod">Agregar modificación</button>
      </form>
    </div>

    <h2>Modificaciones existentes</h2>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Nivel</th>
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
              <td><?php echo $row['nivel_mejora']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">No hay modificaciones registradas</td>
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