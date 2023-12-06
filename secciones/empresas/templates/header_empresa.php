<?php
<<<<<<< HEAD

$url_base = "http://localhost/ProyectoOC/";
$url_base2 = "http://localhost/ProyectoOC/secciones/empresas/";

session_start();

$id_empresa_actual = $_SESSION['id_empresa'];

// Verificar si la sesión de la empresa no está activa
=======
$url_base = "http://localhost/ProyectoOC/";
$url_base2 = "http://localhost/ProyectoOC/secciones/empresas/";
session_start();

// Verificar si la sesión de la empresa está activa
>>>>>>> 6ba36094bc06ef57e33b23492dc62120f75ca3d8
if (!isset($_SESSION['id_empresa'])) {
    // La sesión no está activa, redirigir al formulario de inicio de sesión
    header("Location: iniciar_sesion_empresa.php");
    exit();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Autogestor</title>

    <link rel="icon" href="<?php echo $url_base; ?>img/logo2.png" type="image/x-icon">
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Tu hoja de estilo personalizada -->
    <link rel="stylesheet" type="text/css" href="<?php echo $url_base; ?>CSS/styles.css">

</head>

<body class="d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="container">
            <div id="logotipo">
                <a href="<?php echo $url_base2; ?>index_empresa.php">
                    <img src="<?php echo $url_base; ?>img/logo.png" alt="Logotipo de la Web">
                </a>
            </div>

            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base2; ?>index_empresa.php"><strong>Inicio</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?php echo $url_base2; ?>gerente_general/index_gerente.php"><strong>Gerente
                            General</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?php echo $url_base2; ?>visitador_obra/index_visitador.php"><strong>Visitador de
                            Obras</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?php echo $url_base2; ?>residente/index_residente.php"><strong>Residente de
                            Obras</strong></a>
                </li>
            </ul>
        </div>
        <div class="col-md-3 text-end">
            <?php if (isset($_SESSION['nombre_usuario'])) : ?>
                <p class="text-secondary mb-0">Usuario: <?php echo $_SESSION['nombre_usuario']; ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['nombre_empresa'])) : ?>
                <p class="text-secondary mb-0">Empresa: <?php echo $_SESSION['nombre_empresa']; ?></p>
            <?php endif; ?>

            <a href="<?php echo $url_base2; ?>cerrar_sesion.php" class="btn btn-danger"><strong>Cerrar
                    Sesión</strong></a>
        </div>
    </nav>
</header>
<main class="container flex-grow-1">
    <br>
