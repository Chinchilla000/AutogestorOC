<?php
// Incluir archivo de conexión a la base de datos
include("../../../bd.php");

// Verificar si se han enviado datos de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos para verificar las credenciales
    // La consulta ahora incluye un JOIN para obtener también la información de la empresa
    $sentencia = $conexion->prepare("SELECT gg.*, e.nombre_empresa FROM gerentes_generales gg
                                     JOIN empresas e ON gg.id_empresa = e.id
                                     WHERE gg.correo = :correo");
    $sentencia->bindParam(':correo', $correo);
    $sentencia->execute();
    $gerente = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($gerente && password_verify($contrasena, $gerente['contrasena'])) {
        // Inicio de sesión exitoso, iniciar la sesión y redirigir al área de gerentes generales
        session_start();
        $_SESSION['id_gerente'] = $gerente['id'];
        $_SESSION['nombre_gerente'] = $gerente['nombre'];


        header("Location: interfaz_usuario_gerente/index_usuario_gerente.php");
        exit();
    } else {
        // Credenciales incorrectas, redirigir al formulario de inicio de sesión con un mensaje de error
        header("Location: iniciar_sesion_gerente.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión Gerente General</title>
    <link rel="icon" href="../../../img/Logo2.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlaces para Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!-- Tu hoja de estilo personalizada -->
    <link rel="stylesheet" href="../../../CSS/styles.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <br>
    <main class="form-signin w-100 m-auto container flex-grow-1">
        <form action="iniciar_sesion_gerente.php" method="post">
            <img class="mb-4" src="../../../img/logo.png" alt="Logo" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Iniciar Sesión: Gerente General</h1>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="correo" placeholder="name@example.com">
                <label for="floatingInput">Correo Electrónico</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="contrasena" placeholder="Contraseña">
                <label for="floatingPassword">Contraseña</label>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    Correo electrónico o contraseña incorrecta.
                </div>
            <?php endif; ?>

            <div class="form-check text-start mb-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Recordar usuario
                </label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>

            <p class="mt-3 text-muted"> Para regresar haz clic <a href="../../../iniciar_sesion.php">aquí.</a></p>
        </form>

    </main>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        // Aplica select2 al elemento con ID "companySelect"
        $(document).ready(function () {
            $('#companySelect').select2();
        });
    </script>
</body>

</html>
