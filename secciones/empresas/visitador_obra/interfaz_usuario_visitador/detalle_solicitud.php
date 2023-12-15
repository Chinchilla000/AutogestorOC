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

function existeOrdenDeCompra($id_solicitud, $conexion) {
    $query = "SELECT COUNT(*) FROM ordenes_de_compra WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function actualizarEstado($id_solicitud, $nuevoEstado, $conexion) {
    $query = "UPDATE solicitudes_orden_compra SET estado = ? WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $nuevoEstado, PDO::PARAM_STR);
    $stmt->bindParam(2, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
}


function crearOrdenDeCompra($id_solicitud, $conexion) {
    try {
        $conexion->beginTransaction();

        // Usar el id_visitador de la sesión
        $id_visitador = $_SESSION['id_visitador'];

        $stmt = $conexion->prepare("SELECT * FROM solicitudes_orden_compra WHERE id_solicitud = :id_solicitud");
        $stmt->execute(['id_solicitud' => $id_solicitud]);
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexion->prepare("INSERT INTO ordenes_de_compra (id_solicitud, id_visitador, id_empresa, fecha_creacion, obra, direccion, solicitado_por, total_neto, iva, total, metodo_pago, nombre_pago, rut_pago, correo_pago, banco, numero_cuenta, archivo_cotizacion, estado, fecha_pago) VALUES (:id_solicitud, :id_visitador, :id_empresa, NOW(), :obra, :direccion, :solicitado_por, :total_neto, :iva, :total, :metodo_pago, :nombre_pago, :rut_pago, :correo_pago, :banco, :numero_cuenta, :archivo_cotizacion, 'En espera', :fecha_pago)");
        $stmt->execute([
            'id_solicitud' => $id_solicitud,
            'id_visitador' => $_SESSION['id_visitador'],
            'id_empresa' => $solicitud['id_empresa'],
            'obra' => $solicitud['obra'],
            'direccion' => $solicitud['direccion'],
            'solicitado_por' => $solicitud['solicitado_por'],
            'total_neto' => $solicitud['total_neto'],
            'iva' => $solicitud['iva'],
            'total' => $solicitud['total'],
            'metodo_pago' => $solicitud['metodo_pago'],
            'nombre_pago' => $solicitud['nombre_pago'],
            'rut_pago' => $solicitud['rut_pago'],
            'correo_pago' => $solicitud['correo_pago'],
            'banco' => $solicitud['banco'],
            'numero_cuenta' => $solicitud['numero_cuenta'],
            'archivo_cotizacion' => $solicitud['archivo_cotizacion'],
            'fecha_pago' => $solicitud['fecha_pago']
        ]);

        // Obtener el ID de la orden de compra recién creada
        $id_orden_compra = $conexion->lastInsertId();

        // Ahora, actualiza los ítems de la solicitud con el ID de la orden de compra
        $stmt = $conexion->prepare("UPDATE detalles_solicitud_orden_compra SET id_orden_compra = :id_orden_compra WHERE id_solicitud = :id_solicitud");
        $stmt->execute([
            'id_orden_compra' => $id_orden_compra,
            'id_solicitud' => $id_solicitud
        ]);

        $conexion->commit();
    } catch (Exception $e) {
        $conexion->rollBack();
        echo "Error al crear la orden de compra: " . $e->getMessage();
    }
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
        if (!existeOrdenDeCompra($id_solicitud, $conexion)) {
            crearOrdenDeCompra($id_solicitud, $conexion);
        }
        // Redireccionar para evitar duplicados al recargar la página
        header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_solicitud);
        exit;
    } elseif ($accion == 'rechazar') {
        actualizarEstado($id_solicitud, 'Rechazado', $conexion);
        // Posible redirección aquí también si es necesario
    }

    // Cargar nuevamente la solicitud actualizada
    $stmt = $conexion->prepare($querySolicitud);
    $stmt->bindParam(1, $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Solicitud de OC #<?php echo str_pad($id_solicitud, 4, '0', STR_PAD_LEFT) . "-" . date('Y'); ?></h2>
        </div>
        <div class="card-body">
            <!-- Encabezado con número de solicitud y fecha -->
            <div class="row mb-4">
                <div class="col text-center">
                    <strong>Número de Solicitud: <?php echo str_pad($id_solicitud, 4, '0', STR_PAD_LEFT) . "-" . date('Y'); ?></strong>
                </div>
                <div class="col text-center">
                    <strong>Fecha: <?php echo date('d/m/Y'); ?></strong>
                </div>
            </div>

            <!-- Información General -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Obra:</strong></label>
                    <input type="text" class="form-control" value="<?php echo $solicitud['obra']; ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Dirección:</strong></label>
                    <input type="text" class="form-control" value="<?php echo $solicitud['direccion']; ?>" readonly>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><strong>Solicitado por:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['solicitado_por']; ?>" readonly>
            </div>

            <!-- Detalles de los Ítems -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>Ítem</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total Ítem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo $item['item']; ?></td>
                                <td><?php echo $item['descripcion']; ?></td>
                                <td><?php echo $item['unidad']; ?></td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td>$<?php echo formatoChileno($item['precio_unitario']); ?></td>
                                <td>$<?php echo formatoChileno($item['total_item']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

             <!-- Sección Totales -->
             <div class="row mt-4">
    <div class="col-md-4">
        <label class="form-label"><strong>Total Neto:</strong></label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" value="<?php echo formatoChileno($solicitud['total_neto']); ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label"><strong>IVA (19%):</strong></label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" value="<?php echo formatoChileno($solicitud['iva']); ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label"><strong>Total:</strong></label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" value="<?php echo formatoChileno($solicitud['total']); ?>" readonly>
        </div>
    </div>
</div>

            <!-- Método de Pago y Campos Relacionados -->
<div class="row mt-4">
    <!-- Columna izquierda con detalles del método de pago -->
    <div class="col-md-6 mb-3">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label"><strong>Nombre:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['nombre_pago']; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label"><strong>RUT:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['rut_pago']; ?>" readonly>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <label class="form-label"><strong>Correo:</strong></label>
                <input type="email" class="form-control" value="<?php echo $solicitud['correo_pago']; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label"><strong>Banco:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['banco']; ?>" readonly>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <label class="form-label"><strong>Número de Cuenta:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['numero_cuenta']; ?>" readonly>
            </div>
            <?php if ($solicitud['metodo_pago'] == 'credito'): ?>
            <div class="col-md-6">
                <label class="form-label"><strong>Fecha de Pago:</strong></label>
                <input type="text" class="form-control" value="<?php echo $solicitud['fecha_pago']; ?>" readonly>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Columna derecha con selección de método de pago -->
    <div class="col-md-6 mb-3">
        <label class="form-label"><strong>Método de Pago:</strong></label>
        <select class="form-select" disabled>
            <option value="efectivo" <?php echo ($solicitud['metodo_pago'] == 'efectivo') ? 'selected' : ''; ?>>Efectivo</option>
            <option value="credito" <?php echo ($solicitud['metodo_pago'] == 'credito') ? 'selected' : ''; ?>>Crédito</option>
        </select>
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
             <!-- Botón para la Cotización -->
             <div class="col-md-12 text-center mt-3">
                <a href="<?php echo $full_url; ?>" class="btn btn-warning btn-lg" target="_blank">Ver Cotización</a>
            </div>

            </div>
         </div>
                <!-- Botones de Aprobar/Rechazar y Estado de la Solicitud -->
                <div class="col-md-6 text-center">
                    <?php if ($solicitud['estado'] == 'En espera') : ?>
                        <!-- Formulario de acción para Aprobar/Rechazar -->
                    <?php else: ?>
                        <!-- Mostrar el estado de la solicitud -->
                    <?php endif; ?>
                    
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="solicitudes_compra.php" class="btn btn-secondary btn-lg">Volver a Historial</a>
                
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
