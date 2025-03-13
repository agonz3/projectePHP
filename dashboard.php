<?php
session_start();

// Opcional: Puedes verificar si el usuario está logueado aquí
// if (!isset($_SESSION['usuario'])) {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Usuario - Los Santos Autos</title>
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

    .content p {
      font-size: 1.2em;
      margin-top: 20px;
    }

    .logout-btn {
      background-color: #ff0000;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      margin-top: 30px;
      cursor: pointer;
      font-weight: bold;
    }

    .logout-btn:hover {
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
    <h1>Bienvenido a Los Santos Autos</h1>
  </header>

  <nav>
    <a href="#">Inicio</a>
    <a href="#">Catálogo</a>
    <a href="#">Perfil</a>
    <a href="logout.php">Cerrar sesión</a>
  </nav>

  <div class="content">
    <h2>¡Has iniciado sesión correctamente!</h2>
    <p>Explora nuestro catálogo de coches, haz tus pedidos y mucho más.</p>
    <form action="logout.php" method="post">
      <button class="logout-btn">Cerrar sesión</button>
    </form>
  </div>

  <footer>
    © 2025 Los Santos Autos. Todos los derechos reservados.
  </footer>

</body>
</html>
