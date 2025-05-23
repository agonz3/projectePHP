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

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if ($usuario == '' || $password == '') {
        $error = "Por favor completa todos los campos.";
    } else {
        // Hashear la contraseña para seguridad
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contraseña) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $hash_password);

        if ($stmt->execute()) {
            header("Location: listar_usuarios.php");
            exit();
        } else {
            $error = "Error al agregar usuario: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
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
    padding: 40px 20px;
    max-width: 400px;
    margin: 0 auto;
    background-color: rgba(0, 0, 0, 0.75);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
  }
  label {
    display: block;
    margin-bottom: 10px;
    color: #ff6600;
  }
  input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: none;
    border-radius: 5px;
  }
  input[type="submit"] {
    background-color: #ff6600;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }
  input[type="submit"]:hover {
    background-color: #cc5200;
  }
  .error {
    background: #b00000;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
  }
  a.boton {
    display: inline-block;
    margin-top: 15px;
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
</style>
</head>
<body>

<header>
  <h1>Agregar Usuario</h1>
</header>

<div class="content">
  <?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required />

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required />

    <input type="submit" value="Agregar Usuario" />
  </form>

  <a href="listar_usuarios.php" class="boton">Volver a la lista</a>
</div>

</body>
</html>
