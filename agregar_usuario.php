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

        .content {
            text-align: center;
            padding: 50px;
        }

        .content h2 {
            color: #ff0000;
            font-size: 2.5em;
        }

        .form-container {
            background: #222;
            padding: 30px;
            border-radius: 8px;
            margin-top: 30px;
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
            background-color: #ff0000;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #cc0000;
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
        <h1>Agregar Usuario</h1>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="catalogo.php">Catálogo</a>
        <a href="agregar_usuario.php">Agregar Usuarios</a>
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
