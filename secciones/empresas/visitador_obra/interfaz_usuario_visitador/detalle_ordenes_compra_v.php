<?php
include("../../../../bd.php");
include("./templates_visitador/header_visitador.php");

if (!isset($_GET['id'])) {
    header("Location: ordenes_compra.php");
    exit;
}

$id_orden_compra = $_GET['id'];

function formatoChileno($numero) {
    return number_format($numero, 0, ',', '.');
}
function generarIdPersonalizado($nombreEmpresa, $idNumerico) {
    $abreviatura = strtoupper(substr($nombreEmpresa, 0, 3));
    return $abreviatura . "-" . str_pad($idNumerico, 3, '0', STR_PAD_LEFT);
}

try {
    $queryOrdenCompra = "SELECT * FROM ordenes_de_compra WHERE id_orden_compra = ?";
    $stmt = $conexion->prepare($queryOrdenCompra);
    $stmt->bindParam(1, $id_orden_compra, PDO::PARAM_INT);
    $stmt->execute();
    $ordenCompra = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ordenCompra) {
        $queryItems = "SELECT * FROM detalles_solicitud_orden_compra WHERE id_orden_compra = ?";
        $stmtItems = $conexion->prepare($queryItems);
        $stmtItems->bindParam(1, $id_orden_compra, PDO::PARAM_INT);
        $stmtItems->execute();
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>

        <div class="container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Orden de Compra N°<?php echo generarIdPersonalizado($nombre_empresa, $id_orden_compra); ?></h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col text-center">
                            <strong>N°: <?php echo generarIdPersonalizado($nombre_empresa, $id_orden_compra); ?></strong>
                        </div>
                        <div class="col text-center">
                            <strong>Fecha de Creación: <?php echo date('d/m/Y', strtotime($ordenCompra['fecha_creacion'])); ?></strong>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Obra:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['obra']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Dirección:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['direccion']; ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Solicitado por:</strong></label>
                        <input type="text" class="form-control" value="<?php echo $ordenCompra['solicitado_por']; ?>" readonly>
                    </div>

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

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label class="form-label"><strong>Total Neto:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" value="<?php echo formatoChileno($ordenCompra['total_neto']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><strong>IVA (19%):</strong></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" value="<?php echo formatoChileno($ordenCompra['iva']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><strong>Total:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" value="<?php echo formatoChileno($ordenCompra['total']); ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Nombre:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['nombre_pago']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>RUT:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['rut_pago']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Correo:</strong></label>
                                    <input type="email" class="form-control" value="<?php echo $ordenCompra['correo_pago']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Banco:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['banco']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Número de Cuenta:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['numero_cuenta']; ?>" readonly>
                                </div>
                                <?php if ($ordenCompra['metodo_pago'] == 'credito'): ?>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Fecha de Pago:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['fecha_pago']; ?>" readonly>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Método de Pago:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['metodo_pago']; ?>" readonly>
                            <?php if ($ordenCompra['estado'] == 'Aprobado' && !empty($ordenCompra['gerente_aprobador'])): ?>
                    <div class="text-center mt-4">
                        <strong>Aprobado por el Gerente:</strong> <?php echo $ordenCompra['gerente_aprobador']; ?><br>
                        <img src="../../../../img/Firma.jpg" alt="Firma del gerente" class="mt-2" style="max-width: 150px;"><br>
                        <strong>Empresa:</strong> <?php echo $nombre_empresa; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($ordenCompra['estado'] == 'Rechazado'): ?>
                    <div class="text-center mt-4">
                        <strong>Rechazado por el Gerente:</strong> <?php echo $ordenCompra['gerente_aprobador']; ?>
                        <br><strong>Estado:</strong>
                        <div class="alert alert-danger" style="display: inline-block; padding: 5px 10px;">
                            Rechazado
                        </div>
                        <br><strong>Empresa:</strong> <?php echo $nombre_empresa; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($ordenCompra['estado'] == 'En espera'): ?>
                    <div class="text-center mt-4">
                        <strong>Estado:</strong>
                        <div class="alert alert-warning" style="display: inline-block; padding: 5px 10px;">
                            En Espera
                        </div>
                    </div>
                    <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-12 text-center mt-3">
                <a href="" class="btn btn-warning btn-lg" target="_blank">Imprimir</a>
            </div>
                </div>
                
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="ordenes_compras.php" class="btn btn-secondary btn-lg">Volver a Historial OC</a>
        </div>
<?php
    } else {
        echo "No se encontraron resultados para esta orden de compra.";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    exit();
}

include("./templates_visitador/footer_visitador.php");
?>
