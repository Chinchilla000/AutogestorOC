<?php
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php");

// Asegúrate de que el ID de la empresa del visitador de obras esté en la sesión
$id_empresa = $_SESSION['id_empresa']; 

// Modificar la consulta para obtener todas las solicitudes de la empresa específica, no solo las que están en espera
$query = "SELECT * FROM solicitudes_orden_compra WHERE id_empresa = ?";
$stmt = $conexion->prepare($query);
$stmt->bindParam(1, $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para formatear el número de solicitud
function formatearNumeroSolicitud($id_solicitud) {
    $annoActual = date('Y');
    $numeroSolicitudFormateado = '#' . str_pad($id_solicitud, 4, '0', STR_PAD_LEFT) . '-' . $annoActual;
    return $numeroSolicitudFormateado;
}

function mostrarDetalles($id_solicitud, $conexion) {
    $query = "SELECT * FROM detalles_solicitud_orden_compra WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function actualizarEstado($id_solicitud, $nuevoEstado, $conexion) {
    $query = "UPDATE solicitudes_orden_compra SET estado = ? WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $nuevoEstado, PDO::PARAM_STR);
    $stmt->bindParam(2, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_solicitud = $_POST['id_solicitud'];
    $accion = $_POST['accion'];

    if ($accion == 'aprobar') {
        actualizarEstado($id_solicitud, 'Aprobado', $conexion);
    } else if ($accion == 'rechazar') {
        actualizarEstado($id_solicitud, 'Rechazado', $conexion);
    }

    header("Location: solicitudes_compra.php");
    exit;
}
?>
<div class="container mt-4">
    <h2 class="mb-4">Historial de Solicitudes de Ordenes de Compras</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>N° Solicitud</th>
                    <th>Obra</th>
                    <th>Fecha de creación</th>
                    <th>Total</th>
                    <th>Solicitado por</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solicitudes as $solicitud) : ?>
                    <tr data-id-solicitud="<?php echo $solicitud['id_solicitud']; ?>" onclick="window.location='detalle_solicitud.php?id=<?php echo $solicitud['id_solicitud']; ?>';" style="cursor:pointer;">
                        <td><?php echo htmlspecialchars(formatearNumeroSolicitud($solicitud['id_solicitud'])); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['obra']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['fecha_creacion']);?></td>
                        <td><?php echo htmlspecialchars('$' . number_format($solicitud['total'], 0, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['solicitado_por']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['estado']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.table-hover tr').forEach(row => {
        row.addEventListener('click', () => {
            var idSolicitud = row.getAttribute('data-id-solicitud');
            if (idSolicitud) {
                window.location = '/ProyectoOC/secciones/empresas/visitador_obra/interfaz_usuario_visitador/detalle_solicitud.php?id=' + idSolicitud;
            }
        });
    });
</script>

<?php include("./templates_visitador/footer_visitador.php"); ?>
