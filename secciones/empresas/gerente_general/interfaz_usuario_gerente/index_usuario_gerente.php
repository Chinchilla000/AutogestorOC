<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_gerente/header_gerente.php"); 
?>

<div class="container mt-5">
    <h2>Bienvenido a la Plataforma de Gestión de la Gerente General</h2>
    <br>
    <h2><?php echo $_SESSION['nombre_gerente']; ?></h2>
    <br>
    <p>En esta página, puedes ver y administrar tus ordenes de compras de la Empresa: <?php echo $nombre_empresa; ?>.</p>
</div>
<?php
include("./templates_gerente/footer_gerente.php"); ?>
