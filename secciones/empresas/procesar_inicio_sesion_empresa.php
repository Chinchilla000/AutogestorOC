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
        header("Location: index_empresa.php");
        exit();
    } else {
        // Credenciales incorrectas, redirigir al formulario de inicio de sesión con un mensaje de error
        header("Location: iniciar_sesion.php?error=1");
        exit();
    }
}
?>
