<?php
session_start(); // Iniciar sessió

    

// Inclou el fitxer de connexió a la base de dades
include 'conexio.php';

// Variable per guardar errors
$error = "";

// Comprovar si s'ha enviat el formulari
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recollir dades del formulari
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Comprovar que els camps no estiguin buits
    if (!empty($username) && !empty($password)) {
        // Preparar la consulta per verificar l'usuari
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Comprovar si s'ha trobat l'usuari
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verificar la contrasenya
            if (password_verify($password, $hashed_password)) {
                // Credencials correctes, iniciar sessió
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                // Redirigir a la pàgina de dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                // Contrasenya incorrecta
                $error = "Credencials incorrectes";
            }
        } else {
            // Usuari no trobat
            $error = "Credencials incorrectes";
        }

        // Tancar la consulta
        $stmt->close();
    } else {
        // Camps buits
        $error = "Tots els camps són obligatoris";
    }

    // Tancar la connexió
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Iniciar Sessió</h2>
        <label for="username">Usuari:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contrasenya:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar Sessió</button>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
                
    
            


</body>
</html>

