<?php
session_start();
include('connection.php');

// comprobar permisos
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario'] != 'admin' && $_SESSION['usuario'] != 'super')) {
    header("Location: catalogo.php");
    exit();
}

// comprobar id
if (!isset($_GET['id'])) {
    header("Location: catalogo.php");
    exit();
}

$id = $_GET['id'];

// eliminar coche
$sql = "DELETE FROM coches WHERE id_coche = $id";
$conn->query($sql);

header("Location: catalogocoches.php");
exit();
?>
