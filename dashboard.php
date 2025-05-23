<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario logueado es 'super'
if ($_SESSION['usuario'] != 'super') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Usuario - Los Santos Autos</title>
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

    .content p {
      font-size: 1.2em;
      margin-top: 10px;
      margin-bottom: 40px;
      line-height: 1.6;
    }

    .dashboard-links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .dashboard-links a {
      background-color: #222;
      color: white;
      text-decoration: none;
      padding: 20px 30px;
      border-radius: 10px;
      font-size: 1.1em;
      font-weight: bold;
      transition: background-color 0.3s, transform 0.2s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    }

    .dashboard-links a:hover {
      background-color: #ff6600;
      transform: scale(1.05);
    }

    .logout-btn {
      background-color: #ff6600;
      color: white;
      padding: 12px 25px;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      margin-top: 40px;
      cursor: pointer;
      font-weight: bold;
      font-size: 1em;
      transition: background 0.3s;
    }

    .logout-btn:hover {
      background-color: #cc5200;
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
    <h1>Bienvenido a Los Santos Autos</h1>
  </header>

  <div class="content">
    <h2>¡Has iniciado sesión correctamente!</h2>
    <p>
      Estás dentro del panel de usuario de <strong>Los Santos Autos</strong>.<br>
      Elige una opción para continuar:
    </p>

    <div class="dashboard-links">
      <a href="concesionario.html">Inicio</a>
      <a href="catalogo.php">Agregar Vehículos</a>
      <a href="#">Agregar Modificaciones</a>
      <a href="agregar_usuario.php">Agregar Usuarios</a>
      <a href="servicios.php">Agregar Servicios</a>
    </div>

    <form action="logout.php" method="post">
      <button class="logout-btn">Cerrar sesión</button>
    </form>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>
