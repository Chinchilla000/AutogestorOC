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
        

    </style>
</head>

<body class="d-flex flex-column min-vh-100"> 
  <header>
  <nav class="navbar navbar-expand-md navbar-light custom-navbar">
        <div class="container">
            <!-- Navbar Brand para el logotipo -->
            <a class="navbar-brand mx-auto mx-md-0" href="<?php echo $url_base2; ?>index_empresa.php">
        <img src="<?php echo $url_base; ?>img/logo.png" alt="Logotipo de la Web" id="logotipo" style="max-width: 100px; height: auto;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
<ul class="nav navbar-nav">
<li class="nav-item">
    <a class="nav-link" href="<?php echo $url_base;?>index.php"><strong>Inicio</strong></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $url_base;?>quienes_somos.php"><strong>Quiénes Somos</strong></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $url_base;?>contacto.php"><strong>Contacto</strong></a>
  </li>
</ul>
<div class="col-md-3 text-end">
  <a href="<?php echo $url_base;?>iniciar_sesion.php" class="btn btn-outline-primary "><strong>Iniciar Sesión</strong></a>
  <a href="<?php echo $url_base;?>secciones/empresas/crear_cuenta_empresa.php" class="btn btn-primary"><strong>Registrar Empresa</strong></a>
</div>
     
  </header>
  <main class="container flex-grow-1">
    <br>
