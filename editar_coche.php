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
    echo "Coche no especificado o ID inválido.";
    exit();
}

$id_coche = intval($_GET['id']);

// si se envió formulario POST para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = $conn->real_escape_string($_POST['modelo']);
    $marca  = $conn->real_escape_string($_POST['marca']);
    $precio = floatval($_POST['precio']);
    $color  = $conn->real_escape_string($_POST['color']);

    $sql = "UPDATE coches SET modelo='$modelo', marca='$marca', precio=$precio, color='$color' WHERE id=$id_coche";

    if ($conn->query($sql) === TRUE) {
        header("Location: catalogo.php"); // redirige al catálogo después de editar
        exit();
    } else {
        echo "Error al actualizar coche: " . $conn->error;
    }
}

// obtener datos actuales del coche
$sql = "SELECT * FROM coches WHERE id=$id_coche";
$resultado = $conn->query($sql);

if (!$resultado || $resultado->num_rows != 1) {
    echo "Coche no encontrado.";
    exit();
}

$coche = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Coche - Los Santos Autos</title>
  <style>
    /* Estilos similares a antes */
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
  <h2>Editar Coche</h2>
  <form method="post" action="">
    <input type="text" name="modelo" placeholder="Modelo" value="<?php echo htmlspecialchars($coche['modelo']); ?>" required />
    <input type="text" name="marca" placeholder="Marca" value="<?php echo htmlspecialchars($coche['marca']); ?>" required />
    <input type="number" name="precio" step="0.01" placeholder="Precio" value="<?php echo $coche['precio']; ?>" required />
    <input type="text" name="color" placeholder="Color" value="<?php echo htmlspecialchars($coche['color']); ?>" required />
    <button type="submit">Guardar cambios</button>
  </form>
</div>

</body>
</html>
