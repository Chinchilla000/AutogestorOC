<?php
session_start();

// Eliminar solo las variables de sesión específicas del gerente general
unset($_SESSION['id_residente']);
unset($_SESSION['nombre_residente']);

// Redirigir al usuario a la página de inicio de sesión del gerente general
header("Location: ../iniciar_sesion_residente_obra.php");
exit();
?>
