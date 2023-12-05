<?php

$servidor = "localhost";
$basededatos = "proyecto_oc";
$usuario = "root";
$contrasenia = "";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $contrasenia);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa"; 
} catch (PDOException $ex) {
    echo "Error en la conexión: " . $ex->getMessage();
}

?>
