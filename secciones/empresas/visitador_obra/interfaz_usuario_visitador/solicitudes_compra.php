<?php
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php");

// Asegúrate de que el ID de la empresa del visitador de obras está en la sesión
$id_empresa = $_SESSION['id_empresa']; 

// Modificar la consulta para obtener todas las solicitudes de la empresa específica, no solo las que están en espera
$query = "SELECT * FROM solicitudes_orden_compra WHERE id_empresa = ?";
$stmt = $conexion->prepare($query);
$stmt->bindParam(1, $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h2 class="mb-4">Solicitudes de Ordenes de Compra</h2>
    <div class="list-group">
        <?php foreach ($solicitudes as $solicitud) : ?>
            <a href="detalle_solicitud.php?id=<?php echo $solicitud['id_solicitud']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Solicitud #<?php echo $solicitud['id_solicitud']; ?></h5>
                    <small>Estado: <?php echo $solicitud['estado']; ?></small>
                </div>
                <p class="mb-1"><strong>Obra:</strong> <?php echo $solicitud['obra']; ?></p>
                <p class="mb-1"><strong>Dirección:</strong> <?php echo isset($solicitud['direccion']) ? $solicitud['direccion'] : 'No especificado'; ?></p>
                <p class="mb-1"><strong>Solicitado por:</strong> <?php echo $solicitud['solicitado_por']; ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php include("./templates_visitador/footer_visitador.php"); ?>