session_start();
require 'config.php'; // archivo donde configuras la conexión a la bd

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            die("conexión fallida: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("location: dashboard.php");
                exit();
            } else {
                $error = "credenciales incorrectas";
            }
        } else {
            $error = "credenciales incorrectas";
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $error = "todos los campos son obligatorios";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="post" action="">
        <label>Usuario:</label>
        <input type="text" name="username" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Iniciar sesión</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
