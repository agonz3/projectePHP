<?php
include 'conection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $color = $_POST['color'];
    $kilometros = $_POST['kilometros'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO coches (marca, modelo, año, color, kilometros, precio, cantidad, descripcion)
            VALUES ('$marca', '$modelo', '$año', '$color', '$kilometros', '$precio', '$cantidad', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Coche</title>
</head>
<body>
  <h2>Agregar Nuevo Coche</h2>
  <form method="post" action="">
    <label>Marca:</label><br>
    <input type="text" name="marca" required><br><br>

    <label>Modelo:</label><br>
    <input type="text" name="modelo" required><br><br>

    <label>Año:</label><br>
    <input type="number" name="año" required><br><br>

    <label>Color:</label><br>
    <input type="text" name="color" required><br><br>

    <label>Kilómetros:</label><br>
    <input type="number" name="kilometros" required><br><br>

    <label>Precio:</label><br>
    <input type="number" name="precio" required><br><br>

    <label>Cantidad:</label><br>
    <input type="number" name="cantidad" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" required></textarea><br><br>

    <input type="submit" value="Agregar Coche">
  </form>
</body>
</html>
