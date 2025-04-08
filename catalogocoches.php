<?php
include('connection.php');

// Consulta SQL para obtener todos los coches
$sql = "SELECT * FROM coches";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
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

    .table-container {
      margin-top: 30px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #fff;
    }

    table th {
      background-color: #222;
      color: #ff6600;
    }

    table td {
      background-color: #333;
      color: #fff;
    }

    table tr:nth-child(even) {
      background-color: #444;
    }

    table tr:hover {
      background-color: #555;
    }
  </style>
</head>
<body>

  <header>
    <h1>Catálogo de Coches - Los Santos Autos</h1>
  </header>

  <div class="content">
    <h2>¡Bienvenido al catálogo de coches!</h2>
    <p>Estos son los vehículos disponibles en nuestro concesionario:</p>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Comprobar si hay coches en la base de datos
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>" . $row['id'] . "</td>
                          <td>" . $row['marca'] . "</td>
                          <td>" . $row['modelo'] . "</td>
                          <td>" . $row['año'] . "</td>
                          <td>" . $row['precio'] . " €</td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No hay coches disponibles en este momento.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>
