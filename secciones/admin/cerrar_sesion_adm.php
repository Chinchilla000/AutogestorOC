<?php
session_start();

// Eliminar solo las variables de sesión específicas de la empresa
$_SESSION['nombre_usuario'] = $nombre_usuario;


// Redirigir al usuario a la página de inicio de sesión de la empresa
header("Location: login_adm.php");
exit();
?>
