<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php"); 
?>

<div class="container mt-5">
    <h2>Bienvenido a la Plataforma de Gestión del Visitador de Obras</h2>
    <br>
    <h2><?php echo $_SESSION['nombre_visitador']; ?></h2>
    <br>
    <p>En esta página, puedes ver y administrar tus tareas asignadas en la Empresa: <?php echo $nombre_empresa; ?>.</p>
</div>
<?php
include("./templates_visitador/footer_visitador.php"); ?>