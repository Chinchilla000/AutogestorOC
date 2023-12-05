<?php

$servidor = "localhost";
$basededatos = "proyecto_oc";
$usuario = "root";
$contrasenia = "";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $contrasenia);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mensaje de conexión exitosa
    echo "<script>console.log('Conexión exitosa');</script>";
} catch (PDOException $ex) {
    // Mensaje de error en la consola del navegador
    echo "<script>console.error('Error en la conexión: " . $ex->getMessage() . "');</script>";
}

?>
