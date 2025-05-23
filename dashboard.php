<?php
// Inicio de sesión (DEBE SER LO PRIMERO EN EL ARCHIVO)
session_start();

// Verificación de sesión y permisos
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario es 'super' (puedes ajustar esto)
if ($_SESSION['usuario'] !== 'super') {
    header("Location: login.php");
    exit();
}

// Configuración anti-caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Control - Los Santos Autos</title>
  <style>
    /* ESTILOS GENERALES */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://gtamag.com/images/garage/los-santos-custom_gtao_887689_cover.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* HEADER */
    header {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    header h1 {
      font-size: 2.5em;
      letter-spacing: 2px;
      color: #ff6600;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
    }

    /* CONTENIDO PRINCIPAL */
    .main-content {
      flex: 1;
      padding: 40px 20px;
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
    }

    .welcome-section {
      background-color: rgba(0, 0, 0, 0.7);
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }

    .welcome-section h2 {
      color: #ff6600;
      font-size: 2em;
      margin-bottom: 15px;
    }

    .welcome-section p {
      font-size: 1.1em;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    /* PANEL DE ACCIONES */
    .action-panel {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .action-card {
      background-color: rgba(0, 0, 0, 0.75);
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(255, 102, 0, 0.3);
    }

    .action-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
      border-color: #ff6600;
    }

    .action-card h3 {
      color: #ff6600;
      font-size: 1.5em;
      margin-bottom: 15px;
    }

    .action-card p {
      color: #ccc;
      margin-bottom: 20px;
      font-size: 0.95em;
    }

    .action-btn {
      display: inline-block;
      background-color: #ff6600;
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .action-btn:hover {
      background-color: #e55c00;
    }

    /* FOOTER */
    footer {
      background-color: rgba(0, 0, 0, 0.8);
      text-align: center;
      padding: 15px;
      margin-top: auto;
    }

    .logout-btn {
      background-color: #333;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 30px;
      transition: background-color 0.3s;
    }

    .logout-btn:hover {
      background-color: #555;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .action-panel {
        grid-template-columns: 1fr;
      }
      
      .welcome-section {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
  </header>

  <div class="main-content">
    <section class="welcome-section">
      <h2>Panel de Administración</h2>
      <p>Gestiona todos los aspectos de Los Santos Autos desde este panel de control.</p>
      <p>Selecciona una opción para comenzar:</p>
    </section>

    <div class="action-panel">
      <div class="action-card">
        <h3>Inicio</h3>
        <p>Vuelve a la página principal del concesionario.</p>
        <a href="concesionario.html" class="action-btn">Ir al Inicio</a>
      </div>

      <div class="action-card">
        <h3>Vehículos</h3>
        <p>Gestiona el catálogo de vehículos disponibles en el concesionario.</p>
        <a href="catalogo.php" class="action-btn">Administrar Vehículos</a>
      </div>

      <div class="action-card">
        <h3>Modificaciones</h3>
        <p>Configura las opciones de personalización para los vehículos.</p>
        <a href="modificaciones.php" class="action-btn">Administrar Modificaciones</a>
      </div>

      <div class="action-card">
        <h3>Servicios</h3>
        <p>Gestiona los servicios ofrecidos por el taller mecánico.</p>
        <a href="servicios.php" class="action-btn">Administrar Servicios</a>
      </div>

      <div class="action-card">
        <h3>Usuarios</h3>
        <p>Administra las cuentas de usuario con acceso al sistema.</p>
        <a href="agregar_usuario.php" class="action-btn">Administrar Usuarios</a>
      </div>
    </div>

    <form action="logout.php" method="post" style="text-align: center;">
      <button type="submit" class="logout-btn">Cerrar Sesión</button>
    </form>
  </div>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> Los Santos Autos. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
