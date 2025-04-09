<?php
session_start();
include('connection.php');

// Verificar si el usuario está logueado, si no redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Consultar coches de la base de datos
$sql = "SELECT * FROM coches";
$result = $conn->query($sql);

// Consultar usuarios de la base de datos (para mostrar más tarde)
$sql_usuarios = "SELECT * FROM usuarios";
$result_usuarios = $conn->query($sql_usuarios);

// Verificar si se han enviado datos para agregar un coche
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_car'])) {
    // Recoger datos del formulario de coche
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $cantidad = $_POST['cantidad'];
    $color = $_POST['color'];
    $descripcion = $_POST['descripcion'];
    $kilometros = $_POST['kilometros'];
    $precio = $_POST['precio'];

    // Consulta SQL para insertar el coche
    $insert_sql = "INSERT INTO coches (marca, modelo, año, cantidad, color, descripcion, kilometros, precio) 
                   VALUES ('$marca', '$modelo', '$año', '$cantidad', '$color', '$descripcion', '$kilometros', '$precio')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "<p style='color: green;'>Nuevo coche agregado con éxito</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $insert_sql . "<br>" . $conn->error . "</p>";
    }
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

        nav {
            background: rgba(0, 0, 0, 0.85);
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            font-size: 1.1em;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ff6600;
        }

        .content {
            text-align: center;
            padding: 60px 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.75);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
        }

        .content h2 {
            color: #ff6600;
            font-size: 2.5em;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        }

        .form-container input, .form-container textarea, .form-container button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            font-size: 1em;
            border-radius: 5px;
            border: none;
        }

        .form-container input[type="number"] {
            width: auto;
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

        table {
            margin-top: 30px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #444;
        }

        table th {
            background-color: #ff6600;
            color: white;
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

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="modificaciones.php">Agregar Modificaciones</a>
        <a href="agregar_usuario.php">Agregar Usuarios</a>
        <a href="servicios.php">Agregar Servicios</a>
    </nav>

    <div class="content">
        <h2>Agregar un nuevo coche</h2>
        <div class="form-container">
            <form action="catalogo.php" method="POST">
                <label for="marca">Marca:</label>
                <input type="text" name="marca" required><br>
                <label for="modelo">Modelo:</label>
                <input type="text" name="modelo" required><br>
                <label for="año">Año:</label>
                <input type="number" name="año" required><br>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" required><br>
                <label for="color">Color:</label>
                <input type="text" name="color" required><br>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" required></textarea><br>
                <label for="kilometros">Kilómetros:</label>
                <input type="number" name="kilometros" required><br>
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" name="precio" required><br>
                <button type="submit" name="add_car">Agregar coche</button>
            </form>
        </div>

        <h2>Lista de Coches</h2>
        <table>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Cantidad</th>
                <th>Color</th>
                <th>Descripción</th>
                <th>Kilómetros</th>
                <th>Precio</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['marca'] . "</td>
                            <td>" . $row['modelo'] . "</td>
                            <td>" . $row['año'] . "</td>
                            <td>" . $row['cantidad'] . "</td>
                            <td>" . $row['color'] . "</td>
                            <td>" . $row['descripcion'] . "</td>
                            <td>" . $row['kilometros'] . "</td>
                            <td>" . $row['precio'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay coches disponibles.</td></tr>";
            }
            ?>
        </table>

        <h2>Agregar un nuevo usuario</h2>
        <div class="form-container">
            <form action="catalogo.php" method="POST">
                <label for="usuario
