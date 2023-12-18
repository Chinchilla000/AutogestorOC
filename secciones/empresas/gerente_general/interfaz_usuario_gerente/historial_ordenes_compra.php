<?php
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_gerente/header_gerente.php");

$idEmpresaActual = $_SESSION['id_empresa'] ?? null;

function generarIdPersonalizado($nombreEmpresa, $idNumerico) {
    $abreviatura = strtoupper(substr($nombreEmpresa, 0, 3));
    return $abreviatura . "-" . str_pad($idNumerico, 3, '0', STR_PAD_LEFT);
}

$query = "SELECT oc.id_orden_compra, oc.obra, oc.fecha_creacion, oc.total, oc.solicitado_por, oc.estado, e.nombre_empresa FROM ordenes_de_compra oc JOIN empresas e ON oc.id_empresa = e.id WHERE oc.id_empresa = :idEmpresaActual ORDER BY oc.fecha_creacion DESC";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':idEmpresaActual', $idEmpresaActual, PDO::PARAM_INT);
$stmt->execute();
$ordenesCompra = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<br>
<br>

<div class="container mt-4">
    <h2>Historial de Orden de Compra</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>N° Solicitud</th>
                <th>Obra</th>
                <th>Fecha de Creación</th>
                <th>Total</th>
                <th>Solicitado por</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ordenesCompra as $orden): 
                $idPersonalizado = generarIdPersonalizado($orden['nombre_empresa'], $orden['id_orden_compra']);
                $totalFormateado = "$" . number_format($orden['total'], 0, ',', '.');
            ?>
                <tr onclick="window.location='detalle_orden_compra.php?id=<?php echo $orden['id_orden_compra']; ?>'">
                    <td><?php echo htmlspecialchars($idPersonalizado); ?></td>
                    <td><?php echo htmlspecialchars($orden['obra']); ?></td>
                    <td><?php echo htmlspecialchars($orden['fecha_creacion']); ?></td>
                    <td><?php echo htmlspecialchars($totalFormateado); ?></td>
                    <td><?php echo htmlspecialchars($orden['solicitado_por']); ?></td>
                    <td><?php echo htmlspecialchars($orden['estado']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("./templates_gerente/footer_gerente.php"); ?>
