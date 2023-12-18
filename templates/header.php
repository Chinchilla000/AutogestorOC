<?php
     $url_base="http://localhost/proyectooc/";
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Autogestor</title>
  
  <link rel="icon" href="<?php echo $url_base;?>img/logo2.png" type="image/x-icon">
  <!-- Bootstrap CSS v5.3.2 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<!-- Tu hoja de estilo personalizada -->
<link rel="stylesheet" type="text/css" href="<?php echo $url_base;?>CSS/styles.css">
    
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


      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link custom-link  mx-2" href="<?php echo $url_base;?>index.php"><strong>Inicio</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link  mx-2" href="<?php echo $url_base;?>quienes_somos.php"><strong>Quiénes Somos</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link mx-2" href="<?php echo $url_base;?>contacto.php"><strong>Contacto</strong></a>
          </li>
        </ul>

<div class="text-end">
    <div class="btn-group" role="group">
        <a class="btn btn-primary mx-2" href="<?php echo $url_base;?>iniciar_sesion.php"><strong>Iniciar Sesión</strong></a>
        <a class="btn btn-primary mx-2" href="<?php echo $url_base;?>secciones/empresas/crear_cuenta_empresa.php"><strong>Registrar Empresa</strong></a>
    </div>
</div>



     
  </header>
  <br>
  <br>
  <br>

  <main class="container flex-grow-1">
    
