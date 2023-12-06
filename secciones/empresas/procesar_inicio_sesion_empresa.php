<?php
// Incluir archivo de conexión a la base de datos
include("../../bd.php");

// Verificar si se han enviado datos de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos para verificar las credenciales
    $sentencia = $conexion->prepare("SELECT * FROM empresas WHERE correo_empresa = :correo");
    $sentencia->bindParam(':correo', $correo);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['password'])) {
        // Inicio de sesión exitoso, redirigir al área de empresas
        session_start();
        $_SESSION['id_empresa'] = $usuario['id'];
<<<<<<< HEAD
        header("Location: http://localhost/ProyectoOC/secciones/empresas/index_empresa.php");
        exit();
    } else {
        // Credenciales incorrectas, redirigir al formulario de inicio de sesión con un mensaje de error
        header("Location: iniciar_sesion_empresa.php?error=1");
=======
        header("Location: index_empresa.php");
        exit();
    } else {
        // Credenciales incorrectas, redirigir al formulario de inicio de sesión con un mensaje de error
        header("Location: iniciar_sesion.php?error=1");
>>>>>>> 6ba36094bc06ef57e33b23492dc62120f75ca3d8
        exit();
    }
}
?>