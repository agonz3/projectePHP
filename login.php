<?php
// Inicio de sesión (DEBE SER LO PRIMERO)
session_start();

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'tiendacochesgta');
define('DB_USER', 'super');
define('DB_PASS', 'EwnizEv5');

// Inicializar variables
$error = '';
$success = '';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar campos recibidos
    if (empty($_POST['usuario']) || empty($_POST['contraseña'])) {
        $error = "Usuario y contraseña son requeridos";
    } else {
        // Sanitizar entradas
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $contraseña = $_POST['contraseña'];

        try {
            // Conexión PDO con opciones de seguridad
            $pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            // Consulta preparada con marcadores nombrados
            $sql = "SELECT id_usuario, usuario, contraseña FROM usuarios WHERE usuario = :usuario LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            
            $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuarioEncontrado) {
                if (password_verify($contraseña, $usuarioEncontrado['contraseña'])) {
                    // Regenerar ID de sesión y establecer timeout
                    session_regenerate_id(true);
                    
                    // Limpiar y establecer datos de sesión
                    $_SESSION = array();
                    $_SESSION['id_usuario'] = $usuarioEncontrado['id_usuario'];
                    $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
                    $_SESSION['login_time'] = time();
                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
                    
                    // Redirección segura
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Credenciales incorrectas";
                    error_log("Intento fallido de login para usuario: ".$usuario);
                }
            } else {
                // Mensaje genérico por seguridad
                $error = "Credenciales incorrectas";
            }
        } catch (PDOException $e) {
            error_log("Error de BD: ".$e->getMessage());
            $error = "Error del sistema. Por favor intente más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Los Santos Autos</title>
    <style>
        :root {
            --color-primary: #ff6600;
            --color-secondary: #cc5200;
            --color-dark: #222;
            --color-light: #fff;
            --color-gray: #888;
            --color-danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://gtamag.com/images/garage/los-santos-custom_gtao_887689_cover.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--color-light);
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: rgba(0, 0, 0, 0.85);
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        
        header h1 {
            font-size: 2.8rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--color-primary);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 15px;
            text-align: center;
        }
        
        nav a {
            color: var(--color-light);
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        nav a:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }
        
        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .login-box {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.85);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 102, 0, 0.3);
        }
        
        .login-box h2 {
            color: var(--color-primary);
            font-size: 2.2rem;
            margin-bottom: 25px;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--color-primary);
            border-radius: 8px;
            background: var(--color-dark);
            color: var(--color-light);
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #ffcc00;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.2);
        }
        
        .btn {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: var(--color-primary);
            color: var(--color-light);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: var(--color-secondary);
        }
        
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid var(--color-danger);
            color: var(--color-danger);
        }
        
        footer {
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            padding: 15px;
            color: var(--color-gray);
        }
        
        @media (max-width: 576px) {
            .login-box {
                padding: 30px 20px;
            }
            
            header h1 {
                font-size: 2.2rem;
            }
            
            nav a {
                margin: 0 10px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Los Santos Autos</h1>
    </header>

    <nav>
        <a href="concesionario.html">Inicio</a>
        <a href="catalogocoches.php">Catálogo</a>
        <a href="#">Modificaciones</a>
        <a href="#">Servicios</a>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                </div>
                
                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Los Santos Autos. Todos los derechos reservados.
    </footer>
</body>
</html>