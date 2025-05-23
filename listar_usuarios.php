<?php
session_start();
include('connection.php');

function esAdmin() {
    return isset($_SESSION['usuario']) && in_array($_SESSION['usuario'], ['admin', 'super']);
}

if (!esAdmin()) {
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Lista de Usuarios - Los Santos Autos</title>
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
      padding: 60px 20px;
      max-width: 700px;
      margin: 0 auto;
      background-color: rgba(0, 0, 0, 0.75);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    }
    h2 {
      color: #ff6600;
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #222;
      border-radius: 5px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #333;
    }
    th {
      background-color: #111;
      color: #ff6600;
    }
    tr:hover {
      background-color: #333;
    }
    a.boton {
      background-color: #ff6600;
      color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s;
    }
    a.boton:hover {
      background-color: #cc5200;
    }
    footer {
      background: rgba(0, 0, 0, 0.7);
      text-align: center;
      padding: 20px;
      color: #ccc;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<header>
  <h1>Gestión de Usuarios</h1>
</header>

<div class="content">
  <h2>Lista de Usuarios</h2>

  <a href="dashboard.php" class="boton" style="margin-bottom: 20px; display: inline-block;">Inicio</a>
  <a href="agregar_usuario.php" class="boton" style="margin-bottom: 20px; display: inline-block;">Agregar Usuario</a>

  <table>
    <tr>
      <th>ID</th>
      <th>Usuario</th>
      <th>Acciones</th>
    </tr>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['id_usuario']); ?></td>
                <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                <td>
                    <a class="boton" href="editar_usuario.php?id=<?php echo urlencode($fila['id_usuario']); ?>">Editar</a>
                    <a class="boton" href="eliminar_usuario.php?id=<?php echo urlencode($fila['id_usuario']); ?>" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No hay usuarios registrados.</td>
        </tr>
    <?php endif; ?>

  </table>
</div>

<footer>
  © 2025 Los Santos Autos. Todos los derechos reservados.
</footer>

</body>
</html>
