<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php"); 
?>

<div class="container mt-5">
    <h2>Bienvenido a la plataforma de Gestión de Orden de Compra.</h2>
    <br>
    <h2>Visitador de Obra: <?php echo $_SESSION['nombre_visitador']; ?></h2>
    <br>
    <h2>Empres: <?php echo $nombre_empresa; ?></h2>
    <br>
    <p>Estimado usuario acá podrás aprobar o rechazar solicitudes de OC y hacer un seguimiento de este proceso.</p>
</div>
<?php
include("./templates_visitador/footer_visitador.php"); ?>