<?php
// Iniciar la sesión
session_start();

// Configuración de la base de datos
$host = "localhost";
$dbname = "tiendacochesgta";
$dbuser = "super";
$dbpass = "EwnizEv5";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    try {
        // Conectar con la base de datos
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar la consulta para verificar si el usuario existe
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si el usuario existe
        if ($usuarioEncontrado) {
            // Verificar si la contraseña es correcta
            if (password_verify($contraseña, $usuarioEncontrado['contraseña'])) {
                // Iniciar sesión y redirigir al dashboard
                $_SESSION['id_usuario'] = $usuarioEncontrado['id_usuario'];
                $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
                
                // Redirigir al dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                // Error en la contraseña
                $error = "Contraseña incorrecta.";
            }
        } else {
            // Error en el usuario
            $error = "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        // Error de conexión
        $error = "Error de conexión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Los Santos Autos</title>
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
      align-items: center;
      min-height: 100vh;
      background-color: #333;
    }

    .login-box {
      width: 350px;
      padding: 30px;
      border-radius: 8px;
      background-color: #222;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .login-box h2 {
      text-align: center;
      color: #ff0000;
      font-size: 2.5em;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      background-color: #333;
      color: #fff;
    }

    .login-box button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #ff0000;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-box button[type="submit"]:hover {
      background-color: #cc0000;
    }

    .error {
      color: #dc3545;
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }

    footer {
      background: #111;
      text-align: center;
      padding: 20px;
      color: #888;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
  </style>
</head>
<body>

  <header>
    <h1>Los Santos Autos</h1>
  </header>

  <nav>
    <a href="#">Inicio</a>
    <a href="catalogo.php">Catálogo</a>
    <a href="#">Sobre Nosotros</a>
    <a href="#">Contacto</a>
  </nav>

  <div class="login-container">
    <div class="login-box">
      <h2>Iniciar Sesión</h2>

      <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
      <?php endif; ?>

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
