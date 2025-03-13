<?php
// Iniciar la sesión
session_start();

// Configuración de la base de datos
$host = "localhost"; // Cambia por tu host si es necesario
$dbname = "tiendacochesgta";
$username = "super"; // Cambia por tu usuario de la base de datos
$password = "EwnizEv5"; // Cambia por tu contraseña de la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores del formulario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Conexión a la base de datos
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para verificar el usuario y la contraseña
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Comprobar si se encontró al usuario
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($contraseña, $usuarioEncontrado['contraseña'])) {
            // Iniciar sesión y redirigir al dashboard
            $_SESSION['id_usuario'] = $usuarioEncontrado['id_usuario'];
            $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Los Santos Autos - Iniciar Sesión</title>
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: #1a1a1a;
      color: #fff;
    }

    header {
      background: #ff0000;
      padding: 20px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 3em;
      letter-spacing: 2px;
    }

    nav {
      background: #111;
      padding: 10px;
      text-align: center;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
    }

    nav a:hover {
      color: #ff0000;
    }

    .login-container {
      display: flex;
      justify-content: center;
      padding: 50px 0;
    }

    .login-box {
      background: #2b2b2b;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px #000;
      width: 400px;
    }

    .login-box h2 {
      text-align: center;
      color: #ff0000;
      margin-bottom: 20px;
    }

    .login-box input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #333;
      background: #444;
      color: #fff;
      border-radius: 5px;
    }

    .login-box button {
      width: 100%;
      padding: 10px;
      background-color: #ff0000;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1.2em;
    }

    .login-box button:hover {
      background-color: #cc0000;
    }

    footer {
      background: #111;
      text-align: center;
      padding: 20px;
      color: #888;
    }
  </style>
</head>
<body>

  <header>
    <h1>Los Santos Autos</h1>
  </header>

  <nav>
    <a href="#">Inicio</a>
    <a href="#">Catálogo</a>
    <a href="#">Sobre Nosotros</a>
    <a href="#">Contacto</a>
    <a href="login.php" class="login-btn">Iniciar Sesión</a>
  </nav>

  <div class="login-container">
    <div class="login-box">
      <h2>Iniciar Sesión</h2>
      <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuario" required><br>
        <input type="password" name="contraseña" placeholder="Contraseña" required><br>
        <button type="submit">Iniciar Sesión</button>
      </form>
    </div>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>
