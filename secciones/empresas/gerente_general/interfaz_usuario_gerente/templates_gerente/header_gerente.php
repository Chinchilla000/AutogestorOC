<?php
$url_base = "http://localhost/ProyectoOC/";
$url_base2 = "http://localhost/ProyectoOC/secciones/empresas/gerente_general/interfaz_usuario_gerente/";

session_start();

// Verificar si la sesión del gerente general no está activa
if (!isset($_SESSION['id_gerente'])) {
    // La sesión no está activa, redirigir al formulario de inicio de sesión del gerente general
    header("Location: ../iniciar_sesion_gerente.php");
    exit();
}

$id_gerente = $_SESSION['id_gerente'];
$nombre_empresa = '';

// Consultar la base de datos para obtener el nombre de la empresa
$sentencia = $conexion->prepare("SELECT e.nombre_empresa FROM gerentes_generales gg
                                 JOIN empresas e ON gg.id_empresa = e.id
                                 WHERE gg.id = :id_gerente");
$sentencia->bindParam(':id_gerente', $id_gerente, PDO::PARAM_INT);
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
    <title>Panel del Gerente</title>

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
                        <a class="nav-link" href="<?php echo $url_base2; ?>index_usuario_gerente.php"><strong>Inicio</strong></a>
                    </li>
                    <?php if (isset($_SESSION['nombre_gerente'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" id="info-usuario" ><strong>Gerente: <?php echo $_SESSION['nombre_gerente']; ?></strong></a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['id_gerente'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" id="info-usuario" ><strong>Empresa:  <?php echo $nombre_empresa; ?></strong></a>
                    </li>
                    <?php endif; ?>
                    
                </ul>
            </div>
            <div class="col-md-3 text-end">

                <a href="<?php echo $url_base2; ?>cerrar_sesion.php" class="btn btn-danger"><strong>Cerrar
                        Sesión</strong></a>
            </div>
        </nav>
    </header>
