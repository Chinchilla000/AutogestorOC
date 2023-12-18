<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_residente/header_residente.php"); 
?>

<div class="container mt-5">
    <h2>Bienvenido a la plataforma de Gestión de Orden de Compra.</h2>
    <br>
    <h2>Residente de Obra: <?php echo $_SESSION['nombre_residente']; ?></h2>
    <br>
    <h2>Empresa: <?php echo $nombre_empresa; ?></h2>
    <br>
    <p>Estimado usuario acá podrás gestionar tus solicitudes de OC y hacer un seguimiento de este proceso.</p>
</div>

<?php
include("./templates_residente/footer_residente.php"); 
?>
