<?php
$url_base = "http://localhost/proyectooc/";
$url_base2 = "http://localhost/proyectooc/secciones/empresas/visitador_obra/interfaz_usuario_visitador/";
$url_cotizacion = "http://localhost/proyectooc/secciones/empresas/residente/interfaz_usuario_residente/";

session_start();

// Verificar si la sesión del visitador de obras no está activa
if (!isset($_SESSION['id_visitador'])) {
    // La sesión no está activa, redirigir al formulario de inicio de sesión del visitador de obras
    header("Location: ../iniciar_sesion_visitador_obra.php");
    exit();
}

$id_visitador = $_SESSION['id_visitador'];
$nombre_empresa = '';

// Consultar la base de datos para obtener el nombre de la empresa
$sentencia = $conexion->prepare("SELECT e.id, e.nombre_empresa FROM visitadores_obra vo
                                 JOIN empresas e ON vo.id_empresa = e.id
                                 WHERE vo.id = :id_visitador");
$sentencia->bindParam(':id_visitador', $id_visitador, PDO::PARAM_INT);
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $nombre_empresa = $resultado['nombre_empresa'];
    $_SESSION['id_empresa'] = $resultado['id']; // Guardar el ID de la empresa en la sesión
}

        // Obtener el apellido del visitador de la base de datos
        $sentencia_apellido = $conexion->prepare("SELECT apellido FROM visitadores_obra WHERE id = :id_visitador");
        $sentencia_apellido->bindParam(':id_visitador', $id_visitador, PDO::PARAM_INT);
        $sentencia_apellido->execute();
        $resultado_apellido = $sentencia_apellido->fetch(PDO::FETCH_ASSOC);

        if ($resultado_apellido && isset($resultado_apellido['apellido'])) {
            $apellido_visitador = $resultado_apellido['apellido'];
        } else {
            $apellido_visitador = '';
        }
        
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel del Visitador de Obras</title>

    <link rel="icon" href="<?php echo $url_base; ?>img/logo.png" type="image/x-icon">
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Tu hoja de estilo personalizada -->
    <link rel="stylesheet" type="text/css" href="<?php echo $url_base; ?>CSS/styles.css">
    
    <style>
      body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        }
        main {
        flex-grow: 1;
        min-height: calc(100vh - 60px - 45px); /* Ejemplo: Header = 60px, Footer = 40px */
        }
        .contacto-info {
  /* Ajustes generales para el contenedor de información de contacto */
}

.contacto-enlace {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: inherit; /* Cambia esto según tus necesidades */
  margin-bottom: 10px; /* Espaciado entre los elementos */
}

.contacto-icono {
  width: 30px; /* Tamaño uniforme para los iconos */
  height: 30px;
  margin-right: 10px; /* Espaciado entre el icono y el texto */
}

.custom-link {
  background-color: black;
  color: white;
  padding: 5px 10px;
  border-radius: 10px;
  transition: background-color 0.3s ease;
}

.custom-link:hover {
  background-color: #333; /* Color ligeramente más claro para el hover */
  color: white;
  text-decoration: none; /* Opcional, para quitar el subrayado al pasar el mouse */
}

.custom-navbar {
  background: none; /* Se cambió a 'none' para quitar el fondo */
}
.logo-container {
    background-color: white; /* Fondo blanco */
    padding: 10px; /* Espaciado alrededor del logotipo */
    border: 1px solid #ddd; /* Borde opcional, se puede quitar o ajustar */
    display: inline-block; /* Hace que el div sea del tamaño de su contenido */
    box-sizing: border-box; /* Asegura que el padding y border estén incluidos en el ancho y alto */
}

#logotipo {
    max-width: 100px; /* Ajusta el ancho máximo */
    height: auto; /* Mantiene la proporción */
}

    </style>

</head>
<body class="d-flex flex-column min-vh-100">
    <header>
    <nav class="navbar navbar-expand-md navbar-light custom-navbar">
        <div class="container">
            <!-- Navbar Brand para el logotipo -->
            <a class="navbar-brand mx-auto mx-md-0" href="<?php echo $url_base2; ?>index_empresa.php">
                <div class="logo-container">
                    <img src="<?php echo $url_base; ?>img/logo.png" alt="Logotipo de la Web" id="logotipo">
                </div>
            </a>

            <!-- Toggler button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
       

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link custom-link  mx-2" href="index_usuario_visitador.php"><strong>Inicio</strong></a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link custom-link  mx-2 dropdown-toggle" href="solicitudes_compra.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Solicitudes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <li><a class="dropdown-item" href="solicitudes_compra.php">Historial de Solicitudes de OC</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link custom-link  mx-2 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ordenes de Compra
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="ordenes_compras.php">Ordenes de Compra</a></li>
                        </ul>
                    </li>
                   
                    
                    
                </ul>
            <div class="text-end">
            <?php if (isset($_SESSION['nombre_visitador'])) : ?>
        <div class="btn-group" role="group">
            <a href="" class="btn btn-primary mx-2"><strong><?php echo $_SESSION['nombre_visitador']; ?> <?php echo $apellido_visitador; ?></strong></a>
        </div>
    <?php endif; ?>
    <a href="<?php echo $url_base2; ?>cerrar_sesion.php" class="btn btn-danger mx-2"><strong>Cerrar Sesión</strong></a>
</div>

                
            </div>
        </nav>
    </header>

    <br><br><br>
