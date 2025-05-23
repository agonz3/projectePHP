<?php
session_start();
include('connection.php');

// mostrar errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// comprobar si está logueado como admin o super
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario'] != 'admin' && $_SESSION['usuario'] != 'super')) {
    header("Location: login.php");
    exit();
}

// comprobar que el id venga en GET y sea numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Usuario no especificado o ID inválido.";
    exit();
}

$id_usuario = intval($_GET['id']);

// si se envió formulario POST para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $contraseña = $conn->real_escape_string($_POST['contraseña']);

    $sql = "UPDATE usuarios SET usuario='$usuario', contraseña='$contraseña' WHERE id_usuario=$id_usuario";

    if ($conn->query($sql) === TRUE) {
        header("Location: listar_usuarios.php"); // redirige al listado después de editar
        exit();
    } else {
        echo "Error al actualizar usuario: " . $conn->error;
    }
}

// obtener datos actuales del usuario
$sql = "SELECT * FROM usuarios WHERE id_usuario=$id_usuario";
$resultado = $conn->query($sql);

if (!$resultado || $resultado->num_rows != 1) {
    echo "Usuario no encontrado.";
    exit();
}

$usuarioDatos = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuario - Los Santos Autos</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://gtamag.com/images/garage/los-santos-custom_gtao_887689_cover.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }
    .content {
      max-width: 600px;
      margin: 60px auto;
      background-color: rgba(0,0,0,0.75);
      padding: 30px;
      border-radius: 10px;
    }
    input, button {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: none;
      font-size: 1em;
    }
    button {
      background-color: #ff6600;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #cc5200;
    }
  </style>
</head>
<body>

<div class="content">
  <h2>Editar Usuario</h2>
  <form method="post" action="">
    <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($usuarioDatos['usuario']); ?>" required />
    <input type="text" name="contraseña" placeholder="Contraseña" value="<?php echo htmlspecialchars($usuarioDatos['contraseña']); ?>" required />
    <button type="submit">Guardar cambios</button>
  </form>
</div>

</body>
</html>
