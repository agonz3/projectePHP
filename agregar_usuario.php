<?php
session_start();
include('connection.php');

// Verificar si el usuario está logueado, si no redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Verificar si se han enviado datos para agregar un usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    // Recoger datos del formulario de usuario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña']; // Asegúrate de cifrar la contraseña en un entorno real

    // Consulta SQL para insertar el usuario
    $insert_sql_user = "INSERT INTO usuarios (usuario, contraseña) 
                        VALUES ('$usuario', '$contraseña')";
    
    if ($conn->query($insert_sql_user) === TRUE) {
        echo "<p style='color: green;'>Nuevo usuario agregado con éxito</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $insert_sql_user . "<br>" . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Usuario - Los Santos Autos</title>
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
      width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    .form-container input, .form-container button {
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
    <h1>Agregar Usuario</h1>
  </header>

  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="#">Agregar Modificaciones</a>
    <a href="catalogo.php">Agregar Vehiculos</a>
    <a href="#">Agregar Servicios</a>
  </nav>

  <div class="content">
    <h2>Formulario para agregar un nuevo usuario</h2>
    <div class="form-container">
      <form action="agregar_usuario.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br>
        <button type="submit" name="add_user">Agregar usuario</button>
      </form>
    </div>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>
