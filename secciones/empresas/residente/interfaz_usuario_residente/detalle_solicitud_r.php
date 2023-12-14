<?php
include("../../../../bd.php");
include("./templates_residente/header_residente.php");

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

function formatoChileno($numero) {
    return number_format($numero, 0, ',', '.');
}

$cotizacion_url = "http://localhost/proyectooc/secciones/empresas/residente/cotizacion_solicitudes/";
$full_url = $cotizacion_url . $solicitud['archivo_cotizacion'];
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
                    <label class="form-label">Obra:</label>
                    <input type="text" class="form-control" value="<?php echo $solicitud['obra']; ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dirección:</label>
                    <input type="text" class="form-control" value="<?php echo $solicitud['direccion']; ?>" readonly>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Solicitado por:</label>
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
        <label class="form-label">Total Neto:</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" value="<?php echo formatoChileno($solicitud['total_neto']); ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">IVA (19%):</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" value="<?php echo formatoChileno($solicitud['iva']); ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Total:</label>
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
                            <label class="form-label">Nombre:</label>
                            <input type="text" class="form-control" value="<?php echo $solicitud['nombre_pago']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RUT:</label>
                            <input type="text" class="form-control" value="<?php echo $solicitud['rut_pago']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Correo:</label>
                            <input type="email" class="form-control" value="<?php echo $solicitud['correo_pago']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Banco:</label>
                            <input type="text" class="form-control" value="<?php echo $solicitud['banco']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Número de Cuenta:</label>
                            <input type="text" class="form-control" value="<?php echo $solicitud['numero_cuenta']; ?>" readonly>
                        </div>
                        <?php if ($solicitud['metodo_pago'] == 'credito'): ?>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Pago:</label>
                            <input type="text" class="form-control" value="<?php echo $solicitud['fecha_pago']; ?>" readonly>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

               <!-- Columna derecha con selección de método de pago -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Método de Pago:</label>
        <select class="form-select" disabled>
            <option value="efectivo" <?php echo ($solicitud['metodo_pago'] == 'efectivo') ? 'selected' : ''; ?>>Efectivo</option>
            <option value="credito" <?php echo ($solicitud['metodo_pago'] == 'credito') ? 'selected' : ''; ?>>Crédito</option>
        </select>
        <div class="text-center mt-4">
                
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
                    
            </div>

            <!-- Botón para la Cotización -->
            <div class="col-md-12 text-center mt-3">
                <a href="<?php echo $full_url; ?>" class="btn btn-warning btn-lg" target="_blank">Ver Cotización</a>
            </div>
            </div>
            <div class="text-center mt-3">
                <a href="historial_solicitudes.php" class="btn btn-secondary btn-lg">Volver a Historial</a>
            </div>
        </div>
    </div>
</div>

<?php include("./templates_residente/footer_residente.php"); ?>
