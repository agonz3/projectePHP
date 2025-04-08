<?php
// Iniciar la sesión
session_start();

// Destruir la sesión
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir al login
header("Location: login.php");
exit();
?>
