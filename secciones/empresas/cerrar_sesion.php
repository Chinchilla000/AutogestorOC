<?php
session_start();

// Eliminar solo las variables de sesión específicas de la empresa
unset($_SESSION['id_empresa']);
unset($_SESSION['nombre_usuario']);
unset($_SESSION['nombre_empresa']);


// Redirigir al usuario a la página de inicio de sesión de la empresa
header("Location: iniciar_sesion_empresa.php");
exit();
?>
