<?php
session_start();
include('connection.php');

// comprobar permisos
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario'], ['admin', 'super'])) {
    header("Location: dashboard.php");
    exit();
}

// comprobar id
if (!isset($_GET['id'])) {
    die("Error: No se recibió ID del usuario.");
}

$id = intval($_GET['id']); // aseguramos que sea entero

if ($id <= 0) {
    die("Error: ID de usuario inválido.");
}

// preparar la consulta para evitar inyección (opcional)
$sql = "DELETE FROM usuarios WHERE id_usuario = $id";

if ($conn->query($sql) === TRUE) {
    // eliminación correcta, redirigimos
    header("Location: listar_usuarios.php");
    exit();
} else {
    die("Error al eliminar usuario: " . $conn->error);
}
