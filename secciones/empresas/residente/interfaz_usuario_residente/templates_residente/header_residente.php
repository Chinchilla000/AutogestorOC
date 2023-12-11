<?php
$url_base = "http://localhost/ProyectoOC/";
$url_base2 = "http://localhost/ProyectoOC/secciones/empresas/residente_obra/interfaz_usuario_residente/";

session_start();

// Verificar si la sesión del residente de obras no está activa
if (!isset($_SESSION['id_residente'])) {
    // La sesión no está activa, redirigir al formulario de inicio de sesión del residente de obras
    header("Location: ../iniciar_sesion_residente_obra.php");
    exit();
}

$id_residente = $_SESSION['id_residente'];
$nombre_empresa = '';

// Consultar la base de datos para obtener el nombre de la empresa
$sentencia = $conexion->prepare("SELECT e.nombre_empresa FROM residentes_obra ro
                                 JOIN empresas e ON ro.id_empresa = e.id
                                 WHERE ro.id = :id_residente");
$sentencia->bindParam(':id_residente', $id_residente, PDO::PARAM_INT);
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $nombre_empresa = $resultado['nombre_empresa'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel del Residente de Obras</title>

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
                        <a class="nav-link" href="index_usuario_residente.php"><strong>Inicio</strong></a>
                    </li>
                    <?php if (isset($_SESSION['nombre_residente'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" id="info-usuario" ><strong>Residente: <?php echo $_SESSION['nombre_residente']; ?></strong></a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['id_residente'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" id="info-empresa" ><strong>Empresa: <?php echo $nombre_empresa; ?></strong></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-3 text-end">
                <a href="<?php echo $url_base2; ?>cerrar_sesion.php" class="btn btn-danger"><strong>Cerrar Sesión</strong></a>
            </div>
        </nav>
    </header>