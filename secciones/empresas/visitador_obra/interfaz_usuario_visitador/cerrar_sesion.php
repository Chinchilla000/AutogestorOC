<?php
session_start();

// Eliminar solo las variables de sesión específicas del gerente general
unset($_SESSION['id_visitador']);
unset($_SESSION['nombre_visitador']);

// Redirigir al usuario a la página de inicio de sesión del gerente general
header("Location: ../iniciar_sesion_visitador_obra.php");
exit();
?>
