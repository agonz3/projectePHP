<?php
// Configuració de la connexió a la base de dades
$servername = "localhost"; // Servidor de la base de dades
$username = "super";        // Usuari de MySQL
$password = "EwnizEv5"; // Contrasenya de MySQL
$dbname = "tiendascochesgta";  // Nom de la base de dades

// Crear connexió
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprovar connexió
if ($conn->connect_error) {
    die("Connexió fallida: " . $conn->connect_error);
}

// Opcional: Configurar el joc de caràcters a UTF-8
$conn->set_charset("utf8");
?>

