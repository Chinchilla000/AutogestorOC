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

<div class="container">
    <h2>Solicitudes de Compra</h2>
    <?php foreach ($solicitudes as $solicitud) : ?>
        <div class="solicitud">
            <h3>Solicitud #<?php echo $solicitud['id_solicitud']; ?></h3>
            <p><strong>Obra:</strong> <?php echo $solicitud['obra']; ?></p>
            <p><strong>Dirección:</strong> <?php echo isset($solicitud['direccion']) ? $solicitud['direccion'] : 'No especificado'; ?></p>
            <p><strong>Solicitado por:</strong> <?php echo $solicitud['solicitado_por']; ?></p>

            <h4>Ítems:</h4>
            <?php $detalles = mostrarDetalles($solicitud['id_solicitud'], $conexion); ?>
            <ul>
                <?php foreach ($detalles as $detalle) : ?>
                    <li><?php echo $detalle['descripcion'] . " - Cantidad: " . $detalle['cantidad'] . " - Precio unitario: " . $detalle['precio_unitario']; ?></li>
                <?php endforeach; ?>
            </ul>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="id_solicitud" value="<?php echo $solicitud['id_solicitud']; ?>">
                <input type="submit" name="accion" value="aprobar" class="btn btn-success">
                <input type="submit" name="accion" value="rechazar" class="btn btn-danger">
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php include("./templates_visitador/footer_visitador.php"); ?>