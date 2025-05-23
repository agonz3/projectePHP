<?php
session_start();
include('connection.php');

function esAdmin() {
    return isset($_SESSION['usuario']) && in_array($_SESSION['usuario'], ['admin', 'super']);
}

$sql = "SELECT * FROM coches";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Catálogo de Coches - Los Santos Autos</title>
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
      max-width: 1000px;
      margin: 0 auto;
      background-color: rgba(0, 0, 0, 0.75);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    }
    h2 {
      color: #ff6600;
      text-align: center;
      margin-bottom: 30px;
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
  <h1>Catálogo de Coches</h1>
</header>

<div class="content">
  <h2>Nuestros vehículos disponibles</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Modelo</th>
      <th>Marca</th>
      <th>Precio</th>
      <th>Color</th>
      <?php if (esAdmin()) { ?>
        <th>Acciones</th>
      <?php } ?>
    </tr>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['id_coche']); ?></td>
                <td><?php echo htmlspecialchars($fila['modelo']); ?></td>
                <td><?php echo htmlspecialchars($fila['marca']); ?></td>
                <td><?php echo htmlspecialchars($fila['precio']); ?> $</td>
                <td><?php echo htmlspecialchars($fila['color']); ?></td>
                <?php if (esAdmin()): ?>
                <td>
                    <a class="boton" href="editar_coche.php?id=<?php echo urlencode($fila['id_coche']); ?>">Editar</a>
                    <a class="boton" href="eliminar_coche.php?id=<?php echo urlencode($fila['id_coche']); ?>" onclick="return confirm('¿Seguro que quieres eliminar este coche?');">Eliminar</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?php echo esAdmin() ? 6 : 5; ?>">No hay coches en el catálogo.</td>
        </tr>
    <?php endif; ?>

  </table>
</div>

<footer>
  © 2025 Los Santos Autos. Todos los derechos reservados.
</footer>

</body>
</html>
