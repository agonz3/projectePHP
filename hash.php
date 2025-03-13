<?php
$password = 'EwnizEv5'; // Contraseña en texto plano
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Contraseña encriptada: " . $hashed_password;
?>