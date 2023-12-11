<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_residente/header_residente.php"); 
?>

<div class="container mt-5">
    <h2>Bienvenido a la Plataforma de Gestión del Residente de Obras</h2>
    <br>
    <h2><?php echo $_SESSION['nombre_residente']; ?></h2>
    <br>
    <p>En esta página, puedes ver y administrar las actividades y proyectos en curso en la Empresa: <?php echo $nombre_empresa; ?>.</p>
</div>
<?php
include("./templates_residente/footer_residente.php"); ?>
