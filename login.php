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
      background: url('https://gtamag.com/images/garage/los-santos-custom_gtao_887689_cover.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      height: 100vh;
    }

    header {
      background: rgba(0, 0, 0, 0.7);
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    header h1 {
      margin: 0;
      font-size: 3.5em;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ff6600;
    }

    nav {
      background: rgba(0, 0, 0, 0.7);
      padding: 15px;
      text-align: center;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      margin: 0 20px;
      font-weight: bold;
      font-size: 1.2em;
    }

    nav a:hover {
      color: #ff6600;
      text-decoration: underline;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .login-box {
      width: 400px;
      padding: 40px;
      background: rgba(0, 0, 0, 0.8);
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    .login-box h2 {
      color: #ff6600;
      font-size: 3em;
      margin-bottom: 20px;
      font-family: 'Arial', sans-serif;
      letter-spacing: 1px;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 15px 0;
      border-radius: 8px;
      border: 2px solid #ff6600;
      background: #222;
      color: #fff;
      font-size: 16px;
      transition: border 0.3s ease;
    }

    .login-box input[type="text"]:focus,
    .login-box input[type="password"]:focus {
      border-color: #ffcc00;
      outline: none;
    }

    .login-box button[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #ff6600;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-box button[type="submit"]:hover {
      background-color: #cc5200;
    }

    .error {
      color: #dc3545;
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 18px;
    }

    footer {
      background: rgba(0, 0, 0, 0.7);
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
    <a href="concesionario.html">Inicio</a>
    <a href="#">Catálogo coches</a>
    <a href="#">Catálogo modificaciones</a>
    <a href="#">Catálogo servicios</a>
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
