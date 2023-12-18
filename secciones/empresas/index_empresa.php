<?php
error_reporting(E_ALL);
include("../../bd.php");
include("templates/header_empresa.php"); ?>


<div class="container mt-5">
    <h2>Bienvenido a la Plataforma de Gestión de la Empresa: </h2>
    <br>
    <h2><?php echo $_SESSION['nombre_empresa']; ?></h2>
    <br>
    <p>En esta página, puedes ver y administrar tus Usuarios.</p>
</div>


<?php include("templates/footer_empresa.php"); ?>
