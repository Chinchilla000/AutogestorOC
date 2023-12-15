<?php
include("../../../../bd.php");
include("./templates_gerente/header_gerente.php"); 
// Obtener el ID de la empresa del usuario actual
$idEmpresaActual = $_SESSION['id_empresa'] ?? null;

// Función para generar el ID personalizado
function generarIdPersonalizado($nombreEmpresa, $idNumerico) {
    $abreviatura = strtoupper(substr($nombreEmpresa, 0, 3)); // Toma las primeras tres letras del nombre de la empresa y las convierte en mayúsculas
    return $abreviatura . "-" . str_pad($idNumerico, 3, '0', STR_PAD_LEFT);
}

// Consulta para obtener todas las órdenes de compra de la empresa actual
$query = "SELECT oc.id_orden_compra, oc.fecha_creacion, oc.estado, oc.total, oc.archivo_cotizacion, e.nombre_empresa FROM ordenes_de_compra oc 
          JOIN empresas e ON oc.id_empresa = e.id 
          WHERE e.id = :idEmpresaActual
          ORDER BY oc.fecha_creacion DESC";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':idEmpresaActual', $idEmpresaActual, PDO::PARAM_INT);
$stmt->execute();
$ordenesCompra = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='container mt-4'>";
echo "<h2>Órdenes de Compras Generadas</h2>";
echo "<div class='table-responsive'>";
echo "<table class='table table-hover'>";
echo "<thead><tr><th>ID Orden</th><th>Fecha Creación</th><th>Total</th><th>Archivo Cotización</th><th>Estado</th></tr></thead>";
echo "<tbody>";

foreach ($ordenesCompra as $orden) {
    $idPersonalizado = generarIdPersonalizado($orden['nombre_empresa'], $orden['id_orden_compra']);
    
    echo "<tr>";
    echo "<td>" . htmlspecialchars($idPersonalizado) . "</td>";
    echo "<td>" . htmlspecialchars($orden['fecha_creacion']) . "</td>";
    $totalFormateado = "$" . number_format($orden['total'], 0, ',', '.');
    echo "<td>" . htmlspecialchars($totalFormateado) . "</td>";
    echo "<td>";
    if (!empty($orden['archivo_cotizacion'])) {
        $urlCompleto = $url_cotizacion . htmlspecialchars($orden['archivo_cotizacion']);
        echo "<a href='" . $urlCompleto . "' target='_blank'>Ver Cotización</a>";
    } else {
        echo "No disponible";
    }
    echo "<td>" . htmlspecialchars($orden['estado']) . "</td>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody></table></div>";
echo "</div>";

include("./templates_gerente/footer_gerente.php");  ?>
