<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_residente/header_residente.php"); 

$id_residente = $_SESSION['id_residente'] ?? null;

if ($id_residente) {
    $stmt = $conexion->prepare("SELECT * FROM solicitudes_orden_compra WHERE id_residente = :id_residente ORDER BY fecha_creacion DESC");
    $stmt->bindParam(':id_residente', $id_residente, PDO::PARAM_INT);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($solicitudes) {
        echo "<div class='container mt-5'>";
        echo "<h3>Historial de Solicitudes de Ordenes de Compras</h3>";

        // Envolver la tabla en un div con la clase .table-responsive
        echo "<div class='table-responsive'>";
        echo "<table class='table table-hover'>";
        echo "<thead><tr><th>N° Solicitud</th><th>Obra</th><th>Dirección</th><th>Total</th><th>Fecha de Creación</th><th>Estado</th></tr></thead>";
        echo "<tbody>";

        foreach ($solicitudes as $solicitud) {
            $numero_solicitud = '#' . str_pad($solicitud['id_solicitud'], 4, '0', STR_PAD_LEFT) . '-' . date('Y');
            echo "<tr onclick=\"window.location='detalle_solicitud_r.php?id=" . (isset($solicitud['id_solicitud']) ? htmlspecialchars($solicitud['id_solicitud']) : "") . "';\" style=\"cursor:pointer;\">";
            echo "<td>" . $numero_solicitud . "</td>";
            echo "<td>" . (isset($solicitud['obra']) ? htmlspecialchars($solicitud['obra']) : "") . "</td>";
            echo "<td>" . (isset($solicitud['direccion']) ? htmlspecialchars($solicitud['direccion']) : "") . "</td>";

            // Mostrar el total en formato de peso chileno con el símbolo "$"
            echo "<td>" . (isset($solicitud['total']) ? htmlspecialchars('$' . number_format($solicitud['total'], 0, ',', '.')) : "") . "</td>";
            
            echo "<td>" . (isset($solicitud['fecha_creacion']) ? htmlspecialchars($solicitud['fecha_creacion']) : "") . "</td>";

            

            echo "<td>" . (isset($solicitud['estado']) ? htmlspecialchars($solicitud['estado']) : "") . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
        echo "</div>"; // Cierre del div .table-responsive

    } else {
        echo "<div class='container mt-5'><p>No hay solicitudes registradas.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Error: No se pudo identificar al residente.</p></div>";
}

include("./templates_residente/footer_residente.php"); 
?>
