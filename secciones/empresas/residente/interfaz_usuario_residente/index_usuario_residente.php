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
// Asegúrate de que $id_residente está definido
$id_residente = $_SESSION['id_residente'] ?? null;

if ($id_residente) {
    // Preparar la consulta para obtener las solicitudes
    $stmt = $conexion->prepare("SELECT * FROM solicitudes_orden_compra WHERE id_residente = :id_residente ORDER BY fecha_creacion DESC");
    $stmt->bindParam(':id_residente', $id_residente, PDO::PARAM_INT);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron solicitudes
    if (count($solicitudes) > 0) {
        // Mostrar las solicitudes
        echo "<div class='container mt-5'>";
        echo "<h3>Sus Solicitudes Enviadas</h3>";
        echo "<table class='table'>";
        echo "<thead><tr><th>ID Solicitud</th><th>Obra</th><th>Domicilio</th><th>Total</th><th>Fecha de Creación</th><th>Archivo Cotización</th></tr></thead>";
        echo "<tbody>";

        foreach ($solicitudes as $solicitud) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($solicitud['id_solicitud']) . "</td>";
            echo "<td>" . htmlspecialchars($solicitud['obra']) . "</td>";
            echo "<td>" . htmlspecialchars($solicitud['domicilio']) . "</td>";
            echo "<td>" . htmlspecialchars($solicitud['total']) . "</td>";
            echo "<td>" . htmlspecialchars($solicitud['fecha_creacion']) . "</td>";

            // Verificar si existe un archivo de cotización y mostrar el enlace
            if (!empty($solicitud['archivo_cotizacion'])) {
                echo "<td><a href='" . htmlspecialchars($solicitud['archivo_cotizacion']) . "' target='_blank'>Ver Cotización</a></td>";
            } else {
                echo "<td>No disponible</td>";
            }

            echo "</tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<div class='container mt-5'><p>No se encontraron solicitudes.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Error: No se pudo identificar al residente.</p></div>";
}
?>

<?php
include("./templates_residente/footer_residente.php"); ?>
