<?php
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php");

if (!isset($_GET['id'])) {
    header("Location: solicitudes_compra.php");
    exit;
}

$id_solicitud = $_GET['id'];

$querySolicitud = "SELECT * FROM solicitudes_orden_compra WHERE id_solicitud = ?";
$stmt = $conexion->prepare($querySolicitud);
$stmt->bindParam(1, $id_solicitud, PDO::PARAM_INT);
$stmt->execute();
$solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

$queryItems = "SELECT * FROM detalles_solicitud_orden_compra WHERE id_solicitud = ?";
$stmtItems = $conexion->prepare($queryItems);
$stmtItems->bindParam(1, $id_solicitud, PDO::PARAM_INT);
$stmtItems->execute();
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

function actualizarEstado($id_solicitud, $nuevoEstado, $conexion) {
    $query = "UPDATE solicitudes_orden_compra SET estado = ? WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $nuevoEstado, PDO::PARAM_STR);
    $stmt->bindParam(2, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
}

function formatoChileno($numero) {
    return number_format($numero, 0, ',', '.');
}

$cotizacion_url = "http://localhost/proyectooc/secciones/empresas/residente/cotizacion_solicitudes/";
$full_url = $cotizacion_url . $solicitud['archivo_cotizacion'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];

    if ($accion == 'aprobar') {
        actualizarEstado($id_solicitud, 'Aprobado', $conexion);
    } else if ($accion == 'rechazar') {
        actualizarEstado($id_solicitud, 'Rechazado', $conexion);
    }

    $stmt = $conexion->prepare($querySolicitud);
    $stmt->bindParam(1, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar que se obtienen datos
    if (!$solicitud) {
        echo "No se encontró la solicitud.";
    }
}
?>

<div class="container mt-5">
    <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2>Detalle de la Solicitud #<?php echo $id_solicitud; ?></h2>
    </div>
    <div class="card" style="margin: 50px;">
    
    <div class="card-body">
    <!-- Primera fila con Información General y Detalles Financieros -->
    <div class="row mb-4">
    <!-- Columna izquierda con Información General y Detalles Financieros -->
    <div class="col-md-6">
        <div class="text-center">
            <h5 class="text-primary">Información General</h5>
            <p><strong>Obra:</strong> <?php echo $solicitud['obra']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $solicitud['direccion']; ?></p>
            <p><strong>Solicitado por:</strong> <?php echo $solicitud['solicitado_por']; ?></p>
        </div>
        <div class="text-center">
            <h5 class="text-primary">Detalles Financieros</h5>
            <p><strong>Total Neto:</strong> $<?php echo formatoChileno($solicitud['total_neto']); ?></p>
            <p><strong>IVA:</strong> $<?php echo formatoChileno($solicitud['iva']); ?></p>
            <p><strong>Total:</strong> $<?php echo formatoChileno($solicitud['total']); ?></p>
        </div>
    </div>

    <!-- Columna derecha con Detalles de Pago -->
    <div class="col-md-6 text-center">
        <h5 class="text-primary">Detalles de Pago</h5>
        <p><strong>Método de Pago:</strong> <?php echo $solicitud['metodo_pago']; ?></p>
        <p><strong>Nombre de Pago:</strong> <?php echo $solicitud['nombre_pago']; ?></p>
        <p><strong>RUT de Pago:</strong> <?php echo $solicitud['rut_pago']; ?></p>
        <p><strong>Correo de Pago:</strong> <?php echo $solicitud['correo_pago']; ?></p>
        <p><strong>Banco:</strong> <?php echo $solicitud['banco']; ?></p>
        <p><strong>Número de Cuenta:</strong> <?php echo $solicitud['numero_cuenta']; ?></p>
        <?php if ($solicitud['metodo_pago'] == 'credito'): ?>
            <p><strong>Fecha de Pago:</strong> <?php echo $solicitud['fecha_pago']; ?></p>
        <?php endif; ?>
    </div>
</div>

    <!-- Segunda fila con Detalles de Pago y Correo, Banco, etc. -->
    
        <div class="text-center">
            <h5 class="text-primary">Cotización:</h5>
            <a href="<?php echo htmlspecialchars($full_url); ?>" target="_blank" class="btn btn-primary">Ver Cotización</a>
        </div>
    </div>
</div>

<div class="mx-auto w-75"> <!-- Ajusta el w-75 a w-50, w-100, etc., según tus necesidades -->
    <h4 class="text-center text-primary">Ítems de la Solicitud:</h4>
    
<div class="table-responsive mt-4">
    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>Ítem</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total Ítem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <div class="text-truncate" style="max-width: 150px; cursor: pointer;" onclick="showModal('<?php echo htmlspecialchars(addslashes($item['item'])); ?>')">
                            <?php echo htmlspecialchars($item['item']); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 150px; cursor: pointer;" onclick="showModal('<?php echo htmlspecialchars(addslashes($item['descripcion'])); ?>')">
                            <?php echo htmlspecialchars($item['descripcion']); ?>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                    <td>$<?php echo formatoChileno($item['precio_unitario']); ?></td>
                    <td>$<?php echo formatoChileno($item['cantidad'] * $item['precio_unitario']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para mostrar la descripción completa -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDescription">
                <!-- Aquí se mostrará la descripción completa o el ítem -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
    <div class="text-center mt-4">
                <?php if ($solicitud['estado'] == 'En espera') : ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_solicitud; ?>" method="post">
                        <button type="submit" name="accion" value="aprobar" class="btn btn-success">Aprobar</button>
                        <button type="submit" name="accion" value="rechazar" class="btn btn-danger">Rechazar</button>
                    </form>
                <?php else: ?>
                    <?php 
                    $estadoClase = '';
                    switch ($solicitud['estado']) {
                        case 'Aprobado':
                            $estadoClase = 'alert-success';
                            break;
                        case 'Rechazado':
                            $estadoClase = 'alert-danger';
                            break;
                        default:
                            $estadoClase = 'alert-warning';
                            break;
                    }
                    ?>
                    <div class="mx-auto w-50 alert <?php echo $estadoClase; ?>" role="alert">
                        <strong>Estado:</strong> <?php echo $solicitud['estado']; ?>
                    </div>
                <?php endif; ?>
                    
            </div>
            <div class="text-center mt-3">
                <a href="solicitudes_compra.php" class="btn btn-secondary">Volver a Solicitudes</a>
            </div>
            <br>
        </div>
    </div>
</div>

<script>
     function showModal(description) {
        var modalDescription = document.getElementById('modalDescription');
        modalDescription.textContent = description;
        
        var descriptionModal = new bootstrap.Modal(document.getElementById('descriptionModal'));
        descriptionModal.show();
    }
</script>

<?php include("./templates_visitador/footer_visitador.php"); ?>
