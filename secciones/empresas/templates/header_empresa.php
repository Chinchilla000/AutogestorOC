<?php

$url_base = "http://localhost/ProyectoOC/";
$url_base2 = "http://localhost/ProyectoOC/secciones/empresas/";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la sesión de la empresa no está activa
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

    <style>
         #logotipo {
        display: inline-block; /* Hace que el contenedor se ajuste al tamaño de su contenido */
    }

    #logotipo img {
        height: auto; /* Mantiene la proporción de la imagen */
        max-width: 100px; /* Ajusta el tamaño máximo de la imagen */
    }


        .navbar {
            padding: 0.5rem 1rem; /* Ajuste del padding del navbar */
        }

        .navbar-nav {
            flex-grow: 1; /* Permitir que los enlaces de navegación crezcan */
            justify-content: space-around; /* Distribuir uniformemente */
        }

        .nombre-usuario {
            font-weight: bold;
            color: #28a745; /* Color del texto del usuario */
            margin-left: auto; /* Alinear a la derecha */
        }

        .nav-item a, .nombre-usuario {
            font-size: 1em; /* Ajustar el tamaño del texto */
        }

        #info-usuario {
            display: flex;
            align-items: center;
        }
    </style>
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

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base2; ?>index_empresa.php"><strong>Inicio</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base2; ?>gerente_general/index_gerente.php"><strong>Gerente General</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base2; ?>visitador_obra/index_visitador.php"><strong>Visitador de Obras</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base2; ?>residente/index_residente.php"><strong>Residente de Obras</strong></a>
                    </li>
                    <?php if (isset($_SESSION['nombre_usuario'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" id="info-usuario" ><strong>Usuario: <?php echo $_SESSION['nombre_usuario']; ?></strong></a>
                    </li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex" >

                    <a href="<?php echo $url_base2; ?>cerrar_sesion.php" class="btn btn-danger ml-2"><strong>Cerrar Sesión</strong></a>
                </div>
            </div>
        </div>
    </nav>
</header>
<main class="container flex-grow-1">
    <br>