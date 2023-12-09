<?php
session_start();

// Eliminar solo las variables de sesión específicas del gerente general
unset($_SESSION['id_gerente']);
unset($_SESSION['nombre_gerente']);

// Redirigir al usuario a la página de inicio de sesión del gerente general
header("Location: ../iniciar_sesion_gerente.php");
exit();
?>
